<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PENDING = 0;
    const COMPLETED = 1;

    /**
     * @OA\Schema(
     *     schema="Order",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="ref_id",
     *         type="string",
     *         example="ORD-UtbRQMbX9I6rxuG"
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="discount",
     *         type="double",
     *         example=4
     *     ),
     *     @OA\Property(
     *         property="subtotal",
     *         type="double",
     *         example=10
     *     ),
     *     @OA\Property(
     *         property="tax",
     *         type="double",
     *         example=2
     *     ),
     *     @OA\Property(
     *         property="total",
     *         type="double",
     *         example= 6
     *     ),
     *     @OA\Property(
     *         property="status",
     *         type="binary",
     *         example= 1
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
     *     @OA\Property(
     *         property="transactions",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/OrderTransaction")
     *         }
     *     ),
     *     @OA\Property(
     *         property="orderDetails",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/CollectionItemOrder")
     *         }
     *     ),
     * )
     */

    public function currency(): string
    {
        switch ($this->currency) {
            case 'USD':return '$';
            case 'SAR':return 'SR';
            default:return $this->currency;
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collectionItem(): BelongsToMany
    {
        return $this->belongsToMany(CollectionItem::class)->withPivot('quantity');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(OrderTransaction::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(CollectionItemOrder::class);
    }

    public static function statuses(): array
    {
        return [
            static::PENDING => 0,
            static::COMPLETED => 1,
        ];
    }

}
