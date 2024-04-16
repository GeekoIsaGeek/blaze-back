<?php

namespace App\Helpers;

use Carbon\Carbon;

class Dates
{
    public static function ageFromBirthdate($birthdate)
    {
        $birthdate = Carbon::createFromFormat('Y-m-d', $birthdate);
        $now = Carbon::now();

        return $now->diffInYears($birthdate);
    }
}
