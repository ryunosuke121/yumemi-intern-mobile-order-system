<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Usecases\Tenant\ListItemAction;
use Illuminate\Http\Request;

final class ItemController extends Controller
{
    public function listItems(Request $request, ListItemAction $action): array
    {
        $tenantID = $request->query('tenant_id');
        $items = $action($tenantID);

        $resources = [];
        foreach ($items as $item) {
            $itemResource = new ItemResource($item);
            $resources[] = $itemResource;
        }
        return $resources;
    }
}