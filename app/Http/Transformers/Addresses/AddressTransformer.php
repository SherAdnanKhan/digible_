<?php
namespace App\Http\Transformers\Addresses;

use App\Http\Transformers\BaseTransformer;
use App\Models\Address;

class AddressTransformer extends BaseTransformer
{
    public function transform(Address $address)
    {
        return [
            'id' => $address->id,
            "address" => $address->address,
            "address2" => $address->address2,
            "country" => $address->country,
            "state" => $address->state,
            "city" => $address->city,
            "postalcode" => $address->postalcode,
            "modelable_type" => $address->modelable_type,
            "modelable_id" => $address->modelable_id,
            "kind" => $address->kind,
            "created_at" => $address->created_at,
            "updated_at" => $address->updated_at,
        ];
    }
}
