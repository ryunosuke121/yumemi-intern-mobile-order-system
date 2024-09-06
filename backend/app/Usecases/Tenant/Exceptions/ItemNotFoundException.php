<?php

namespace App\Usecases\Tenant\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ItemNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }
}
