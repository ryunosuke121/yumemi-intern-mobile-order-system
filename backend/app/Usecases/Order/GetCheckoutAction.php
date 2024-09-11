<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\OrderAlreadyPaidException;
use App\Usecases\Order\Exceptions\OrderNotFoundException;

final class GetCheckoutAction
{
    public function __invoke(Tenant $tenant, int $orderID): array
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

        return [
            'order' => $order,
            'pendingItems' => $pendingItems,
        ];
    }
}