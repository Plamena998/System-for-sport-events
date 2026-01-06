<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\SportType;
use App\Models\Organizer;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $sportTypes = SportType::all();
        $organizers = Organizer::all();

        if ($sportTypes->isEmpty() || $organizers->isEmpty()) {
            $this->command->warn('Please run SportTypeSeeder and OrganizerSeeder first!');
            return;
        }

        $events = [
            [
                'name' => 'Sofia Marathon 2026',
                'event_date' => Carbon::create(2026, 4, 15, 9, 0),
                'duration' => 240,
                'description' => 'Annual marathon through the streets of Sofia',
                'sport_type_id' => $sportTypes->where('name', 'Athletics')->first()->id,
                'organizer_id' => $organizers->random()->id,
            ],
            [
                'name' => 'Youth Basketball Championship',
                'event_date' => Carbon::create(2026, 3, 20, 14, 0),
                'duration' => 180,
                'description' => 'Regional championship for youth basketball teams',
                'sport_type_id' => $sportTypes->where('name', 'Basketball')->first()->id,
                'organizer_id' => $organizers->random()->id,
            ],
            [
                'name' => 'Summer Swimming Competition',
                'event_date' => Carbon::create(2026, 7, 10, 10, 0),
                'duration' => 300,
                'description' => 'Open swimming competition for all ages',
                'sport_type_id' => $sportTypes->where('name', 'Swimming')->first()->id,
                'organizer_id' => $organizers->random()->id,
            ],
            [
                'name' => 'Football League Finals',
                'event_date' => Carbon::create(2026, 5, 25, 18, 30),
                'duration' => 120,
                'description' => 'Final match of the regional football league',
                'sport_type_id' => $sportTypes->where('name', 'Football')->first()->id,
                'organizer_id' => $organizers->random()->id,
            ],
            [
                'name' => 'Tennis Open Tournament',
                'event_date' => Carbon::create(2026, 6, 5, 9, 0),
                'duration' => 480,
                'description' => 'Professional tennis tournament with international participants',
                'sport_type_id' => $sportTypes->where('name', 'Tennis')->first()->id,
                'organizer_id' => $organizers->random()->id,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}