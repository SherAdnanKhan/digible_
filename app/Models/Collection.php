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
    const STATUS_SOLD = "sold";

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
     *         type="string",
     *         example="pending/approved"
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
     *         property="logo_path",
     *         type="string",
     *         example="https://digible-api.staging.doodle.je/ac8596485fcdd6ee2d708a4a6cb24291_1637924326.png"
     *     ),
     *     @OA\Property(
     *         property="featured_path",
     *         type="string",
     *         example="https://digible-api.staging.doodle.je/6c27f03d7e05fafe06f225bcbeb42d3a_1637924327.png"
     *     ),
     *     @OA\Property(
     *         property="banner_path",
     *         type="string",
     *         example="https://digible-api.staging.doodle.je/ac8596485fcdd6ee2d708a4a6cb24291_1637924326.png"
     *     ),
     *     @OA\Property(
     *         property="user",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     * )
     */

    protected $appends = ['logo_path', 'featured_path', 'banner_path'];

    public function getLogoPathAttribute()
    {
        return $this->logo_image ? asset('/' . $this->logo_image) : null;
    }

    public function getFeaturedPathAttribute()
    {
        return $this->featured_image ? asset('/' . $this->featured_image) : null;
    }

    public function getBannerPathAttribute()
    {
        return $this->banner_image ? asset('/' . $this->banner_image) : null;
    }

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

    public function scopeApproved($query)
    {
        return $query->where(['status' => Collection::STATUS_APPROVED]);
    }

    public function scopePending($query)
    {
        return $query->where(['status' => Collection::STATUS_PENDING]);
    }

    public function scopeRejected($query)
    {
        return $query->where(['status' => Collection::STATUS_REJECTED]);
    }

    public function scopeSold($query)
    {
        return $query->where(['status' => Collection::STATUS_SOLD]);
    }
}
