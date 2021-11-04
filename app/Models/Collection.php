<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;

    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    protected $guarded = [
        'created_at',
    ];

    /**
     * @OA\Schema(
     *     schema="Collection",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="interger",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="John"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example=1
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="pending/approved"
     *         )
     *     ),
     *     @OA\Property(
     *         property="logo_image",
     *         type="string",
     *         format="string",
     *         example="12232332.jpg"
     *     ),
     *     @OA\Property(
     *         property="featured_image",
     *         type="string",
     *         format="string",
     *         example="12232332.jpg"
     *     ),
     *     @OA\Property(
     *         property="banner_image",
     *         type="string",
     *         format="string",
     *         example="12232332.jpg"
     *     ),
     *     @OA\Property(
     *         property="external_url",
     *         type="string",
     *         format="string",
     *         example="http://cding.com"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         format="string",
     *         example="this is collection description"
     *     ),
     *     @OA\Property(
     *         property="categories",
     *         type="string",
     *         format="string",
     *         example="ggr"
     *     ),
     *     @OA\Property(
     *         property="website",
     *         type="string",
     *         format="string",
     *         example="http://cding.com"
     *     ),
     *     @OA\Property(
     *         property="discord",
     *         type="string",
     *         format="string",
     *         example="http://discord.com/digible"
     *     ),
     *     @OA\Property(
     *         property="twitter",
     *         type="string",
     *         format="string",
     *         example="http://twitter.com/digible"
     *     ),
     *     @OA\Property(
     *         property="instagram",
     *         type="string",
     *         format="string",
     *         example="http://instagram.com/digible"
     *     ),
     *     @OA\Property(
     *         property="medium",
     *         type="string",
     *         format="string",
     *         example="http://medium.com/digible"
     *     ),
     *     @OA\Property(
     *         property="telegram",
     *         type="string",
     *         format="string",
     *         example="http://telegram.com/digible"
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
     *     @OA\Property(
     *         property="user",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     * )
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->where(['status' => 'approved']);
    }

    public function collectionitems()
    {
        return $this->hasMany(CollectionItem::class);
    }

    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_APPROVED => "approved",
            static::STATUS_REJECTED => "rejected",
        ];
    }
}
