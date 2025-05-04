<?php

namespace Tests\Feature\Phd_tests;

use App\Http\Controllers\Api\PhotoController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class LoadPageTest extends TestCase
{
    use DatabaseMigrations;

    protected $seed = true;

    public function test1_profile_id_page(): void
    {
        $response = $this->get('/profile/2');
        $response->assertViewIs('author_template');
        $response->assertViewHas('author', 'StellarTraveler');
        $response->assertViewHas('articles',
            [
                [
                    'title' => 'Alien Discovery',
                    'content' => 'Astronomers have detected signals from a distant star system that may indicate the presence of intelligent life forms.'
                ],
                [
                    'title' => 'The Search for Exoplanets',
                    'content' => 'Scientists have identified a promising candidate for a habitable exoplanet orbiting a nearby star, fueling hopes for discovering extraterrestrial life.'
                ]
            ]
        );
    }

    public function test2_article_id_page(): void
    {
        $response = $this->get('/article/2');
        $response->assertViewIs('article_template');
        $response->assertViewHas('author', 'StellarTraveler');
        $response->assertViewHas('author_id', '2');
        $response->assertViewHas('title', 'Alien Discovery');
        $response->assertViewHas('content', 'Astronomers have detected signals from a distant star system that may indicate the presence of intelligent life forms.');
    }

    public function test3_profile_id_page_wrong_id(): void
    {
        file_put_contents('.' . DIRECTORY_SEPARATOR . 'phdays_log.txt', '');
        $this->get('/profile/1337');
        $data = file_get_contents('.' . DIRECTORY_SEPARATOR . 'phdays_log.txt');
        $this->assertTrue($data == 'Unable to load profile by id 1337');
        file_put_contents('.' . DIRECTORY_SEPARATOR . 'phdays_log.txt', '');
    }

    public function test4_my_profile_page(): void
    {
        $this->post('/api/auth/login', ['username' => 'GalacticExplorer', 'password' => 'explorer123']);

        $response = $this->get('/api/auth/my_profile');

        $response->assertViewIs('my_profile');
        $response->assertViewHas('author', 'GalacticExplorer');
        $response->assertViewHas('path_to_photo', URL::asset('.' . DIRECTORY_SEPARATOR . 'Photos' . DIRECTORY_SEPARATOR . 'default_profile_photo.jpg'));
        $response->assertViewHas('articles',
            [
                [
                    'title' => 'Exploring the Andromeda Galaxy',
                    'content' => 'Our journey to the Andromeda Galaxy revealed breathtaking views and mysterious phenomena.'
                ],
                [
                    'title' => 'Journey to the Edge of the Universe',
                    'content' => 'Embark on an epic journey to the farthest reaches of space, where time and space warp on unimaginable scales.'
                ]
            ]);
    }
}
