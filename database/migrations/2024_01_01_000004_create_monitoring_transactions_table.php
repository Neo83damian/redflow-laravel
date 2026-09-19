<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_uid')->unique();
            $table->foreignId('donor_id')->constrained('donors')->cascadeOnDelete();
            $table->foreignId('monitoring_record_id')->nullable()->constrained('monitoring_records')->nullOnDelete();
            $table->date('donation_date'); // the superseded "Last Donation" date, editable by admin/staff
            $table->string('blood_type')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_transactions');
    }
};
