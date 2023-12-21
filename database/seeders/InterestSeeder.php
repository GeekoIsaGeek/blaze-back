<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    private $interests = ['Acting','Art collecting','DJing','Dancing','Drawing','Graphic design','Painting','Photography','Podcasts','Poetry','Stand-up','Web design','Writing','Baking','Cooking','Board games','Chess','Paintball','Video games','Reading','Investing','Journaling','Karaoke','Makeup','Movies','Thrifting','Astronomy','Camping','Coding','Drones','Fishing','Flying','Gardening','Sailing', 'Skydiving','Traveling','Video editing','Archery','Bowling','GYM','Hiking','Ice skating','Martial arts','Powerlifting','Rock climbing','Running','Skiing','Snowboarding','Surfing','Swimming','Yoga','Politics','Culture','STEM','Philosophy'];

    public function run(): void
    {
        foreach($this->interests as $interest) {
            Interest::create(['interest' => $interest]);
        }
    }
}
