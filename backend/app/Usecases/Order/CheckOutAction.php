<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\OrderAlreadyPaidException;
use App\Usecases\Order\Exceptions\OrderNotFoundException;
use App\Usecases\Order\Exceptions\PendingItemsExistException;

final class CheckoutAction
{
    public function __invoke(Tenant $tenant, int $orderID): Order
    {
        $order = Order::where('tenant_id', $tenant->id)
            ->where('id', $orderID)
            ->first();
        if ($order === null) {
            throw new OrderNotFoundException(MessageConst::ORDER_NOT_FOUND);
        }
        if ($order->status === Order::STATUS_PAID) {
            throw new OrderAlreadyPaidException(MessageConst::ORDER_ALREADY_PAID);
        }

        // 未提供の商品があるかどうかをチェック
        $pendingItems = [];
        foreach ($order->order_items as $orderItem) {
            if ($orderItem->status === OrderItem::STATUS_PENDING) {
                $pendingItems[] = $orderItem;
            }
        }
        if (count($pendingItems) > 0) {
            throw new PendingItemsExistException(MessageConst::PENDING_ITEMS_EXIST, $pendingItems);
        }

        // オーダーを会計済みに変更
        $order->status = Order::STATUS_PAID;
        $order->save();

        return $order;
    }
}
