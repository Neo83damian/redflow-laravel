<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// A past version of the app wrote 'Edit' as the audit_log.action_label for
// donor/record edits, before the Audit Log was standardized to the 5
// categories (Create/Update/Delete/Export/Change). The code has always
// written 'Update' since that change, but any rows created before then
// still say 'Edit' — which is why "Edit" could still show up on the Audit
// Log page even after the label fix, on any database that already had
// history in it. This is a one-time data fix for existing rows only.
return new class extends Migration
{
    public function up(): void
    {
        DB::table('audit_log')
            ->where('action_label', 'Edit')
            ->update(['action_label' => 'Update']);

        DB::table('audit_log')
            ->where('action', 'edit_donor_record')
            ->update(['action' => 'update_donor_record']);
    }

    public function down(): void
    {
        // Not reversible — the original rows' exact previous label isn't
        // tracked, and there's no reason to want "Edit" back.
    }
};
