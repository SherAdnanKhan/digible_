<?php
namespace App\Http\Transformers\Chats;


use App\Http\Transformers\BaseTransformer;


class ChatReplyTransformer extends BaseTransformer
{

    public function transform($chatMessage)
    {
        return [
            'id' => $chatMessage['id'],
            'message' => $chatMessage['message'],
            'sender_id' => $chatMessage['sender_id'],
            'reciever_id' => $chatMessage['reciever_id'],
            'parent_id' => $chatMessage['parent_id'],
            'created_at' => $chatMessage['created_at'],
            'updated_at' => $chatMessage['updated_at'],
        ];
    }
}
