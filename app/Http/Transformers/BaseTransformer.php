<?php

namespace App\Http\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FCollection;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

/**
 * Class BaseTransformer.
 *
 * @package namespace App\Transformers;
 */
class BaseTransformer extends TransformerAbstract
{
    /**
     * Transform the collection.
     *
     * @param \Collection $collection
     *
     * @return array
     */
    public function transformCollection(Collection $collection)
    {
        $manager = new Manager();
        $media = new FCollection($collection, $this);
        return $manager->createData($media)->toArray()['data'];
    }

    /**
     * Transform the paginator.
     *
     * @param \LengthAwarePaginator $paginator
     *
     * @return LengthAwarePaginator
     */
    public function transformPaginator(LengthAwarePaginator $paginator)
    {
        $data = $paginator->getCollection()->transform(function ($value) {
            return $this->transform($value);
        });

        return new LengthAwarePaginator(
            $data,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(), [
                'path' => request()->url(),
                'query' => [
                    'page' => $paginator->currentPage(),
                ]
            ]
        );
    }

    /**
     * @param null|DateTime $dateTime
     * @return string
     */
    public function dateFormatter($dateTime)
    {
        return $dateTime ? with(new Carbon($dateTime))->format($this->getDateFormat()) : null;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}

