<?php

namespace App\Http\Repositories\Chats;

use App\Models\ChatMessage;

class ChatRepository
{

    public function getReplies(ChatMessage $chatMessage)
    {
        $chatMessages = ChatMessage::where(['parent_id' => $chatMessage->id])->get();
        return $chatMessages;
    }

    public function getAll(array $data)
    {
        $chatMessages = ChatMessage::where(['reciever_id' => $data['reciever_id'], 'sender_id' => auth()->user()->id])->get();
        return $chatMessages;
    }

    public function save(array $data): void
    {
        ChatMessage::create($data);
    }

    public function delete(ChatMessage $chatMessage)
    {
        ChatMessage::where('parent_id', $chatMessage->id)->delete();
        $chatMessage->delete();
        return $chatMessage;
    }
}
