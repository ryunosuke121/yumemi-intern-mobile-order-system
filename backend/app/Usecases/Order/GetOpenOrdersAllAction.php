<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Order;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\OrderNotFoundException;
use Illuminate\Database\Eloquent\Collection;

final class GetOpenOrdersAllAction
{
    public function __invoke(Tenant $tenant): Collection
    {
        $orders = Order::where('tenant_id', $tenant->id)
            ->where('status', Order::STATUS_OPEN)
            ->get();
        
        if ($orders === null) {
            throw new OrderNotFoundException(MessageConst::ORDER_NOT_FOUND);
        }

        return $orders;
    }
}