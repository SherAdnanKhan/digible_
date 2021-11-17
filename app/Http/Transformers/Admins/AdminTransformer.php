<?php
namespace App\Http\Transformers\Admins;

use App\Models\User;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;

class AdminTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
         'status','roles'
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'timezone' => $user->timezone,
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

    public function includeRoles(User $user)
    {
        return $this->collection($user->roles, new RoleTransformer);
    }
}
