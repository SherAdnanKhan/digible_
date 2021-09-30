<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    const WYRE_AUTH_URL = "https://jsonplaceholder.typicode.com/posts";
    const METHOD = "get";
    const PARAMS = ['param_a', 'param_a'];

    const NEW_ORDER = 0;
    const SUCCESS = 1;
    const FAILED = 2;
    const REFUNDED = 3;

    const DEBIT = 0;
    const CREDIT = 1;

    /**
     * @OA\Schema(
     *     schema="OrderTransaction",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="order_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="payment_id",
     *         type="string",
     *         example="44"
     *     ),
     *     @OA\Property(
     *         property="transaction_type",
     *         type="binary",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="transaction_number",
     *         type="string",
     *         example="sjd822"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         type="binary",
     *         example=2
     *     ),
     *     @OA\Property(
     *         property="currency",
     *         type="string",
     *         example= "USD"
     *     ),
     *     @OA\Property(
     *         property="total",
     *         type="double",
     *         example= 6
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
     *         property="order",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Order")
     *         }
     *     ),
     * )
     */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
