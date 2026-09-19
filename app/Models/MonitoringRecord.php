<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringRecord extends Model
{
    use HasFactory;

    protected $fillable = ['record_uid', 'donor_id', 'donation_date', 'blood_type', 'times_donated', 'extra'];

    protected $casts = [
        'donation_date' => 'date',
        'extra' => 'array',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Same approach as Donor::toFrontendArray() — the frontend's record
     * object (including its nested `transactions` array, which is how the
     * New-Donation-vs-Last-Donation logic already works) is stored verbatim
     * in `extra` and returned as-is, with `id` always set to the real DB id.
     */
    public function toFrontendArray(): array
    {
        return array_merge($this->extra ?? [], [
            'id' => $this->id,
            'donorId' => $this->donor_id,
        ]);
    }

    /**
     * A New Donation record only becomes a completed transaction once it is
     * superseded by a later one — this preserves the fix already verified
     * in the DOME-4-1-2.html prototype (approveAndCommitHistoryRecord()).
     */
    public function supersedeIntoTransaction(): MonitoringTransaction
    {
        return MonitoringTransaction::create([
            'transaction_uid' => 'txn_' . uniqid(),
            'donor_id' => $this->donor_id,
            'monitoring_record_id' => $this->id,
            'donation_date' => $this->donation_date,
            'blood_type' => $this->blood_type,
            'extra' => $this->extra,
        ]);
    }
}
