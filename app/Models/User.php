<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $primaryKey = 'userID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'profileImage',
        'phoneNumber',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getAuthIdentifier()
    {
        return $this->userID;
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(maintenanceRequest::class, 'userID', 'userID');
    }

    public function submittedRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'submittedBy', 'userID');
    }

    public function usageRecords()
    {
        return $this->hasMany(UsageRecord::class, 'userID', 'userID');
    }

    public function usedByRecords()
    {
        return $this->hasMany(UsageRecord::class, 'usedBy', 'userID');
    }
}
