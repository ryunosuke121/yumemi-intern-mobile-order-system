<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class MTaxRate extends Model
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
