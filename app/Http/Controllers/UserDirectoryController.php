<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserDirectoryController extends Controller
{
    /**
     * Boots the `systemUsers` array on page load with every account in the
     * database (needed so Admin's Staff Approval list and Users Log show
     * accounts registered in other sessions/devices, not just the current
     * browser's localStorage).
     */
    public function index()
    {
        return response()->json([
            'users' => User::orderBy('id')->get()->map->toFrontendArray(),
        ]);
    }

    /**
     * Deletes a single user account. An Admin can never be deleted while
     * they are the only Admin left — without this check, the system could
     * end up with zero Admin accounts and nobody left who can approve
     * Staff, manage the Audit Log, etc.
     */
    public function destroy(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if ($user->role === 'Admin' && User::where('role', 'Admin')->count() <= 1) {
            return response()->json(['message' => 'The last remaining Admin account cannot be deleted.'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'Deleted.']);
    }

    /**
     * Bulk delete — same last-Admin protection, applied per-row so a batch
     * that includes the last Admin still deletes everyone else and reports
     * exactly which one it skipped, instead of failing the whole batch.
     */
    public function destroyBulk(\Illuminate\Http\Request $request)
    {
        $uuids = $request->input('ids', []);
        $skipped = [];

        foreach (User::whereIn('uuid', $uuids)->get() as $user) {
            if ($user->role === 'Admin' && User::where('role', 'Admin')->count() <= 1) {
                $skipped[] = $user->name;
                continue;
            }
            $user->delete();
        }

        return response()->json(['message' => 'Deleted.', 'skipped' => $skipped]);
    }
}
