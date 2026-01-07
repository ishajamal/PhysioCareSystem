<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemImages extends Model
{
    
    protected $fillable = [
        'itemID',
        'imagePath',
    ];

    public function itemMaintenanceInfo()
    {
        return $this->belongsTo(ItemMaintenanceInfo::class, 'itemID', 'itemID');
    }
}
