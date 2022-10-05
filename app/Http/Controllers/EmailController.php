<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function send($to = [], $subject = '', $view = '', $data = [])
    {
        $existing = config('mail');
        $new = array_merge(
            $existing, [
            'driver' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 465,
            'from' => [
                'address' => 'exedu@sharqforum.org',
                'name' => 'exedu@sharqforum.org',
            ],
            'username' => 'exedu@sharqforum.org',
            'password' => 'xzgaayzwldzhvril',
            'encryption' => 'ssl',
        ]);
        config(['mail' => $new]);
        foreach ($to as $recipient) {
            if($recipient){
                Mail::send($view, $data, function ($message) use ($subject, $recipient, $view) {
                    $message->subject($subject);
                    $message->to($recipient);
                    if ($view == 'emails.user_verification') {
                        $message->attach(public_path('assets/introductory_meeting.pdf'));
                    }
                });
            }
        }
    }

    public static function send_curl_mails(Request $request) {
        self::send($request['emails'], $request['subject'], $request['view'], $request['date']);
    }
}
