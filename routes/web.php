<?php

use App\Http\Controllers\Admin\StaffApprovalController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationRecordController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecureImageController;
use App\Http\Controllers\UserDirectoryController;
use Illuminate\Support\Facades\Route;

// Single-shell entry point: serves the login view + all modals + the shared
// staff/admin app container in one page, exactly as in DOME-4-1-2.html.
// The existing frontend JS (script-legacy.js) handles show/hide between
// them — unchanged, per "wag baguhin ang structure/design".
Route::get('/', [AuthController::class, 'showEntry'])->name('entry');

// Lets the frontend recover from a stale/expired CSRF token without a full
// page reload — apiRequest() in script-legacy.js calls this once and
// retries the original request when it gets a 419.
Route::get('/csrf-token', fn () => response()->json(['csrf_token' => csrf_token()]))->name('csrf-token');

// Auth (public)
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/forgot-password/send-otp', [AuthController::class, 'sendOtp'])->name('forgot-password.send-otp');
Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyOtp'])->name('forgot-password.verify-otp');
Route::post('/forgot-password/reset', [AuthController::class, 'resetPassword'])->name('forgot-password.reset');

// Auth (requires an active session). throttle:120,1 caps each user at 120
// requests/minute on these endpoints — generous for normal use, but stops
// a runaway client-side loop or a scripted flood from ever taking the
// server down.
Route::middleware(['auth', 'throttle:120,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::put('/api/profile', [ProfileController::class, 'update'])->name('api.profile.update');
    Route::get('/secure-image/{userId}/{field}', [SecureImageController::class, 'show'])->name('secure-image');

    Route::get('/api/users', [UserDirectoryController::class, 'index'])->name('api.users');
    Route::delete('/api/users/bulk', [UserDirectoryController::class, 'destroyBulk'])->name('api.users.destroy-bulk');
    Route::delete('/api/users/{uuid}', [UserDirectoryController::class, 'destroy'])->name('api.users.destroy');

    Route::get('/api/donors', [DonorController::class, 'index'])->name('api.donors.index');
    Route::post('/api/donors', [DonorController::class, 'store'])->name('api.donors.store');
    Route::put('/api/donors/{donor}', [DonorController::class, 'update'])->name('api.donors.update');
    Route::delete('/api/donors', [DonorController::class, 'destroyBulk'])->name('api.donors.destroy-bulk');

    Route::get('/api/donation-records', [DonationRecordController::class, 'index'])->name('api.records.index');
    Route::post('/api/donation-records', [DonationRecordController::class, 'upsert'])->name('api.records.upsert');
    Route::delete('/api/donation-records', [DonationRecordController::class, 'destroyBulk'])->name('api.records.destroy-bulk');

    Route::get('/api/notifications', [NotificationController::class, 'index'])->name('api.notifications.index');
    Route::delete('/api/notifications/{notifId}', [NotificationController::class, 'destroy'])->name('api.notifications.destroy');
    Route::delete('/api/notifications', [NotificationController::class, 'clear'])->name('api.notifications.clear');

    Route::get('/api/audit-log', [AuditLogController::class, 'index'])->name('api.audit-log.index');
    Route::post('/api/audit-log/export', [AuditLogController::class, 'logExport'])->name('api.audit-log.export');
    Route::delete('/api/audit-log/bulk', [AuditLogController::class, 'destroyBulk'])->name('api.audit-log.destroy-bulk');
    Route::delete('/api/audit-log', [AuditLogController::class, 'clear'])->name('api.audit-log.clear');
});

// Admin-only. Uses the EnsureAdmin::class directly (not the 'admin' alias)
// so this works even if the alias registration step in bootstrap/app.php
// was never added — a fully-qualified middleware class always works
// without any config file editing, which is almost certainly why Approval
// Verification wasn't actually approving anything before: this whole
// route group would 500 ("Target class [admin] does not exist") if that
// one manual step was missed, which silently breaks Approve/Reject.
Route::middleware(['auth', \App\Http\Middleware\EnsureAdmin::class])->prefix('admin')->group(function () {
    Route::patch('/staff/{uuid}/approve', [StaffApprovalController::class, 'approve'])->name('admin.staff.approve');
    Route::delete('/staff/{uuid}/reject', [StaffApprovalController::class, 'reject'])->name('admin.staff.reject');
});
