<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Order\InitOrderRequest;
use App\Usecases\Order\InitOrderAction;

final class OrderController extends Controller
{
    public function initializeOrder(InitOrderRequest $request, InitOrderAction $action): array {
        $tenant = $request->user()->tenant;
        $tableNumber = $request->tableNumber;
        return $action($tenant, $tableNumber);
    }
}
