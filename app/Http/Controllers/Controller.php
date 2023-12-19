<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseSuccess($data, $message = 'Request data succesfully retrieved.', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function responseError($message = 'System could not send data.', $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public function responseUnauthorized($message = 'Unauthorized.', $code = 401)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }


    public function responseNotFound($message = 'Data not found.', $code = 404)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public function responseServerError($message = 'Server error.', $code = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
