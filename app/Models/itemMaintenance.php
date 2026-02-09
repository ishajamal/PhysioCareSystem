<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemMaintenance extends Model
{
    protected $table = 'item_maintenances';
    
    protected $primaryKey = 'itemMaintenanceID'; 
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'requestID',
        'itemID',
        'itemIssue',
        'detailsMaintenance',
    ];

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'requestID', 'requestID');
    }
    public function itemInfo()
    {
        return $this->belongsTo(ItemMaintenanceInfo::class, 'itemID', 'itemID');
    }
}
