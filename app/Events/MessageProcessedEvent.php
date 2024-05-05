<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageProcessedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;


    public string $message;
    public int $senderId;
    private int $chatId;

    public function __construct(string $message, int $senderId, int $chatId)
    {
        $this->$message = $message;
        $this->senderId = $senderId;
        $this->chatId = $chatId;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("chat.$this->chatId"),
        ];
    }
}
