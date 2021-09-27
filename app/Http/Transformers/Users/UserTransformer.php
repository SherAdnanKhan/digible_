<?php
namespace App\Http\Transformers\Users;

use App\Models\User;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;

class UserTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
         'status'
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }

    public function includeStatus(User $user)
    {
        $item = [
            'id' => $user->id,
            'name' => data_get(User::statuses(), $user->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }
}
