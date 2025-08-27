<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    // ... existing code ...

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->handleValidationException($e);
        }

        return parent::render($request, $e);
    }

    protected function handleValidationException(ValidationException $e)
    {
        return response()->json([
            'success' => false,
            'message' => $e->validator->errors()->first(),
            'data' => null
        ], 422);
    }

    // ... rest of the class ...
}