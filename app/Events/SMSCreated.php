<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SMSCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phone;
    public $random_number;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($random_number, $phone)
    {
        $this->random_number = $random_number;
        $this->phone = $phone;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
