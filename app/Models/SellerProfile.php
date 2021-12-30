<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerProfile extends Model
{
    use HasFactory;

        /**
     * @OA\Schema(
     *     schema="SellerProfile",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="user1"
     *     ),
     *     @OA\Property(
     *         property="surname",
     *         type="string",
     *         example="ben"
     *     ),
     *     @OA\Property(
     *         property="wallet_address",
     *         type="string",
     *         example="0xfbed75735e69c0b78fd70730ae92bd2b075cec2f"
     *     ),
     *     @OA\Property(
     *         property="phone_no",
     *         type="string",
     *         example="+1-202-555-0180"
     *     ),
     *     @OA\Property(
     *         property="twitter_link",
     *         type="string",
     *         example="https: //twitter.com/digible"
     *     ),
     *     @OA\Property(
     *         property="insta_link",
     *         type="string",
     *         example="https: //www.instagram.com/digible"
     *     ),
     *     @OA\Property(
     *         property="twitch_link",
     *         type="string",
     *         example="https: //www.twitch.tv/digible"
     *     ),
     *     @OA\Property(
     *         property="type",
     *         type="string",
     *         example="individual"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         type="string",
     *         example="pending/approved"
     *     ),
     *     @OA\Property(
     *         property="id_image",
     *         type="string",
     *         format="string",
     *         example="12232332.jpg"
     *     ),
     *     @OA\Property(
     *         property="address_image",
     *         type="string",
     *         format="string",
     *         example="12232332.jpg"
     *     ),
     *     @OA\Property(
     *         property="insurance_image",
     *         type="string",
     *         format="string",
     *         example="12232332.jpg"
     *     ),
     *     @OA\Property(
     *         property="code_image",
     *         type="string",
     *         format="string",
     *         example="12232332.jpg"
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
     *         property="code_path",
     *         type="string",
     *         example="https://digible-api.staging.doodle.je/ac8596485fcdd6ee2d708a4a6cb24291_1637924326.png"
     *     ),
     *     @OA\Property(
     *         property="insurance_path",
     *         type="string",
     *         example="https://digible-api.staging.doodle.je/6c27f03d7e05fafe06f225bcbeb42d3a_1637924327.png"
     *     ),
     *     @OA\Property(
     *         property="address_path",
     *         type="string",
     *         example="https://digible-api.staging.doodle.je/ac8596485fcdd6ee2d708a4a6cb24291_1637924326.png"
     *     ),
     *     @OA\Property(
     *         property="id_path",
     *         type="string",
     *         example="https://digible-api.staging.doodle.je/ac8596485fcdd6ee2d708a4a6cb24291_1637924326.png"
     *     ),
     *     @OA\Property(
     *         property="user",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     *     @OA\Property(
     *         property="addresses",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Address")
     *         }
     *     ),
     * )
     */
    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_CARDHOUSE = 'cardhouse';
    const TYPE_DIGI = 'digi';
    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    protected $guarded = ['created_at'];

    protected $appends = ['code_path', 'insurance_path', 'address_path', 'id_path'];

    public function getCodePathAttribute()
    {
        return $this->code_image ? asset('/' . $this->code_image) : null;
    }

    public function getInsurancePathAttribute()
    {
        return $this->insurance_image ? asset('/' . $this->insurance_image) : null;
    }

    public function getAddressPathAttribute()
    {
        return $this->address_image ? asset('/' . $this->address_image) : null;
    }

    public function getIDPathAttribute()
    {
        return $this->id_image ? asset('/' . $this->id_image) : null;
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'modelable');
    }

    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_APPROVED => "approved",
            static::STATUS_REJECTED => "rejected",
        ];
    }
    public static function types(): array
    {
        return [
            static::TYPE_INDIVIDUAL => "individual",
            static::TYPE_CARDHOUSE => "cardhouse",
            static::TYPE_DIGI => "digi",
        ];
    }
}
