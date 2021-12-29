<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory;

        /**
     * @OA\Schema(
     *     schema="Auction",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="collection_item_id",
     *         type="interger",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="buyer_id",
     *         type="interger",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="seller_id",
     *         type="interger",
     *         example=2
     *     ),
     *     @OA\Property(
     *         property="base_price",
     *         type="float",
     *         example=10
     *     ),
     *     @OA\Property(
     *         property="last_price",
     *         type="float",
     *         example=11
     *     ),
     *     @OA\Property(
     *         property="status",
     *         type="string",
     *         format="string",
     *         example="pending"
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
     *         property="seller",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     *     @OA\Property(
     *         property="buyer",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/User")
     *         }
     *     ),
     * )
     */

    const STATUS_PENDING = "pending";
    const STATUS_WON = "won";
    const STATUS_LOST = "lost";
    const STATUS_PURCHASED = "purchased";
    const STATUS_EXPIRED = "expired";

    protected $guarded = ['created_at'];

    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_WON => "success",
            static::STATUS_LOST => "failed",
            static::STATUS_EXPIRED => "expired",
        ];
    }

    public function collectionItem(): BelongsTo
    {
        return $this->belongsTo(CollectionItem::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }
}
