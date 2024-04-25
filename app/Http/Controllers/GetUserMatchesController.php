<?php

namespace App\Http\Controllers;

use App\Enums\InteractionType;
use App\Models\Interaction;
use Illuminate\Http\Request;

class GetUserMatchesController extends Controller
{
    public function __invoke()
    {
        $matches = auth()->user()->matches;

        return $matches;
    }
}
