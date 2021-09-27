<?php
namespace App\Http\Transformers\Collections;

use App\Http\Transformers\BaseTransformer;
use App\Models\CollectionItemType;

class ItemTypeTransformer extends BaseTransformer
{
    public function transform(CollectionItemType $ItemType)
    {
        return [
            'id' => $ItemType->id,
            'name' => $ItemType->name,
            'label' => $ItemType->label,
            'created_at' => $ItemType->created_at,
            'updated_at' => $ItemType->updated_at,
        ];
    }
}
