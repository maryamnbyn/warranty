<?php

namespace App\Listeners;

use App\Events\SMSCreated;
use App\Firebase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class SendUserSMS implements ShouldQueue
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
     * @param  SMSCreated  $event
     * @return void
     */
    public function handle(SMSCreated $event)
    {
        Smsirlaravel::send($event->text,$event->phone);
    }
}
