<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_uid')->unique();
            $table->foreignId('donor_id')->nullable()->constrained('donors')->nullOnDelete();
            $table->date('donation_date');
            $table->string('blood_type')->nullable();
            $table->unsignedInteger('times_donated')->default(1);
            $table->json('extra')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_records');
    }
};
