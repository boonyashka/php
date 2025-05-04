<?php

namespace Tests\Feature\Phd_tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use DatabaseMigrations;

    protected $seed = true;

    public function test1_get_all_articles(): void
    {
        $response = $this->get('/api/articles');
        $response->assertSimilarJson(
            [
                [
                    "title" => "Exploring the Andromeda Galaxy",
                    "content" => "Our journey to the Andromeda Galaxy revealed breathtaking views and mysterious phenomena.",
                    "author" => "GalacticExplorer",
                    "authorProfileUrl" => "/profile/1"
                ],
                [
                    "title" => "Alien Discovery",
                    "content" => "Astronomers have detected signals from a distant star system that may indicate the presence of intelligent life forms.",
                    "author" => "StellarTraveler",
                    "authorProfileUrl" => "/profile/2"
                ],
                [
                    "title" => "Unveiling the Secrets of Black Holes",
                    "content" => "New observations shed light on the mysterious nature of black holes, challenging our understanding of the universe.",
                    "author" => "CosmicAdventurer",
                    "authorProfileUrl" => "/profile/3"
                ],
                [
                    "title" => "Journey to the Edge of the Universe",
                    "content" => "Embark on an epic journey to the farthest reaches of space, where time and space warp on unimaginable scales.",
                    "author" => "GalacticExplorer",
                    "authorProfileUrl" => "/profile/1"
                ],
                [
                    "title" => "The Search for Exoplanets",
                    "content" => "Scientists have identified a promising candidate for a habitable exoplanet orbiting a nearby star, fueling hopes for discovering extraterrestrial life.",
                    "author" => "StellarTraveler",
                    "authorProfileUrl" =>  "/profile/2"
                ]
            ]);
    }

    public function test2_add_new_article(): void
    {
        $this->assertDatabaseMissing('articles', ['articleId' => 6, 'title' => 'new_title', 'content' => 'new_content', 'userId' => 1]);

        $this->post('/api/auth/login', ['username' => 'GalacticExplorer', 'password' => 'explorer123']);
        $this->post('/api/auth/article_create', ['title' => 'new_title', 'content' => 'new_content']);

        $this->assertDatabaseHas('articles', ['articleId' => 6, 'title' => 'new_title', 'content' => 'new_content', 'userId' => 1]);
    }

    public function test3_search_by_keyword(): void
    {
        $response = $this->postJson(
            '/api/search',
            ['search' => 'journey']
        );

        $response->assertSimilarJson(
            [
                [
                    "title" => "Exploring the Andromeda Galaxy",
                    "content" => "Our journey to the Andromeda Galaxy revealed breathtaking views and mysterious phenomena.",
                    "author" => "GalacticExplorer",
                    "id" => 1
                ],
                [
                    "title" => "Journey to the Edge of the Universe",
                    "content" => "Embark on an epic journey to the farthest reaches of space, where time and space warp on unimaginable scales.",
                    "author" => "GalacticExplorer",
                    "id" => 4
                ]
            ]);
    }
}
