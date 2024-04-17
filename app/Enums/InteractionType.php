<?php

namespace App\Enums;

enum InteractionType: string
{
    case Like = 'like';
    case Dislike = 'dislike';
    case Match = 'match';
}
