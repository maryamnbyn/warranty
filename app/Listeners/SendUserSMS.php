<?php

namespace App\Listeners;

use App\Events\SMSCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class SendUserSMS
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
        Smsirlaravel::sendVerification($event->random_number,$event->phone);
    }
}
