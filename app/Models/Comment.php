<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    protected $guarded = ['created_at'];

    /**
     * @OA\Schema(
     *     schema="Comment",
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
     *         property="parent_id",
     *         type="integer",
     *         example=null
     *     ),
     *     @OA\Property(
     *         property="comment",
     *         type="string",
     *         example="I like this collection"
     *     ),
     *     @OA\Property(
     *         property="commentable_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="commentable_type",
     *         type="string",
     *         example="App\Models\Collection"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         type="string",
     *         example="pending/approved"
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
     *         property="commentable",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Collection")
     *         }
     *     ),
     * )
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_APPROVED => "approved",
            static::STATUS_REJECTED => "rejected",
        ];
    }
}
