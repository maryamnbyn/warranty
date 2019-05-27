<?php

namespace App\Listeners;

use App\Events\SMSCreated;
use App\Firebase;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Kavenegar\KavenegarApi;

class SendUserSMS
{
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
        $api = new KavenegarApi(env('KAVEH_NEGAR_API_KEY'));
        $random_number = rand(1,10000);
        $check_device = Firebase::where('user_id' , $event->user_id)->where('device' ,$event->device)->first();
        $check_device->update([
            'code' => $random_number
        ]);
        $api->Send(env('SENDER_MOBILE'),env('KAVEH_NAGER_RECEPTOR'), $random_number);

    }
}
