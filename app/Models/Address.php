<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

        /**
     * @OA\Schema(
     *     schema="Address",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *         example="87214 Margarita Radial"
     *     ),
     *     @OA\Property(
     *         property="address2",
     *         type="string",
     *         example="87214 Margarita Radial"
     *     ),
     *     @OA\Property(
     *         property="country",
     *         type="string",
     *         example="USA"
     *     ),
     *     @OA\Property(
     *         property="state",
     *         type="string",
     *         example="Bilzen"
     *     ),
     *     @OA\Property(
     *         property="city",
     *         type="string",
     *         example="Hoppeshire"
     *     ),
     *     @OA\Property(
     *         property="postalcode",
     *         type="string",
     *         example="22186"
     *     ),
     *     @OA\Property(
     *         property="modelable_type",
     *         type="string",
     *         example="App\Models\SellerProfile"
     *     ),
     *     @OA\Property(
     *         property="modelable_id",
     *         type="string",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="kind",
     *         type="string",
     *         example="permanent/temporary/shipping"
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

    protected $guarded = ['created_at'];

    public function Seller(): BelongsTo
    {
        return $this->belongsTo(SellerProfile::class);
    }
}
