<?php

namespace App\Http\Controllers;

use App\Jobs\MessageCreateJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class MessageController extends Controller
{
    public function addMessageJobs(Request $request)
    {
        info("Запрос");
        /**
         * @var $userList array
         */
        $userList = $request->get("to");
        info($userList);
        /**
         * @var $messageText string
         */
        $messageText = $request->get("message");
        $count = count($userList);
        if ($count < 1) {
            return \response(['status' => 'error data'], 400);
        }

        for ($i = 0; $i < $count; $i++) {

            $userID = $userList[$i];
            if (gettype($userID) != 'integer') {
                return \response(['status' => 'error data'], 400);
            }
            $job = new MessageCreateJob($messageText, $userID);
            $this->dispatch($job);
        }

        return \response(['status' => 'ok'], 200);


    }


}
