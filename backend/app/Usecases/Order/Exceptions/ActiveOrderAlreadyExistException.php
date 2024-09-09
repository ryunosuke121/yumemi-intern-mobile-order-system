<?php

namespace App\Usecases\Order\Exceptions;

use Illuminate\Http\Response;

class ActiveOrderAlreadyExistException extends \Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}