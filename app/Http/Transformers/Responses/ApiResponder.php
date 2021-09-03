<?php

namespace App\Http\Transformers\Responses;

trait ApiResponder
{
    public function success($data, $transformer = null, $message = '', $statusCode = 200)
    {
        if ($message === '') {
            $message = trans('messages.success');
        }
        $response = [
            'message' => $message,
            'data' => $data
        ];

        if (! $transformer) {
            return response()->json($response, $statusCode);
        }

        $response = array_merge($response, ['data' => (fractal($response['data'], $transformer)->toArray())]);

        // if it's pagination response
        if (isset($response['data']['meta']) && isset($response['data']['meta']['pagination'])) {
            $response['pagination'] = $response['data']['meta']['pagination'];
            unset($response['data']['meta']);
        }

        if (array_key_exists('data', $response['data'])) {
            $response['data'] = $response['data']['data'];
        }

        return response()->json($response, $statusCode);
    }

    protected function failure($error, $message = '', $statusCode = 422)
    {
        if ($message === '') {
            $message = trans('exception.failure');
        }
        return response()->json([
            'message' => $message,
            'error' => $error
        ], $statusCode);
    }
}
