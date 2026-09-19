<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_uid', 'donor_id', 'monitoring_record_id', 'donation_date', 'blood_type', 'extra'];

    protected $casts = [
        'donation_date' => 'date',
        'extra' => 'array',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
