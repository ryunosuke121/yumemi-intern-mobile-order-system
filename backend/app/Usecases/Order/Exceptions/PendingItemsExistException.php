<?php

declare(strict_types=1);

namespace App\Usecases\Order\Exceptions;

use App\Http\Resources\OrderItemResource;
use Exception;
use Illuminate\Http\Response;

final class PendingItemsExistException extends Exception
{
    private array $pendingItems;

    public function __construct(string $message, array $pendingItems)
    {
        parent::__construct($message);
        $this->pendingItems = $pendingItems;
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
            'pending_items' => OrderItemResource::collection($this->pendingItems),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
