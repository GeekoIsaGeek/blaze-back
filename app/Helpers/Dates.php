<?php

namespace App\Helpers;

use Carbon\Carbon;

class Dates
{
    public static function getAgeFromBirthdate($birthdate)
    {
        $birthdate = Carbon::parse($birthdate);
        $now = Carbon::now();
        return $birthdate->diffInYears($now);
    }
}
