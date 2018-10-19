<?php


namespace App\Repositories;


use App\Message;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository {

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    /**
     * @return mixed
     */
    public function getAllMessages()
    {
       return Message::where('to_user_id', user()->id)
            ->orWhere('from_user_id', user()->id)
            ->with([
                'fromUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                },
                'toUser' => function ($query) {
                    return $query->select(['id', 'name', 'avatar']);
                }])->latest()->get();
    }
    public function getDialogId($fromUserId,$toUserId)
    {

        $sendedMessages= Message::where('to_user_id', $toUserId)
            ->where('from_user_id', $fromUserId)->first();
        $receivedMessages= Message::where('to_user_id', $fromUserId)
            ->where('from_user_id', $toUserId)->first();
//        dd($sendedMessages,$receivedMessages);
        if($sendedMessages!=null){
            return $sendedMessages->dialog_id;
        }elseif ($receivedMessages!=null){
            return $receivedMessages->dialog_id;
        }else{
            return false;
        }
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getDialogMessagesByDialogId($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->with([
            'fromUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            },
            'toUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getSingleMessageByDialogId($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->first();
    }
}