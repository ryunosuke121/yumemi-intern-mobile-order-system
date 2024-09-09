<?php

declare(strict_types=1);

namespace App\Usecases\Order\Exceptions;

use Exception;

final class CreateTokenFailedException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}