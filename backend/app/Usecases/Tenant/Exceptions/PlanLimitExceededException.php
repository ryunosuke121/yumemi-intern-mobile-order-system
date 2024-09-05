<?php

namespace App\Usecases\Tenant\Exceptions;

use Exception;

class PlanLimitExceededException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 422);
    }
}
