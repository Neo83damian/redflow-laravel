<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'audit_log';

    protected $fillable = [
        'user_id', 'user_name', 'user_role', 'action', 'action_label',
        'donor_id', 'donor_name', 'details', 'logged_at',
    ];

    protected $casts = ['logged_at' => 'datetime'];

    /**
     * System/security events (login, register, logout, password change,
     * staff approve/reject). Not shown on the donor-focused Audit Log page
     * — those only query entries where donor_id is set (see recordDonorAction).
     */
    public static function record(?int $userId, string $action, ?string $details = null): void
    {
        $actor = Auth::user();
        static::create([
            'user_id' => $userId,
            'user_name' => $actor?->name,
            'user_role' => $actor?->role,
            'action' => $action,
            'details' => $details,
            'logged_at' => now(),
        ]);
    }

    /**
     * Donor-record events (Create / Update / Delete / Export). These are
     * what populate the Audit Log page in the app (renderAuditLogView()),
     * matching the "Create"/"Update"/"Export" action badges already coded
     * client-side in auditActionBadgeColor().
     */
    public static function recordDonorAction(?int $userId, string $actionLabel, ?int $donorId, ?string $donorName, ?string $details = null): void
    {
        $actor = Auth::user();
        static::create([
            'user_id' => $userId,
            'user_name' => $actor?->name ?? 'Unknown User',
            'user_role' => $actor?->role ?? 'Unknown',
            'action' => strtolower($actionLabel) . '_donor_record',
            'action_label' => $actionLabel,
            'donor_id' => $donorId,
            'donor_name' => $donorName,
            'details' => $details,
            'logged_at' => now(),
        ]);
    }

    public function toFrontendArray(): array
    {
        return [
            'id' => (string) $this->id,
            'timestamp' => optional($this->logged_at)->toISOString(),
            'userId' => $this->user_id,
            'userName' => $this->user_name,
            'userRole' => $this->user_role,
            'action' => $this->action_label,
            'donorId' => $this->donor_id,
            'donorName' => $this->donor_name,
            'details' => $this->details,
        ];
    }
}
