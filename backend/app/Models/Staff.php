<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes;
    
    protected $table = 'staffs';

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'password_hash',
        'deleted_at',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
