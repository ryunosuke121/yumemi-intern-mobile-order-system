<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

final class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;
    
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
