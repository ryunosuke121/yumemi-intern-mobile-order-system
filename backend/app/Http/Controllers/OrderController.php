<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Order\InitOrderRequest;
use App\Http\Requests\TakeOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Usecases\Order\GetOpenOrderByTableNumberAction;
use App\Usecases\Order\GetOpenOrdersAllAction;
use App\Usecases\Order\GetOrderByIDAction;
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

    public function getTableOrderItems(
        Request $request,
        GetOrderByIDAction $getOrderByIDAction,
        GetOpenOrderByTableNumberAction $getOpenOrderByTableNumberAction,
        GetOpenOrdersAllAction $getOpenOrdersAllAction
    ): array | OrderResource {
        $tenant = $request->user()->tenant;
        $orderID = $request->query('order_id') ? (int) ($request->query('order_id')) : null;
        $tableNumber = $request->query('table_number') ? (int) ($request->query('table_number')) : null;

        if($orderID !== null) {
            $order = $getOrderByIDAction($tenant, $orderID);
            return new OrderResource($order);
        }
        
        if($tableNumber !== null) {
            $order = $getOpenOrderByTableNumberAction($tenant, $tableNumber);
            return new OrderResource($order);
        }

        $orders = $getOpenOrdersAllAction($tenant);
        $resources = [];
        foreach ($orders as $order) {
            $resources[] = new OrderResource($order);
        }
        return $resources;
    }
}
