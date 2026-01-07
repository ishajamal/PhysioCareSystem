<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemUsage extends Model
{
    protected $table = 'item_usages';
    
    protected $fillable = [
        'usageID',
        'itemID',
        'quantityUsed',
    ];

    public function usageRecord()
    {
        return $this->belongsTo(UsageRecord::class, 'usageID', 'usageID');
    }

    public function itemMaintenanceInfo()
    {
        return $this->belongsTo(ItemMaintenanceInfo::class, 'itemID', 'itemID');
    }
}
