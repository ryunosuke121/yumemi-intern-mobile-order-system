<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\Tenant\ChangeTableCountRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Usecases\Tenant\ChangeTableCountAction;
use App\Usecases\Tenant\CreateItemAction;
use App\Usecases\Tenant\DeleteItemAction;
use App\Usecases\Tenant\UpdateItemAction;
use Illuminate\Http\Request;

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

    public function updateItem(UpdateItemRequest $request, UpdateItemAction $action): ItemResource {
        $tenant = $request->user()->tenant;
        $itemID = $request->route('id');
        $newItem = $request->makeItem();
        $image = $request->file('image');

        return new ItemResource($action($tenant, $itemID, $newItem, $image));
    }

    public function deleteItem(Request $request, DeleteItemAction $action): void {
        $tenant = $request->user()->tenant;
        $itemID = $request->route('id');
        $action($tenant, $itemID);
    }
}
