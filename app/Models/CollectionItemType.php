<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionItemType extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *     schema="CollectionItemType",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Pokemon cards"
     *     ),
     *     @OA\Property(
     *         property="label",
     *         type="string",
     *         example="pokemoncards"
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

    protected $guarded = [
        'created_at',
    ];
}
