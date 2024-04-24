<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * retrieve notification from api
     * @param string $message
     * @param int $status
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function responseErrors($message = '', $status = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
        ], $status);
    }

    /**
     * retrieve notification and data from api
     * @param array $data
     * @param int $statusCode
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data, $statusCode = Response::HTTP_OK)
    {
        return response()->json(
            array_merge(['code' => $statusCode], $data),
            $statusCode
        );
    }
}
