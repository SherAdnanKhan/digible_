<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;


    protected $guarded = [
        'created_at',
    ];

    protected $appends = ['conversation_name'];

    public function getConversationNameAttribute()
    {

        return $this->sender_id == auth()->user()->id ? $this->reciever->name : $this->sender->name;
    }

       /**
     * @OA\Schema(
     *     schema="Conversation",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="user1",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="user2",
     *         type="integer",
     *         example=1
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

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function last_message()
    {
        return $this->hasOne(ChatMessage::class)->latestOfMany();
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
