<?php
namespace App\Http\Transformers\Collections;

use App\Models\Collection;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;

class CollectionTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'user',
    ];

    public function transform(Collection $collection)
    {
        return [
            'id' => $collection->id,
            'name' => $collection->name,
            'status' => $collection->status,
            'image' => $collection->image,
            'created_at' => $collection->created_at,
            'updated_at' => $collection->updated_at,
        ];
    }

    public function includeUser(Collection $collection)
    {
        $user = $collection->user;
        return $this->item($user, new UserTransformer);
    }

}
