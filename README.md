# REDFLOW — Laravel Migration Package

Built from your re-uploaded `DOME-4-1-2.html` prototype. See `MIGRATION_GUIDE.md` for full setup steps.

## Preserved exactly, untouched
- All CSS (`public/css/app-legacy.css`, 1,532 lines) — copied verbatim, plus the same viewport/font-size fix applied before (the re-uploaded file had `initial-scale=0.7` again, which shrinks all text on mobile/laptop; this is fixed back to `1.0`).
- All HTML structure/markup — the login view, all modals (Forgot Password, Staff Sign Up wizard, Admin approval, image zoom), and the shared staff/admin app container are extracted as-is into `resources/views/partials/`.
- Almost all JavaScript logic (`public/js/script-legacy.js`, 2,417 lines) — every function kept, only the specific functions listed below were patched.

## What was patched, and why
Only the functions that talk to accounts/passwords/donors/records/notifications/audit-log were changed — everything else in script-legacy.js (rendering, filtering, wizards, camera capture, dark mode, CSV export, etc.) is untouched:

| Function | Before | After |
|---|---|---|
| `handleLogin` | Checked a local JS array; had a hardcoded `redflow@gmail.com`/`admin123` fallback | Calls `POST /login`; hardcoded fallback removed; 5-attempt/60s lockout + bcrypt enforced server-side |
| `confirmSuSignup` | Pushed straight to `localStorage`, plaintext password | Calls `POST /register`; bcrypt hash + AES-256 encrypted ID/selfie storage happen server-side |
| `approveStaff` / `rejectStaff` | Only updated `localStorage` | Calls `PATCH /admin/staff/{id}/approve` and `DELETE /admin/staff/{id}/reject` so the database status the login check relies on actually changes |
| `confirmLogout` | Cleared `localStorage` only | Also calls `POST /logout` to end the real server session |
| `validateAndChangePassword` | Compared plaintext strings in `localStorage` | Calls `POST /change-password`; current password verified against the bcrypt hash server-side |
| `validateFpStep1` / `resendFpCode` / `validateFpStep2` / `validateFpResetPassword` | Client-side EmailJS with placeholder `"YOUR_SERVICE_ID"` keys (never actually configured) | Calls real `/forgot-password/send-otp`, `/verify-otp`, `/reset` endpoints — OTP is generated, bcrypt-hashed, and emailed server-side |
| `commitNewDonor` | Pushed straight to `localStorage`, client-guessed id | Calls `POST /api/donors`; server assigns the real database id |
| `updateDonorProfileData` | Saved edits to `localStorage` only | Calls `PUT /api/donors/{id}`; change is persisted to MySQL and logged to the Audit Log server-side |
| `deleteSelectedDonors` | Removed from `localStorage` only | Calls `DELETE /api/donors` with the selected ids first |
| `approveAndCommitHistoryRecord` | New-Donation-vs-Last-Donation logic computed client-side, saved to `localStorage` only | Same client-side logic (untouched) now also calls `POST /api/donation-records` to persist the result, and `PUT /api/donors/{id}` to sync the donor's Last Donation/Times Donated |
| `deleteSelectedRecords` | Removed from `localStorage` only | Calls `DELETE /api/donation-records` with the selected ids first |
| `deleteNotification` / `clearAllNotifications` | `localStorage` only | Calls `DELETE /api/notifications/{id}` / `DELETE /api/notifications` |
| `deleteSelectedAuditLogEntries` / `clearAuditLog` | `localStorage` only | Calls `DELETE /api/audit-log/bulk` / `DELETE /api/audit-log` |
| `updateStaffProfileData` | `localStorage` only | Calls `PUT /api/profile`; account fields saved to the `users` table |
| *(new)* `bootstrapRedflowData()` | — | Runs on page load / after login: fetches Donors, History Records, Notifications, Audit Log (and, for Admins, the full account list) from MySQL and re-renders the existing views with it — this is what makes the Statistics Dashboard, Donor Masterlist, and History Records show real shared data across every device/browser instead of only one browser's localStorage |

## Intentionally left as browser-only (minor, not database-backed)
- Profile photo upload for a Staff/Admin's own avatar (`handleProfileImageUpload`) still stores the image as a base64 data URL in the browser only — not yet synced to the database. Everything else on the Account Information page (name, sex, birthday, address, email, contact) now saves via `PUT /api/profile`.
- The Donor Audit Log's **"View"** entries (opening a donor's profile) and **"Export"** entries (CSV export) are still logged client-side only, since these are frequent, low-stakes, read-only events — "Create"/"Update"/"Delete" are the ones persisted to the database.

## Requirements this migration satisfies
- ✅ 5-attempt / 60-second login lockout (server-enforced)
- ✅ `picture.jpg` used as the universal profile/approval-photo fallback
- ✅ ID front/back photos and selfies encrypted (AES-256, via Laravel's `Crypt` facade / APP_KEY)
- ✅ Passwords bcrypt-hashed (Laravel's automatic `'hashed'` cast)
- ✅ No hardcoded admin or donor accounts anywhere in code — the only account created is via `AdminSeeder`, which itself hashes the password at seed time
- ✅ OTP sent directly to the user's real email (Laravel Mail, not client-side EmailJS)
- ✅ Change Password requires the current password to match before allowing a new one, with an eye-icon show/hide toggle (unchanged UI, now backed by a real check)
- ✅ Staff-approved notification and login-notification alerts (`AppNotification` model, unchanged frontend rendering)
- ✅ Donor Masterlist, History Records, Statistics Dashboard, Notifications, and (donor-focused) Audit Log all persist to MySQL — shared across every device/browser, not siloed per-browser localStorage anymore
- ✅ `window.functionName = functionName` explicit global exports added for all 114 top-level functions at the bottom of `public/js/script-legacy.js` — future-proofs every `onclick="..."` handler in the HTML

## Fixed this pass
- ✅ **Added missing `sessions` table migration** — `.env.example` sets `SESSION_DRIVER=database`, but the migration for it was missing, which would have caused real session/CSRF errors ("CSRF token mismatch") the moment the app tried to log anyone in. Fixed.
- ✅ **CSRF/session-expiry guard** — a small `window.fetch` wrapper now catches HTTP 419 ("Page Expired") responses globally and shows a clear message + auto-refreshes the page, instead of every POST/PUT/DELETE silently failing with a confusing error if the session ever expires.
- ✅ **Eye icon on all 3 Account Security password fields** (Current/New/Confirm) — these had no show/hide toggle before; now all three have the same `fa-solid fa-eye` / `fa-eye-slash` icon toggle already used on Login/Sign Up.
- ✅ **Notifications now auto-expire after 1 month** — pruned automatically every time the Notification tab loads (no cron/scheduler needed on the server).
- ✅ Confirmed already correct (no change needed): no hardcoded admin/donor/staff data anywhere in `script-legacy.js` (all data arrays start empty and are hydrated from MySQL); Monthly Donations already buckets by each record's actual donation year/month; the History Records count (`statNumberHistory`) already reflects every record system-wide regardless of who created it; changing your email in Profile already updates the same `users.email` column used for login and for receiving the Forgot Password OTP.

## Critical CSRF fix this pass
- ✅ **Fixed stale CSRF token after login AND after logout.** Both `login()` and `logout()` call Laravel's `session()->regenerate()` / `regenerateToken()` for security — which issues a brand-new CSRF token server-side. Since REDFLOW is a single-page app (the page is never reloaded after logging in or out, just swapped between views by JS), the `<meta name="csrf-token">` tag from the original page load was going stale right after both actions. This meant the *next* write request (change password, create a donor, log out again, etc.) could fail with a 419 "CSRF token mismatch" — exactly the failure mode you asked about. Both endpoints now return the fresh token in their JSON response, and the frontend updates the meta tag immediately, so every subsequent request stays correctly authenticated.
- Forgot Password does **not** touch the session/token at all (verified — no `regenerate()`/`invalidate()` calls anywhere in that flow), so it was never affected by this issue.

## Critical notification fix this pass
- ✅ **Fixed the actual reason notifications never appeared.** `User::toFrontendArray()` (used everywhere in the frontend, including `currentUser.id`) returns the account's UUID as `id`. But `NotificationController::index()` was keying its response by `$user->id` — Eloquent's plain numeric database ID — instead of `$user->uuid`. Since `getCurrentUserNotifications()` in script-legacy.js looks up `store[currentUser.id]` (a UUID), that key never matched a numeric ID, so the store always came back empty — no badge dot, no messages, nothing, no matter how many notifications were actually created server-side. Fixed by keying the response with `$user->uuid` instead.

## New this pass
- ✅ **"Donor Masterlist" added to the sidebar Menu** for both Admin and Staff — opens the exact same content as the Home tab (`renderDonorCards()`), just a second, explicitly-labeled entry point to it.
- ✅ **Staff Menu: "About Us" removed** (replaced by Donor Masterlist above) — still reachable via the bottom navigation bar for Staff, so nothing was lost, just de-duplicated from the side Menu.
- Confirmed already correct (no change needed): Last Donation is editable only inside a record's **detail view** (`openEditLastDonationModal` / `saveEditedLastDonation`, opened by tapping a record) — the **Record Navigation list itself** only ever displays it as plain text, never as an inline-editable field.
- Reminder on real email OTP delivery: `MAIL_MAILER=log` in `.env.example` is intentional for local testing (the OTP gets written to `storage/logs/laravel.log` instead of a real inbox, so you can test the flow with zero setup). For the OTP to actually arrive in a real inbox, you must set `MAIL_MAILER=smtp` plus a real Gmail **App Password** (not your normal Gmail password) in `.env` — see the commented example block already in `.env.example`.
