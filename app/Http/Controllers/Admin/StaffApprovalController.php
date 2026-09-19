<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StaffApprovalController extends Controller
{
    public function approve(Request $request, string $uuid)
    {
        $staff = User::where('uuid', $uuid)->where('role', 'Staff')->firstOrFail();
        $staff->status = 'Approved';
        $staff->action_taken = 'Approved';
        // Defensive: only set approved_by/approved_at if those columns
        // actually exist on this database. Without this guard, a database
        // that hasn't had `php artisan migrate` run for the
        // add_approved_by_to_users_table migration throws a hard 500
        // ("no such column: approved_by") and Approve silently fails —
        // this lets Approve still work (just without the "Approved by"
        // attribution) until migrations are brought up to date.
        if (Schema::hasColumn('users', 'approved_by')) {
            $staff->approved_by = $request->user()?->id;
        }
        if (Schema::hasColumn('users', 'approved_at')) {
            $staff->approved_at = now();
        }
        $staff->save();

        AppNotification::create([
            'user_id' => $staff->id,
            'message' => 'Good news! Your Staff account has been approved by the Admin. You can now log in and start using REDFLOW.',
        ]);

        AuditLog::record($request->user()?->id, 'approve_staff', "Approved staff account: {$staff->name} ({$staff->email}).");

        return response()->json(['user' => $staff->toFrontendArray()]);
    }

    public function reject(Request $request, string $uuid)
    {
        $staff = User::where('uuid', $uuid)->where('role', 'Staff')->firstOrFail();
        $name = $staff->name;
        $email = $staff->email;
        $staff->delete();

        AuditLog::record($request->user()?->id, 'reject_staff', "Rejected staff sign-up request: {$name} ({$email}).");

        return response()->json(['message' => 'Rejected.']);
    }
}
