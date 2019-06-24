<?php

namespace App\Listeners;

use App\Events\MessageCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class SendUserMessage implements ShouldQueue
{
    public $tries = 5;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MessageCreated $event)
    {
        Smsirlaravel::send($event->message,$event->phone);
    }
}
