<?php
namespace App\Http\Services\Chats;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Chats\ChatRepository;
use App\Http\Services\BaseService;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Chatservice extends BaseService
{
    protected $repository;
    protected $service;

    public function __construct(ChatRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getAll()
    {
        try {
        Log::info(__METHOD__ . " -- Get all conversation data all fetched: ");
        return $this->repository->getAll();

        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function getChat(User $user)
    {
        try {
            Log::info(__METHOD__ . " -- Chat Message data all fetched: ");
            $result = $this->repository->getChat($user);
            return $this->service->paginate($result);

        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function save(array $data)
    {
        // try {
            $data['sender_id'] = Auth::user()->id;
            $data['parent_id'] = null;
            $data['conversation_id'] = null;

            $conversation = Conversation::where([['sender_id', auth()->user()->id], ['reciever_id', $data['reciever_id']]])
                ->orWhere([['sender_id', $data['reciever_id']], ['reciever_id', auth()->user()->id]])->first();
            if ($conversation) {
                $data['conversation_id'] = $conversation->id;
                $conversation->updated_at = now();
                $conversation->save();
            }
            else{ 
               $conversation = Conversation::create(['sender_id'=> auth()->user()->id, 'reciever_id' => $data['reciever_id']]);
               $data['conversation_id'] = $conversation->id;
            }
            if (isset($data['id'])) {
                $chatMessageExist = ChatMessage::where(['id' => $data['id'], 'reciever_id' => $data['reciever_id']])->first();
                if ($chatMessageExist) {
                    $data['parent_id'] = $data['id'];
                    unset($data['id']);
                } else {
                    return false;
                }
            }
            Log::info(__METHOD__ . " -- New Chat Message request info: ", $data);
            $this->repository->save($data);
            return true;

        // } catch (Exception $e) {
        //     throw new ErrorException(trans('messages.general_error'));
        // }
    }

    public function delete(ChatMessage $chatMessage)
    {
        $chatMessage = $this->repository->delete($chatMessage);
    }

}
