<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Matches the shape script-legacy.js already expects for one entry
     * inside its per-user notifications array.
     */
    public function toFrontendArray(): array
    {
        return [
            'id' => 'notif_' . $this->id,
            'message' => $this->message,
            'timestamp' => optional($this->created_at)->toISOString(),
            'read' => (bool) $this->is_read,
        ];
    }
}
