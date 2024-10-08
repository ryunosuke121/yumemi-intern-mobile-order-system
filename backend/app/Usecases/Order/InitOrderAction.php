<?php

declare(strict_types=1);

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Order;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\TableIDInvalidException;
use Firebase\JWT\JWT;

final class InitOrderAction
{
    public function __invoke(Tenant $tenant, int $tableNumber): array
    {
        if ($tableNumber > $tenant->table_count || $tableNumber <= 0) {
            throw new TableIDInvalidException(MessageConst::TABLE_NUMBER_INVALID);
        }

        $order = Order::where('tenant_id', $tenant->id)
            ->where('table_number', $tableNumber)
            ->where('status', Order::STATUS_OPEN)
            ->first();
        
        if ($order === null) {
            $order = Order::create([
                'tenant_id' => $tenant->id,
                'table_number' => $tableNumber,
                'status' => Order::STATUS_OPEN,
            ]);
        }

        $token = $this->createToken($tenant->id, $order->id);
        // QRコードのURL
        $pageURL = env('FRONTEND_URL') . '/order/' . $token;
        
        return [
            'token' => $token,
            'order' => $order,
            'pageURL' => $pageURL,
        ];
    }

    public function createToken(int $tenantID, int $orderID): string
    {
        $data = [  
            'tenant_id' => $tenantID,
            'order_id' => $orderID,
            'exp' => time() + 60 * 60 * 24,
        ];

        $token = JWT::encode($data, config('jwt.secret'), 'HS256');
        return $token;
    }
}