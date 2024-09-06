<?php

namespace App\Usecases\Tenant\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UploadFileFailedException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
