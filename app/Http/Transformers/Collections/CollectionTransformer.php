<?php
namespace App\Http\Transformers\Collections;

use App\Models\Collection;
use App\Models\CollectionItem;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Transformers\Comments\CommentTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;

class CollectionTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status',
    ];

    protected $availableIncludes = [
        'user', 'comments',
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

    public function includeComments(Collection $collection)
    {
        $comments = $collection->comments;
        return $this->collection($comments, new CommentTransformer);
    }
    
      public function includeStatus(Collection $collection)
    {
        $item = [
            'id' => $collection->id,
            'name' => data_get(Collection::statuses(), $collection->status),
        ];
        return $this->item($item, new ConstantTransformer);
    }

}
