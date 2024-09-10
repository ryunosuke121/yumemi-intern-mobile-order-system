<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Order;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\OrderNotFoundException;

final class GetOpenOrderByTableNumberAction
{
    public function __invoke(Tenant $tenant, int $tableNumber): Order
    {
        $order = Order::where('tenant_id', $tenant->id)
            ->where('table_number', $tableNumber)
            ->where('status', Order::STATUS_OPEN)
            ->first();
        
        if ($order === null) {
            throw new OrderNotFoundException(MessageConst::ORDER_NOT_FOUND);
        }

        return $order;
    }
}