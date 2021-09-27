<?php
namespace App\Http\Transformers\Constants;

use App\Http\Transformers\BaseTransformer;

class ConstantTransformer extends BaseTransformer
{
    public function transform($constant)
    {
        return [
            'id' => data_get($constant, "id"),
            'name' => data_get($constant, "name"),
        ];
    }
}
