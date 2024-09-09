<?php

declare(strict_types=1);

namespace App\Usecases\Tenant;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;

final class ListItemAction
{
    public function __invoke(int $tenantID): Collection
    {
        $items = Tenant::find($tenantID)->items;
        return $items;
    }
}