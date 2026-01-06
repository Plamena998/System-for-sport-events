<?php

namespace Database\Seeders;

use App\Models\Organizer;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    public function run(): void
    {
        $organizers = [
            [
                'name' => 'Sofia Sports Club',
                'email' => 'info@sofiasports.bg',
                'phone' => '+359 2 123 4567',
                'address' => 'ul. Vasil Levski 45, Sofia',
            ],
            [
                'name' => 'National Sports Federation',
                'email' => 'contact@nsf.bg',
                'phone' => '+359 2 987 6543',
                'address' => 'bul. Tsarigradsko Shose 115, Sofia',
            ],
            [
                'name' => 'ProSport Events',
                'email' => 'events@prosport.bg',
                'phone' => '+359 888 123 456',
                'address' => 'pl. Bulgaria 1, Sofia',
            ],
            [
                'name' => 'Youth Athletics Association',
                'email' => 'youth@athletics.bg',
                'phone' => '+359 2 456 7890',
                'address' => 'ul. Graf Ignatiev 12, Sofia',
            ],
        ];

        foreach ($organizers as $organizer) {
            Organizer::create($organizer);
        }
    }
}