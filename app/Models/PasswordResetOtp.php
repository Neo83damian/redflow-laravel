<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'code_hash', 'expires_at', 'consumed'];

    protected $casts = [
        'expires_at' => 'datetime',
        'consumed' => 'boolean',
    ];
}
