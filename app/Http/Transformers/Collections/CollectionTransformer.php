<?php
namespace App\Http\Transformers\Collections;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Comments\CommentTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\Collection;

class CollectionTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status', 'user',
    ];

    protected $availableIncludes = [
        'comments',
    ];

    public function transform(Collection $collection)
    {
        return [
            'id' => $collection->id,
            'user_id' => $collection->id,
            'name' => $collection->name,
            'status' => $collection->status,
            'logo_image' => 'required|base64img',
            'featured_image' => $collection->featured_image,
            'banner_image' => $collection->banner_image,
            'external_url' => $collection->external_url,
            'description' => $collection->description,
            'categories' => $collection->categories,
            'website' => $collection->website,
            'discord' => $collection->discord,
            'twitter' => $collection->twitter,
            'instagram' => $collection->instagram,
            'medium' => $collection->medium,
            'telegram' => $collection->telegram,
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
