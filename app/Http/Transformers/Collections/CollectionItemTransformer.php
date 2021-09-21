<?php
namespace App\Http\Transformers\Collections;

use App\Models\CollectionItem;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Collections\ItemTypeTransformer;
use App\Http\Transformers\Collections\CollectionTransformer;

class CollectionItemTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status',
    ];

    protected $availableIncludes = [
        'user', 'collection',
    ];

    public function transform(CollectionItem $collectionItem)
    {
        return [
            'id' => $collectionItem->id,
            'name' => $collectionItem->name,
            'label' => $collectionItem->label,
            'physical' => $collectionItem->physical,
            'image' => $collectionItem->image,
            'description' => $collectionItem->description,
            'edition' => $collectionItem->edition,
            'graded' => $collectionItem->graded,
            'year' => $collectionItem->year,
            'population' => $collectionItem->population,
            'publisher' => $collectionItem->publisher,
            'status' => $collectionItem->status,
            'created_at' => $collectionItem->created_at,
            'updated_at' => $collectionItem->updated_at,

        ];
    }

    public function includeCollection(CollectionItem $collectionItem)
    {
        $collection = $collectionItem->collection;
        return $this->item($collection, new CollectionTransformer);
    }

    public function includeUser(CollectionItem $collectionItem)
    {
        $collectionItemType = $collectionItem->collectionItemType;
        return $this->item($collectionItemType, new ItemTypeTransformer);
    }

    public function includeStatus(CollectionItem $collectionItem)
    {
        $item = [
            'id' => $collectionItem->id,
            'name' => data_get(CollectionItem::statuses(), $collectionItem->status),
        ];
        return $this->item($item, new ConstantTransformer);
    }

}
