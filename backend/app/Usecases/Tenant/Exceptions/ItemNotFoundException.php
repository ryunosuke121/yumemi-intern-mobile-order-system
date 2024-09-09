<?php

declare(strict_types=1);

namespace App\Usecases\Tenant\Exceptions;

use Exception;
use Illuminate\Http\Response;

final class ItemNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }
}
