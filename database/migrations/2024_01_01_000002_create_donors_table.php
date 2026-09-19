<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string('donor_uid')->unique(); // mirrors the JS-generated donor id
            $table->string('name');
            $table->string('ext_name')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('contact')->nullable();
            $table->string('brgy')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('avatar_path')->nullable(); // defaults to picture.jpg when empty
            $table->json('extra')->nullable(); // any additional donor fields the frontend tracks
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
