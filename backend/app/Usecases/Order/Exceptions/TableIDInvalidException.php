<?php

namespace App\Usecases\Order\Exceptions;

use Exception;
use Illuminate\Http\Response;

class TableIDInvalidException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
