<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // bcrypt hash
            $table->string('contact')->nullable();
            $table->string('brgy')->nullable();
            $table->string('gender')->nullable();
            $table->string('ext_name')->nullable();
            $table->date('dob')->nullable();
            $table->enum('role', ['Admin', 'Staff'])->default('Staff');
            $table->enum('status', ['Pending', 'Approved'])->default('Pending');
            $table->string('id_front_path')->nullable();   // AES-256 encrypted file path
            $table->string('id_back_path')->nullable();    // AES-256 encrypted file path
            $table->string('face_doc_path')->nullable();   // AES-256 encrypted file path
            $table->string('action_taken')->default('Registered');
            $table->timestamp('last_login_at')->nullable();
            $table->unsignedTinyInteger('failed_login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
