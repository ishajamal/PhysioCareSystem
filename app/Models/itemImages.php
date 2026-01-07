<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemImages extends Model
{
    protected $table = 'item_images';
    
    protected $primaryKey = 'imageID';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'itemID',
        'imagePath',
    ];

    public function itemMaintenanceInfo()
    {
        return $this->belongsTo(ItemMaintenanceInfo::class, 'itemID', 'itemID');
    }
}
