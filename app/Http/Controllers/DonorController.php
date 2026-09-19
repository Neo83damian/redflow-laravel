<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Returns every donor as the same flat JSON object shape the frontend
     * already stores in localStorage — this is what boots `donorsData` on
     * page load instead of the (now-removed) hardcoded sample donors.
     */
    public function index()
    {
        return response()->json([
            'donors' => Donor::orderBy('id')->get()->map->toFrontendArray(),
        ]);
    }

    /**
     * Accepts the full donor object exactly as built by commitNewDonor() in
     * script-legacy.js, stores it verbatim, and returns it back with the
     * real database id (the frontend replaces its client-guessed id with
     * this one, so ids never collide across sessions/devices).
     */
    public function store(Request $request)
    {
        $body = $request->all();

        $donor = Donor::create([
            'donor_uid' => 'donor_' . uniqid(),
            'name' => $body['name'] ?? '',
            'blood_type' => $body['bloodType'] ?? null,
            'contact' => $body['contact'] ?? null,
            'brgy' => $body['brgy'] ?? null,
            'gender' => $body['gender'] ?? null,
            'dob' => $body['bday'] ?? null,
            'avatar_path' => null, // avatars stay client-side base64/picture.jpg for now, same as before
            'extra' => $body,
        ]);

        AuditLog::recordDonorAction($request->user()?->id, 'Create', $donor->id, $donor->name);

        return response()->json(['donor' => $donor->toFrontendArray()], 201);
    }

    /**
     * Full replace of a donor's data — used when a donor's own fields
     * change (e.g. lastDonation/timesDonated updated after a History
     * Record is approved, or Profile edits syncing the donor's name).
     */
    public function update(Request $request, Donor $donor)
    {
        $body = $request->all();
        // Not a real donor field — carries the exact per-field change
        // description computed client-side (see script-legacy.js), so it's
        // pulled out before merging the rest of the body into `extra`.
        $auditDetails = $body['_auditDetails'] ?? null;
        unset($body['_auditDetails']);

        $donor->update([
            'name' => $body['name'] ?? $donor->name,
            'blood_type' => $body['bloodType'] ?? $donor->blood_type,
            'contact' => $body['contact'] ?? $donor->contact,
            'brgy' => $body['brgy'] ?? $donor->brgy,
            'extra' => array_merge($donor->extra ?? [], $body),
        ]);

        // Only write an Audit Log entry when something actually changed —
        // an update call that changed nothing shouldn't clutter the log.
        // Uses the specific field(s) that changed when the frontend sent
        // them (e.g. "Barangay: "X" → "Y""), falling back to a generic
        // message only if none was provided (e.g. an indirect sync call).
        if ($donor->wasChanged()) {
            AuditLog::recordDonorAction($request->user()?->id, 'Update', $donor->id, $donor->name, $auditDetails ?: 'Donor profile updated.');
        }

        return response()->json(['donor' => $donor->toFrontendArray()]);
    }

    /**
     * Bulk delete — mirrors deleteSelectedDonors() in script-legacy.js,
     * which already collects the selected ids client-side.
     */
    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        $donors = Donor::whereIn('id', $ids)->get();
        foreach ($donors as $donor) {
            AuditLog::recordDonorAction($request->user()?->id, 'Delete', $donor->id, $donor->name, 'Donor removed from masterlist.');
        }
        Donor::whereIn('id', $ids)->delete();

        return response()->json(['deleted' => count($ids)]);
    }
}
