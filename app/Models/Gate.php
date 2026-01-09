<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gerbang',
        'status',
        'traffic_status',
        'cctv_url',
    ];

    /**
     * Get the user who last updated the gate.
     * Note: This requires adding 'last_updated_by' column to gates table
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    /**
     * Helper to get combined status for display
     */
    public function getDisplayStatusAttribute()
    {
        if ($this->status === 'closed') {
            return 'tutup';
        }
        return $this->traffic_status ?? 'lancar';
    }

    /**
     * Helper to check if gate is open
     */
    public function getIsOpenAttribute()
    {
        return $this->status === 'open';
    }
}
