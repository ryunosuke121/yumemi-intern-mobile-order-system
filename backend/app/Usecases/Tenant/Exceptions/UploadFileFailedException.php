<?php

declare(strict_types=1);

namespace App\Usecases\Tenant\Exceptions;

use Exception;
use Illuminate\Http\Response;

final class UploadFileFailedException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
