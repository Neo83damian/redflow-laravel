<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\AppNotification;
use App\Models\AuditLog;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Models\UserLog;
use App\Services\ImageCryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected const MAX_ATTEMPTS = 5;
    protected const LOCKOUT_SECONDS = 60;

    public function showEntry()
    {
        // Serves the single-shell page (login view + all modals + the shared
        // staff/admin app container) — the frontend JS handles which parts
        // are visible, exactly as in the original DOME-4-1-2.html prototype.
        return view('entry');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = strtolower($data['email']);
        $user = User::where('email', $email)->first();

        if ($user && $user->isLocked()) {
            $seconds = now()->diffInSeconds($user->locked_until, false);
            return response()->json([
                'message' => "Error: Too many failed login attempts. Please wait {$seconds} second(s) before trying again.",
            ], 423);
        }

        if (!$user || !Hash::check($data['password'], $user->password)) {
            if ($user) {
                $user->failed_login_attempts++;
                if ($user->failed_login_attempts >= self::MAX_ATTEMPTS) {
                    $user->locked_until = now()->addSeconds(self::LOCKOUT_SECONDS);
                    $user->failed_login_attempts = 0;
                }
                $user->save();
            }
            return response()->json(['message' => 'Error: Incorrect Email or Password! Please check your credentials.'], 401);
        }

        if ($user->status === 'Pending') {
            return response()->json(['message' => 'Your Staff Account is still waiting for Admin approval.'], 403);
        }

        // Correct credentials — clear any prior failed-attempt lockout state
        $user->failed_login_attempts = 0;
        $user->locked_until = null;
        $user->last_login_at = now();
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        UserLog::create([
            'user_id' => $user->id,
            'event' => 'login',
            'occurred_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        // Defense-in-depth against duplicate login notifications: if a
        // double-click/double-submit still slips a second /login request
        // through within a few seconds, don't create a second identical
        // notification for the same account.
        $recentDuplicate = AppNotification::where('user_id', $user->id)
            ->where('message', 'like', 'Your account (%) was logged in and used.')
            ->where('created_at', '>=', now()->subSeconds(10))
            ->exists();

        if (!$recentDuplicate) {
            // No date/time is baked into the message text itself — the
            // notification's stored created_at timestamp is the single
            // source of truth, and the frontend renders it consistently
            // (formatLoginTimestamp) everywhere a timestamp is shown. An
            // embedded date here (server timezone, plain text) used to be
            // able to show a different date/time than the footer below it
            // (client-rendered from the same event's real timestamp).
            AppNotification::create([
                'user_id' => $user->id,
                'message' => "Your account ({$user->role}) was logged in and used.",
            ]);
        }

        AuditLog::record($user->id, 'login', "{$user->name} ({$user->role}) logged in.");

        // Like logout(), session()->regenerate() above also rotates the CSRF
        // token for security. Since this is a single-page app (no full page
        // reload happens after a successful login), the frontend needs the
        // new token sent back so it can refresh its <meta name="csrf-token">
        // tag — otherwise the very next POST/PUT/DELETE after logging in
        // (change password, create a donor, etc.) would fail with a 419
        // "CSRF token mismatch".
        return response()->json([
            'user' => $user->toFrontendArray(),
            'csrf_token' => csrf_token(),
        ]);
    }

    public function register(Request $request, ImageCryptoService $crypto)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'contact' => 'required|string|max:50',
            'brgy' => 'required|string|max:255',
            'gender' => 'nullable|string|max:50',
            'dob' => 'nullable|date',
            'idFront' => 'nullable|string',
            'idBack' => 'nullable|string',
            'faceDoc' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => $data['password'], // hashed automatically via the 'hashed' cast on the model
            'contact' => $data['contact'],
            'brgy' => $data['brgy'],
            'gender' => $data['gender'] ?? null,
            'dob' => $data['dob'] ?? null,
            'role' => 'Staff',
            'status' => 'Pending',
            'action_taken' => 'Registered',
            'id_front_path' => $crypto->storeEncrypted($data['idFront'] ?? null, 'ids'),
            'id_back_path' => $crypto->storeEncrypted($data['idBack'] ?? null, 'ids'),
            'face_doc_path' => $crypto->storeEncrypted($data['faceDoc'] ?? null, 'selfies'),
        ]);

        AuditLog::record($user->id, 'register', "{$user->name} submitted a Staff sign-up request.");

        return response()->json(['user' => $user->toFrontendArray()], 201);
    }

    public function logout(Request $request)
    {
        if ($user = Auth::user()) {
            AuditLog::record($user->id, 'logout', "{$user->name} logged out.");
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Since the frontend does NOT reload the page after logout (it just
        // swaps the visible view back to the login screen, to stay a true
        // single-page app), the <meta name="csrf-token"> embedded at the
        // original page load is now stale — the line above just rotated it
        // for security. Sending the new token back here lets the frontend
        // update that meta tag in place, so the very next login/forgot-
        // password request isn't rejected with a 419 "CSRF token mismatch".
        return response()->json([
            'message' => 'Logged out.',
            'csrf_token' => csrf_token(),
        ]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Error: No logged in account found.'], 401);
        }

        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'Error: Current Password is incorrect.'], 422);
        }

        $user->password = $data['password']; // re-hashed automatically via the model cast
        $user->save();

        AuditLog::record($user->id, 'change_password', "{$user->name} changed their password.");
        // Also visible on the app's Audit Log page (red "Change" badge).
        // Details is always the literal text "Change Password" — the
        // actual password (old or new) is never written to the log.
        AuditLog::recordDonorAction($user->id, 'Change', null, null, 'Change Password');

        return response()->json(['message' => 'Password updated successfully!']);
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        $email = strtolower($data['email']);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'Error: No account found with that email address.'], 404);
        }

        $code = (string) random_int(100000, 999999);

        PasswordResetOtp::create([
            'email' => $email,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
            'consumed' => false,
        ]);

        // Sends via whatever MAIL_MAILER is configured in .env (e.g. Gmail SMTP).
        // If mail isn't configured yet, Laravel's "log" driver writes it to
        // storage/logs/laravel.log instead, so local testing still works.
        Mail::to($email)->send(new OtpMail($code));

        return response()->json(['message' => 'Verification code sent.']);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        if (!$this->findValidOtp(strtolower($data['email']), $data['code'])) {
            return response()->json(['message' => 'Error: Invalid verification code. Please try again.'], 422);
        }

        return response()->json(['message' => 'Code verified.']);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $email = strtolower($data['email']);
        $otp = $this->findValidOtp($email, $data['code']);
        if (!$otp) {
            return response()->json(['message' => 'Error: Invalid or expired verification code.'], 422);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'Error: No account found with that email address.'], 404);
        }

        $user->password = $data['password']; // re-hashed automatically via the model cast
        $user->save();

        $otp->consumed = true;
        $otp->save();

        AuditLog::record($user->id, 'password_reset', "{$user->name} reset their password via email OTP.");

        return response()->json(['message' => 'Password successfully reset!']);
    }

    protected function findValidOtp(string $email, string $code): ?PasswordResetOtp
    {
        $candidates = PasswordResetOtp::where('email', $email)
            ->where('consumed', false)
            ->where('expires_at', '>=', now())
            ->orderByDesc('id')
            ->get();

        foreach ($candidates as $otp) {
            if (Hash::check($code, $otp->code_hash)) {
                return $otp;
            }
        }

        return null;
    }
}
