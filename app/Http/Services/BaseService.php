<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BaseService
{
    protected function success($data, $message = '', $statusCode = 200)
    {
        if ($message === '') {
            $message = trans('messages.success');
        }
        if (array_key_exists('data', $data)) {
            $data = array_merge([
                'message' => $message,
            ], $data);
        } else {

            $data = [
                'message' => $message,
                'data' => $data,
            ];
        }
        return response()->json($data, $statusCode);
    }

    protected function failure($error, $message = '', $statusCode = 422)
    {
        if ($message === '') {
            $message = trans('exception.failure');
        }
        return response()->json([
            'message' => $message,
            'error' => $error,
        ], $statusCode);
    }

    /**
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 10, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, isset(request()->per_page) ? request()->per_page : $perPage)->values(), $items->count(), isset(request()->per_page) ? request()->per_page : $perPage, $page, $options);
    }

    public function dateComparision($firstDate, $secondDate, $operation)
    {
        $firstDate->setTimezone('UTC');
        $result = $firstDate->$operation($secondDate);
        return $result;
    }
}
