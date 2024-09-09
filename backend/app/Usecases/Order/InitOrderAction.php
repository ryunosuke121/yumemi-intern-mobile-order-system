<?php

namespace App\Usecases\Order;

use App\Constants\MessageConst;
use App\Models\Order;
use App\Models\Tenant;
use App\Usecases\Order\Exceptions\ActiveOrderAlreadyExistException;
use App\Usecases\Order\Exceptions\CreateTokenFailedException;
use App\Usecases\Order\Exceptions\TableIDInvalidException;
use Firebase\JWT\JWT;

class InitOrderAction
{
    public function __invoke(Tenant $tenant, int $tableNumber): array
    {
        if ($tableNumber > $tenant->table_count || $tableNumber <= 0) {
            throw new TableIDInvalidException(MessageConst::TABLE_NUMBER_INVALID);
        }

        $isExist = Order::where('tenant_id', $tenant->id)
            ->where('table_number', $tableNumber)
            ->where('status', Order::STATUS_OPEN)
            ->first();
        
        if ($isExist !== null) {
            throw new ActiveOrderAlreadyExistException(MessageConst::ACTIVE_ORDER_ALREADY_EXIST);
        }

        $order = Order::create([
            'tenant_id' => $tenant->id,
            'table_number' => $tableNumber,
            'status' => Order::STATUS_OPEN,
        ]);

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
        ];

        $token = JWT::encode($data, config('jwt.secret'), 'HS256');
        return $token;
    }
}