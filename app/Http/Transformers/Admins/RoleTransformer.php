<?php
namespace App\Http\Transformers\Admins;

use App\Models\User;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use Spatie\Permission\Contracts\Role;

class RoleTransformer extends BaseTransformer
{
    public function transform(Role $role)
    {
        return [
            'name' => $role->name,
        ];
    }
}
