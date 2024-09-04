<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTaxRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
    ];

    protected $casts = [
        'rate' => 'float',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
