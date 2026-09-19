<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'uuid', 'name', 'email', 'password', 'contact', 'brgy', 'gender',
        'ext_name', 'dob', 'role', 'status', 'id_front_path', 'id_back_path',
        'face_doc_path', 'action_taken', 'last_login_at', 'failed_login_attempts', 'locked_until',
        'approved_by', 'approved_at',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed', // bcrypt via Laravel's automatic hashing cast
        'dob' => 'date',
        'last_login_at' => 'datetime',
        'locked_until' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    public function staffProfile()
    {
        return $this->hasOne(StaffProfile::class);
    }

    public function notifications_app()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function hasRoleAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Shape returned to the frontend — mirrors the fields the legacy
     * script.js expects on a "systemUsers" entry (no password included).
     */
    public function toFrontendArray(): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'contact' => $this->contact,
            'brgy' => $this->brgy,
            'gender' => $this->gender,
            'extName' => $this->ext_name,
            'dob' => optional($this->dob)->format('Y-m-d'),
            'idFront' => $this->id_front_path ? "/secure-image/{$this->id}/id_front" : null,
            'idBack' => $this->id_back_path ? "/secure-image/{$this->id}/id_back" : null,
            'faceDoc' => $this->face_doc_path ? "/secure-image/{$this->id}/face_doc" : 'picture.jpg',
            'registeredAt' => optional($this->created_at)->toISOString(),
            'lastLogin' => optional($this->last_login_at)->toISOString(),
            'actionTaken' => $this->action_taken,
            'approvedBy' => $this->approver?->name,
            'approvedAt' => optional($this->approved_at)->toISOString(),
        ];
    }
}
