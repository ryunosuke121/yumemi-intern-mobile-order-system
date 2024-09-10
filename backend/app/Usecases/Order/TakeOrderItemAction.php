<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Usecases\Order\Exceptions\ItemNotFoundException;
use App\Usecases\Order\Exceptions\OrderNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;

final class TakeOrderItemAction
{
    public function __invoke(int $tenantID, int $orderID, array $orderItems): array
    {
        // オーダーが未会計かどうかを確認
        $order = Order::where('tenant_id', $tenantID)
            ->where('id', $orderID)
            ->where('status', Order::STATUS_OPEN)
            ->first();
        if ($order === null) {
            throw new OrderNotFoundException(MessageConst::ORDER_NOT_FOUND);
        }

        DB::beginTransaction();
        try{
            foreach ($orderItems as $orderItem) {
                $item = Item::where('tenant_id', $tenantID)
                    ->where('id', $orderItem['item_id'])
                    ->where('deleted_at', null)
                    ->first();
                
                if ($item === null) {
                    throw new ItemNotFoundException(MessageConst::ITEM_NOT_FOUND);
                }
    
                $orderItem->order_id = $orderID;
                $orderItem->tax_rate = $item->taxRate->tax_rate;
                $orderItem->cost_price = $item->cost_price;
                $orderItem->sub_total = floor($item->cost_price * $orderItem->quantity * $orderItem->tax_rate);
                $orderItem->status = OrderItem::STATUS_PENDING;
                $orderItem->save();
            }

            $order->total_price = $order->order_items->sum('sub_total');
            $order->save();
            DB::commit();
            return $orderItems;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}