<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemMaintenance extends Model
{
     protected $table = 'item_maintenances';
    
    protected $fillable = [
        'requestID',
        'itemIssue',
        'detailsMaintenance',
    ];

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'requestID', 'requestID');
    }
}
