<?php

namespace App\Usecases\Order\Exceptions;

use Exception;

class CreateTokenFailedException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 500);
    }
}