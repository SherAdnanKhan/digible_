<?php
namespace App\Http\Transformers\Users;

use App\Models\User;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Models\WalletAddress;

class AddressTransformer extends BaseTransformer
{

    public function transform(WalletAddress $walletAddress)
    {
        return [
            'id' => $walletAddress->id,
            'address' => $walletAddress->address,
            'created_at' => $walletAddress->created_at,
            'updated_at' => $walletAddress->updated_at
        ];
    }
}
