<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $guarded = [
        'created_at',
    ];

    /**
     * @OA\Schema(
     *     schema="ChatMessage",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="sender_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="reciever_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="parent_id",
     *         type="integer",
     *         example=null
     *     ),
     *     @OA\Property(
     *         property="message",
     *         type="string",
     *         example="This collection avaialable?"
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

    public function replies()
    {
        return $this->hasMany(ChatMessage::class, 'parent_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id', 'id');
    }

}
