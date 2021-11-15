<?php
namespace App\Http\Transformers\Collections;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Collections\CollectionTransformer;
use App\Http\Transformers\Collections\ItemTypeTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Models\CollectionItem;

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
            'image' => $collectionItem->image,
            'path' => $collectionItem->path,
            'description' => $collectionItem->description,
            'edition' => $collectionItem->edition,
            'graded' => $collectionItem->graded,
            'year' => $collectionItem->year,
            'price' => $collectionItem->price,
            'population' => $collectionItem->population,
            'publisher' => $collectionItem->publisher,
            'status' => $collectionItem->status,
            'available_for_sale' => $collectionItem->available_for_sale,
            'available_at' => $collectionItem->available_at,
            'created_at' => $collectionItem->created_at,
            'updated_at' => $collectionItem->updated_at,
            'favorites_count'=> $collectionItem->favorites_count,

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
