<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionItem extends Model
{
    use HasFactory;
    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";
    const TYPE_BACKED = "backed";
    const TYPE_NON_BACKED = "nonbacked";
    const TYPE_NON_NFT = "nonnft";

    /**
     * @OA\Schema(
     *     schema="CollectionItem",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="collection_item_type_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="collection_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="nft_type",
     *         type="string",
     *         example="nonnft"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Cresselia"
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="string",
     *         example="sdasdwre32r.jpg"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         example="Digtal asset backed by 160 physical asset"
     *     ),
     *     @OA\Property(
     *         property="edition",
     *         type="string",
     *         example="ist"
     *     ),
     *     @OA\Property(
     *         property="graded",
     *         type="enum",
     *         example="yes"
     *     ),
     *     @OA\Property(
     *         property="year",
     *         type="date",
     *         example="2019-03-10 02:00:39"
     *     ),
     *     @OA\Property(
     *         property="population",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="publisher",
     *         type="string",
     *         example="2019-03-10 02:00:39"
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
     *             example="pending"
     *         )
     *     ),
     *     @OA\Property(
     *         property="available_for_sale",
     *         type="boolean",
     *         example="true"
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
     *         property="collection",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Collection")
     *         }
     *     ),
     *     @OA\Property(
     *         property="collectionItemType",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/CollectionItemType")
     *         }
     *     ),
     * )
     */

    protected $guarded = ['created_at'];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function collectionItemType(): BelongsTo
    {
        return $this->belongsTo(CollectionItemType::class);
    }
    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_APPROVED => "approved",
            static::STATUS_REJECTED => "rejected",
        ];
    }
    public static function nfttype(): array
    {
        return [
            static::TYPE_BACKED => "backed",
            static::TYPE_NON_BACKED => "nonbacked",
            static::TYPE_NON_NFT => "nonnft",
        ];
    }
}
