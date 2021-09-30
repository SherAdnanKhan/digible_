<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionItemOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'collection_item_order';

    public $timestamps = false;
    public $incrementing = false;

    /**
     * @OA\Schema(
     *     schema="CollectionItemOrder",
     *     @OA\Property(
     *         property="order_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="collection_item_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="quantity",
     *         type="integer",
     *         example=10
     *     ),
     *     @OA\Property(
     *         property="order",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Order")
     *         }
     *     ),
     *     @OA\Property(
     *         property="collectionItem",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/CollectionItem")
     *         }
     *     ),
     * )
     */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function collectionItem(): BelongsTo
    {
        return $this->belongsTo(CollectionItem::class);
    }

}
