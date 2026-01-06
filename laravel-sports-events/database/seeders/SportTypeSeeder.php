<?php

namespace Database\Seeders;

use App\Models\SportType;
use Illuminate\Database\Seeder;

class SportTypeSeeder extends Seeder
{
    public function run(): void
    {
        $sportTypes = [
            ['name' => 'Football', 'description' => 'Association football, commonly known as soccer'],
            ['name' => 'Basketball', 'description' => 'Indoor team sport played on a rectangular court'],
            ['name' => 'Tennis', 'description' => 'Racket sport played individually or in pairs'],
            ['name' => 'Volleyball', 'description' => 'Team sport with a net dividing two teams'],
            ['name' => 'Swimming', 'description' => 'Aquatic sport in pools or open water'],
            ['name' => 'Athletics', 'description' => 'Track and field events including running and jumping'],
            ['name' => 'Boxing', 'description' => 'Combat sport involving punching'],
            ['name' => 'Cycling', 'description' => 'Racing or riding bicycles'],
        ];

        foreach ($sportTypes as $type) {
            SportType::create($type);
        }
    }
}