<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use function response;

class MessagesController extends Controller {
    protected $message;

    /**
     * MessagesController constructor.
     * @param $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }


    public function store()
    {
        $isThereADialogOrNot = $this->isThereADialog();
        $dialogId = $isThereADialogOrNot ? $isThereADialogOrNot : time() . Auth::id();
        $message = $this->message->create([
            'to_user_id' => request('user'),
            'from_user_id' => user('api')->id,
            'body' => request('body'),
            'dialog_id' => $dialogId,
        ]);
        if ($message) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    protected function isThereADialog()
    {
        $toUserId = request('user');
        $fromUserId = user('api')->id;
        return $this->message->getDialogId($fromUserId, $toUserId);
    }
}
