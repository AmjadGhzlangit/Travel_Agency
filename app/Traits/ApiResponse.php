<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    protected function response($message, $data = null, $meta = null, $code = Response::HTTP_OK): JsonResponse
    {
        $response = ['message' => $message, 'status_code' => $code];

        if ($meta) {
            $response = array_merge(['meta' => $meta], $response);
        }

        if (!is_null($data)) {
            $response = array_merge(['data' => $data], $response);
        }

        return $this->jsonResponse($response, $code);
    }

    protected function responseMessage($message, $code = Response::HTTP_OK): JsonResponse
    {
        return $this->response($message, null, null, $code);
    }

    protected function showAll($data, $resource, $pagination, $message = 'success', $code = 200): JsonResponse
    {
        $response = $resource::collection($data);

        return $this->response($message, $response, ['pagination' => $pagination], $code);
    }

    protected function showCollection($data, $resource, $message = 'success', $code = 200): JsonResponse
    {
        $response = $resource::collection($data);

        return $this->response($message, $response);
    }

    protected function showOne($instance, $resource, $message = 'success', $code = 200): JsonResponse
    {
        return $this->response($message, new $resource($instance));
    }

    private function jsonResponse($data, $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }
}
