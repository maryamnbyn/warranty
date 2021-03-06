<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class MessageCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $phone;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$phone)
    {
        $this->phone =$phone;
        $this->message =$message;
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
