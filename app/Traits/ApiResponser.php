<?php

namespace App\Traits;

trait ApiResponser
{
    protected function successResponse(array $data = [], int $status = 200)
    {
        return response()->json(array_merge(['success' => true], $data), $status);
    }

    protected function errorResponse(string $message, int $status)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    protected function notFoundResponse(string $resource, $id)
    {
        return $this->errorResponse("Sorry, {$resource} with id {$id} cannot be found", 400);
    }
}
