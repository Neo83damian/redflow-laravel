<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Returns only the authenticated user's own notifications, shaped as
     * { [userId]: [...] } — the exact structure loadNotificationsStore()
     * already expects, so getCurrentUserNotifications() keeps working
     * completely unchanged.
     *
     * No auto-expiry here — notifications are only ever removed by an
     * explicit Delete / Clear All action from the user themselves.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $notifs = AppNotification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get()
            ->map->toFrontendArray();

        return response()->json([
            // IMPORTANT: keyed by $user->uuid, NOT $user->id. The frontend's
            // "currentUser.id" (see User::toFrontendArray()) is the UUID —
            // using the numeric database id here would mean this key never
            // matches store[currentUser.id] in script-legacy.js, so no
            // notification would ever appear no matter how many were created.
            'notifications' => [$user->uuid => $notifs],
        ]);
    }

    /**
     * Deletes one of the authenticated user's own notifications. The id
     * arrives as "notif_{id}" (see AppNotification::toFrontendArray).
     */
    public function destroy(Request $request, string $notifId)
    {
        $id = str_replace('notif_', '', $notifId);
        AppNotification::where('user_id', $request->user()->id)->where('id', $id)->delete();

        return response()->json(['message' => 'Deleted.']);
    }

    public function clear(Request $request)
    {
        AppNotification::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Cleared.']);
    }
}
