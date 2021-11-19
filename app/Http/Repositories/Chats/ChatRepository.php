<?php

namespace App\Http\Repositories\Chats;

use App\Models\ChatMessage;
use App\Models\User;

class ChatRepository
{

    public function getChat(User $user)
    {
        $chatMessages = ChatMessage::Where([['sender_id' , auth()->user()->id], ['reciever_id' , $user->id]])
        ->orWhere([['sender_id' , $user->id], ['reciever_id' , auth()->user()->id]])
            ->orderBy('created_at', 'DESC')->get();
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
