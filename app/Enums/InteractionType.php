<?php

namespace App\Enums;

enum InteractionType: string
{
    case LIKE = 'like';
    case DISLIKE = 'dislike';
    case MATCH = 'match';
}
