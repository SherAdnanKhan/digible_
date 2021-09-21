<?php

namespace App\Models;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const USER_STATUS_NEW = 'new';
    const USER_STATUS_ACTIVE = 'active';
    const USER_STATUS_DISABLED = 'disabled';

    protected $guard_name = 'web';

    /**
     * @OA\Schema(
     *     schema="User",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="first_name",
     *         type="string",
     *         example="John"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         example="Doe"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         example="johndoe@gmail.com"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="22020-10-21T09:33:59.000000Z"
     *     ),
     * )
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activation_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    public static function statuses(): array
    {
        return [
            static::USER_STATUS_NEW => "New",
            static::USER_STATUS_ACTIVE => "Active",
            static::USER_STATUS_DISABLED => "Disabled",
        ];
    }

    public function favourites()
    {
        return $this->belongsToMany(CollectionItem::class, 'favourites', 'user_id', 'collection_item_id')->withTimeStamps();
    }
}
