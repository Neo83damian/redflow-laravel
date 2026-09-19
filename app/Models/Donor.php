<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_uid', 'name', 'ext_name', 'blood_type', 'contact', 'brgy', 'gender', 'dob', 'avatar_path', 'extra',
    ];

    protected $casts = [
        'dob' => 'date',
        'extra' => 'array',
    ];

    public function monitoringRecords()
    {
        return $this->hasMany(MonitoringRecord::class);
    }

    public function monitoringTransactions()
    {
        return $this->hasMany(MonitoringTransaction::class);
    }

    /**
     * The frontend (script-legacy.js) works with one flat donor object that
     * has many fields (weight, allergies, emergencyContactName, etc.) beyond
     * what's indexed in dedicated columns. Rather than re-modeling every one
     * of those fields relationally (risking a mismatch with the existing,
     * working frontend logic), the full object is stored verbatim in
     * `extra` and returned as-is, with `id` always set to the real DB id.
     */
    public function toFrontendArray(): array
    {
        return array_merge($this->extra ?? [], [
            'id' => $this->id,
            'name' => $this->name,
            'bloodType' => $this->blood_type,
            'brgy' => $this->brgy,
            'contact' => $this->contact,
            'avatar' => $this->avatar_path ?: 'picture.jpg',
        ]);
    }
}
