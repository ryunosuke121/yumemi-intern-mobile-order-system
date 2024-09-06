<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\Tenant\ChangeTableCountRequest;
use App\Http\Resources\ItemResource;
use App\Usecases\Tenant\ChangeTableCountAction;
use App\Usecases\Tenant\CreateItemAction;

class TenantController extends Controller
{
    public function changeTableCount(ChangeTableCountRequest $request, ChangeTableCountAction $action): void {
        $tenant = $request->user()->tenant;
        $action($tenant, $request->new_table_count);
    }

    public function createItem(CreateItemRequest $request, CreateItemAction $action): ItemResource {
        $tenant = $request->user()->tenant;
        $item = $request->makeItem();
        $image = $request->file('image');

        return new ItemResource($action($tenant, $item, $image));
    }
}
