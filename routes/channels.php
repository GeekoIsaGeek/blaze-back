<?php

use App\Broadcasting\ChatChannel;
use App\Broadcasting\MatchChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('match.{id}', MatchChannel::class);
Broadcast::channel('chat.{id}', ChatChannel::class);
