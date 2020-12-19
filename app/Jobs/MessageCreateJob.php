<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class MessageCreateJob implements ShouldQueue
{
    public $tries = 3;
    /**
     * @var string
     */
    protected $message;
    /**
     * @var int
     */
    protected $userID;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $userID)
    {
        $this->message = $message;
        $this->userID = $userID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = env("SEND_M_URL");
        $response = Http::post($url, [
            'to' => $this->userID,
            'message' => $this->message,
        ]);

        if ($response->ok()) {
            return info("Сообщение отправлено");
        }
        throw new \Exception("Ошибка отправки сообщения");


    }

    public function failed($exception = null)
    {
        info($exception);
    }
}
