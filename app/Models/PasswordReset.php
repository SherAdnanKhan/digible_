<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *     schema="PasswordReset",
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         example="admin@digible.co"
     *     ),
     *     @OA\Property(
     *         property="token",
     *         type="string",
     *         example="gFdgApE8sWmlbYLsxl44lol0wUsIOwSvH6ZEhaK6utNZAsenPn"
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

    protected $guarded = [
        'created_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
