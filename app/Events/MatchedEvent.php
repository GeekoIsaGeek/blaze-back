<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchedEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $likerDetails;
    public $receiverId;

    public function __construct($likerDetails, $receiverId)
    {
        $this->likerDetails = $likerDetails;
        $this->receiverId = $receiverId;
    }

    public function broadcastAs(): string
    {
        return 'matched';
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("match.$this->receiverId")
        ];
    }
}
