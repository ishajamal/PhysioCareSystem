<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageItemInformation extends Model
{
    use HasFactory;

    protected $table = 'item_maintenance_infos';

    protected $primaryKey = 'itemID'; // IMPORTANT (based on your table)

    public $timestamps = true;

    protected $fillable = [
        'itemName',
        'quantity',
        'stockLevel',
        'condition',
        'status',
        'category',
        'description',
    ];
}
