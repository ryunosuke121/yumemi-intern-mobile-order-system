<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\OrderItem;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\OrderItemNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;

final class UpdateOrderItemAction
{
    public function __invoke(Tenant $tenant, int $orderID, int $orderItemID, OrderItem $newOrderItem): OrderItem
    {
        $orderItem = OrderItem::select('order_items.*', 'order_items.id as id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.tenant_id', $tenant->id)
            ->where('order_items.id', $orderItemID)
            ->where('order_items.order_id', $orderID)
            ->first();
        if ($orderItem === null) {
            throw new OrderItemNotFoundException(MessageConst::ORDER_ITEM_NOT_FOUND);
        }

        DB::beginTransaction();
        try {
            if($newOrderItem->quantity !== null) {
                $orderItem->quantity = $newOrderItem->quantity;
                $orderItem->sub_total = $orderItem->item->cost_price * $newOrderItem->quantity * $orderItem->tax_rate;
                $orderItem->save();
            }

            $orderItem->update($newOrderItem->toArray());
            $orderItem->order->update_total_price();
            DB::commit();
            return $orderItem;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}