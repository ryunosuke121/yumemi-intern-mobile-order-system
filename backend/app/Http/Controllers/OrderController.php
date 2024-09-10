<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Order\UpdateOrderItemRequest;
use App\Http\Requests\Order\InitOrderRequest;
use App\Http\Requests\TakeOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Usecases\Order\GetOpenOrderByTableNumberAction;
use App\Usecases\Order\GetOpenOrdersAllAction;
use App\Usecases\Order\GetOrderByIDAction;
use App\Usecases\Order\InitOrderAction;
use App\Usecases\Order\TakeOrderItemAction;
use App\Usecases\Order\UpdateOrderItemAction;
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
            $orders = $getOrderByIDAction($tenant, $orderID);
        } elseif($tableNumber !== null) {
            $orders = $getOpenOrderByTableNumberAction($tenant, $tableNumber);
        } else {
            $orders = $getOpenOrdersAllAction($tenant);
        }

        $resources = [];
        foreach ($orders as $order) {
            $resources[] = new OrderResource($order);
        }
        return $resources;
    }

    public function updateOrderItem(
        UpdateOrderItemRequest $request,
        UpdateOrderItemAction $action
    ): OrderItemResource {
        $tenant = $request->user()->tenant;
        $orderID = $request->route('order_id') ? (int) ($request->route('order_id')) : null;
        $orderItemID = $request->route('order_item_id') ? (int) ($request->route('order_item_id')) : null;

        $orderItem = $action($tenant, $orderID, $orderItemID, $request->makeOrderItem());
        return new OrderItemResource($orderItem);
    }
}
