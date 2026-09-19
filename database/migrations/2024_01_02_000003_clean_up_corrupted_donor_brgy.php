<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// A past bug in saveRecordEdit() (fixed in the app code) sent the FULL
// display location ("Gumapia, Irosin, Sorsogon, Bicol, Philippines")
// into the donor's `brgy` column every time a History Record was saved,
// even when location wasn't touched — `brgy` is only ever supposed to
// hold the short barangay name ("Gumapia"). This one-time cleanup strips
// any already-corrupted rows back down to just the barangay name so the
// Audit Log stops showing a false "Barangay changed" line on every future
// Donor Profile save for those donors.
return new class extends Migration
{
    public function up(): void
    {
        $donors = DB::table('donors')->whereNotNull('brgy')->where('brgy', 'like', '%,%')->get(['id', 'brgy']);
        foreach ($donors as $donor) {
            $clean = trim(explode(',', $donor->brgy)[0]);
            DB::table('donors')->where('id', $donor->id)->update(['brgy' => $clean]);
        }
    }

    public function down(): void
    {
        // Not reversible — the original full-address string wasn't useful
        // data to begin with, so there's nothing worth restoring.
    }
};
