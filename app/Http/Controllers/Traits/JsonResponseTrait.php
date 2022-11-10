<?php

namespace App\Http\Controllers\Traits;

trait JsonResponseTrait
{
    public function jsonResponse($success, $message, $data, $status = 200)
    {
        return response()->json([
            'success'   => $success,
            'message'   => $message,
            'data'      => $data,
        ], $status);
    }
}
