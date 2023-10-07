<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait APIResponseTrait
{
    /**
     * Building success response
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($response = null, $code = Response::HTTP_OK)
    {
        if ($response) {
            return response()->json([
                'status' => $code,
                'message' => $code == 400 ? 'Bad Request' : 'success',
                'result' => $response
            ], $code);
        }

        return response()->json([
            'status' => $code,
            'message' => 'success',
            'results' => []
        ], $code);
    }

    /**
     * Building success response
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($exception, $statusCode = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => 'failed',
            'results' => $exception->getMessage()
        ], $statusCode);
    }
}