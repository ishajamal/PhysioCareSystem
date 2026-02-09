<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportLog extends Model
{
    use HasFactory;

    protected $table = 'report_log';
    protected $primaryKey = 'reportID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Table does not have created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'reportType',
        'generatedBy',
        'generatedAt',
        'dateStart',
        'dateEnd',
    ];

    protected $casts = [
        'generatedAt' => 'datetime',
        'dateStart' => 'date',
        'dateEnd' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'generatedBy', 'userID');
    }
}
