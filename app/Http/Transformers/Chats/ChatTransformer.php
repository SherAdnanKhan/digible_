<?php
namespace App\Http\Transformers\Chats;

use App\Models\ChatMessage;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Transformers\Chats\ChatReplyTransformer;

class ChatTransformer extends BaseTransformer
{
    protected $defaultIncludes = ['sender', 'parent', 'reciever'];

    public function transform(ChatMessage $chatMessage)
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

    public function includeSender(ChatMessage $chatMessage)
    {
        $user = $chatMessage->sender;
        return $this->item($user, new UserTransformer);
    }

    public function includeReciever(ChatMessage $chatMessage)
    {
        $user = $chatMessage->reciever;
        return $this->item($user, new UserTransformer);
    }

    public function includeParent(ChatMessage $chatMessage)
    {
        $parent = ChatMessage::find($chatMessage->parent_id);
        if ($parent) {
            $parent = $parent->toArray();
            return $this->collection([$parent], new ChatReplyTransformer);
        }
        return;

    }

}
