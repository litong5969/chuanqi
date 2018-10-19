<?php


namespace App\Mailer;

use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer {
    protected function sentTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email) {
            $message->from('278558486@qq.com', 'tony');
            $message->to($email);
        });
    }
}