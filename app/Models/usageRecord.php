<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usageRecord extends Model
{
    protected $table = 'usage_records';
    
    protected $primaryKey = 'usageID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usedBy',
        'usageDate',
    ];

    protected $casts = [
        'usageDate' => 'date',
    ];

    public function usedByUser()
    {
        return $this->belongsTo(User::class, 'usedBy', 'userID');
    }

    public function itemUsages()
    {
        return $this->hasMany(ItemUsage::class, 'usageID', 'usageID');
    }

}
