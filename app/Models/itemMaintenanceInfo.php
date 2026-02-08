<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemMaintenanceInfo extends Model
{
    protected $table = 'item_maintenance_infos';
    
    protected $primaryKey = 'itemID';

    public $incrementing = true;   // if itemID is auto-increment
    protected $keyType = 'int'; 
     
    protected $fillable = [
        'itemName',
        'quantity',
        'stockLevel',
        'condition',
        'status',
        'category',
        'description',
    ];

    public function images()
    {
        return $this->hasMany(itemImages::class, 'itemID', 'itemID');
    }

    public function itemUsages()
    {
        return $this->hasMany(itemUsage::class, 'itemID', 'itemID');
    }
}
