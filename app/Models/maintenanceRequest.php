<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class maintenanceRequest extends Model
{
    protected $table = 'maintenance_requests';
    
    protected $fillable = [
        'userID',
        'dateSubmitted',
        'status',
        'submittedBy',
        'isRead',
    ];

    protected $casts = [
        'dateSubmitted' => 'datetime',
        'isRead' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submittedBy', 'userID');
    }

    public function images()
    {
        return $this->hasMany(MaintenanceRequestImage::class, 'requestID', 'requestID');
    }

    public function itemMaintenances()
    {
        return $this->hasMany(ItemMaintenance::class, 'requestID', 'requestID');
    }
}
