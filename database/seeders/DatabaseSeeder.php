<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'GalacticExplorer',
            'password' => 'explorer123',
        ]);

        User::factory()->create([
            'username' => 'StellarTraveler',
            'password' => 'traveler456',
        ]);

        User::factory()->create([
            'username' => 'CosmicAdventurer',
            'password' => 'adventurer789',
        ]);

        Article::factory()->create([
            'title' => 'Exploring the Andromeda Galaxy',
            'content' => 'Our journey to the Andromeda Galaxy revealed breathtaking views and mysterious phenomena.',
            'userId' => 1,
        ]);

        Article::factory()->create([
            'title' => 'Alien Discovery',
            'content' => 'Astronomers have detected signals from a distant star system that may indicate the presence of intelligent life forms.',
            'userId' => 2,
        ]);

        Article::factory()->create([
            'title' => 'Unveiling the Secrets of Black Holes',
            'content' => 'New observations shed light on the mysterious nature of black holes, challenging our understanding of the universe.',
            'userId' => 3,
        ]);

        Article::factory()->create([
            'title' => 'Journey to the Edge of the Universe',
            'content' => 'Embark on an epic journey to the farthest reaches of space, where time and space warp on unimaginable scales.',
            'userId' => 1,
        ]);

        Article::factory()->create([
            'title' => 'The Search for Exoplanets',
            'content' => 'Scientists have identified a promising candidate for a habitable exoplanet orbiting a nearby star, fueling hopes for discovering extraterrestrial life.',
            'userId' => 2,
        ]);
    }
}
