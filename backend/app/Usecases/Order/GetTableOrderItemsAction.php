<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Order;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\OrderNotFoundException;
use Illuminate\Database\Eloquent\Collection;

final class GetTableOrderItemsAction
{
    public function __invoke(Tenant $tenant, int $orderID): Collection
    {
        $order = Order::where('tenant_id', $tenant->id)
            ->where('id', $orderID)
            ->first();
        
        if ($order === null) {
            throw new OrderNotFoundException(MessageConst::ORDER_NOT_FOUND);
        }

        return $order->order_items;
    }
}