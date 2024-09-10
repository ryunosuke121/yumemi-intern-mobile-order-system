<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Order\InitOrderRequest;
use App\Http\Requests\TakeOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Usecases\Order\GetTableOrderItemsAction;
use App\Usecases\Order\InitOrderAction;
use App\Usecases\Order\TakeOrderItemAction;
use Illuminate\Http\Request;

final class OrderController extends Controller
{
    public function initializeOrder(InitOrderRequest $request, InitOrderAction $action): array {
        $tenant = $request->user()->tenant;
        $tableNumber = $request->tableNumber;
        return $action($tenant, $tableNumber);
    }

    public function takeOrderItem(TakeOrderItemRequest $request, TakeOrderItemAction $action): array {
        $tenantID = $request->input('tenant_id');
        $orderID = $request->input('order_id');
        $orderItems = $request->makeOrderItems();

        $orderItems = $action($tenantID, $orderID, $orderItems);

        $resources = [];
        foreach ($orderItems as $orderItem) {
            $resources[] = new OrderItemResource($orderItem);
        }
        return $resources;
    }

    public function getTableOrderItems(Request $request, GetTableOrderItemsAction $action): array {
        $tenant = $request->user()->tenant;
        $orderID = $request->route('id');

        $orderItems = $action($tenant, intval($orderID));

        $resources = [];
        foreach ($orderItems as $orderItem) {
            $resources[] = new OrderItemResource($orderItem);
        }
        return $resources;
    }
}
