<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class maintenanceRequestImage extends Model
{
    protected $table = 'maintenance_request_images';
    
    protected $fillable = [
        'requestID',
        'imagePath',
    ];

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'requestID', 'requestID');
    }
}
