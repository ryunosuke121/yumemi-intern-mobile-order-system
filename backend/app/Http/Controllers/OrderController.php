<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\InitOrderRequest;
use App\Http\Resources\OrderResource;
use App\Usecases\Order\InitOrderAction;

class OrderController extends Controller
{
    public function initializeOrder(InitOrderRequest $request, InitOrderAction $action): array {
        $tenant = $request->user()->tenant;
        $tableNumber = $request->tableNumber;
        return $action($tenant, $tableNumber);
    }
}
