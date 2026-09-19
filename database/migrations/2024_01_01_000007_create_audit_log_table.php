<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();  // snapshot at the time of the event
            $table->string('user_role')->nullable();  // snapshot at the time of the event
            $table->string('action');                 // internal key, e.g. "login", "create_donor"
            $table->string('action_label')->nullable(); // display label for the Audit Log page badge: Create / Update / Delete / Export / View
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->string('donor_name')->nullable();
            $table->text('details')->nullable();
            $table->timestamp('logged_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};
