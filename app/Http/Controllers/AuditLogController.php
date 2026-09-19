<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Entries with action_label set are shown here — that covers the five
     * app-facing categories (Create, Update, Delete, Export, Change), which
     * matches renderAuditLogView() on the frontend. Plain system/security
     * events written via AuditLog::record() (login, logout, register,
     * password_reset, approve/reject staff) have no action_label and are
     * intentionally excluded — this page is the Create/Update/Delete/
     * Export/Change trail specifically, not a full security log.
     */
    public function index()
    {
        $entries = AuditLog::whereNotNull('action_label')
            ->orderByDesc('logged_at')
            ->limit(200) // mirrors AUDIT_LOG_MAX_ENTRIES already enforced client-side
            ->get()
            ->map->toFrontendArray();

        return response()->json(['entries' => $entries]);
    }

    /**
     * Records an Export event (Donor Masterlist CSV export) — the only one
     * of the five audit categories that isn't already tied to a donor/
     * record create-update-delete request, so it gets its own small
     * endpoint the frontend calls right after generating the CSV.
     */
    public function logExport(Request $request)
    {
        $count = (int) $request->input('count', 0);
        AuditLog::recordDonorAction($request->user()?->id, 'Export', null, null, "Full Masterlist ({$count} donor" . ($count === 1 ? '' : 's') . ')');

        return response()->json(['message' => 'Logged.']);
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        AuditLog::whereIn('id', $ids)->delete();

        return response()->json(['deleted' => count($ids)]);
    }

    public function clear()
    {
        AuditLog::whereNotNull('action_label')->delete();

        return response()->json(['message' => 'Cleared.']);
    }
}
