<?php

namespace App\Http\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $resourceKey ?: $data;
    }
}
