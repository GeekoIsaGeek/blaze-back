<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Queue\SerializesModels;

class MessageProcessedEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public mixed $message;
    private int $chatId;

    public function __construct(mixed $message, int $chatId)
    {
        $this->message = $message;
        $this->chatId = $chatId;
    }

    public function broadcastAs(): string
    {
        return 'messageProcessed';
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("chat.$this->chatId"),
        ];
    }
}
