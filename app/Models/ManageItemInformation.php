<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageItemInformation extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';

    protected $fillable = [
        'product_code',
        'product_name',
        'category', // Item / Equipment
        'description',
        'quantity',
        'unit',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'purchase_price',
        'supplier',
        'warranty_period',
        'last_maintenance_date',
        'next_maintenance_date',
        'status',
        'location',
        'notes',
        'image_path', // ✅ new
        'last_updated_by',
        'last_updated_date'
    ];

    protected $casts = [
        'last_updated_date' => 'date',
        'purchase_date' => 'date',
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'purchase_price' => 'decimal:2',
        'quantity' => 'integer'
    ];
}
