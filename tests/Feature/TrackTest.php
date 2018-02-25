<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @return void
     */
    public function test_searching_without_criteria_throws_bad_request_exception()
    {
        $this->json('GET', 'api/search/')
            ->assertStatus(400)
            ->assertJsonFragment(['message' => 'Query term not specified for searching']);
    }

    /**
     * @return void
     */
    public function test_searching_fails_to_find_tracks_based_on_invalid_criteria()
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $playlist->tracks()->save(
            factory(Track::class)->make([
                'artist' => 'Run DMC'
            ])
        );

        // Attempt to find the arist with invalid search criteria
        $response = $this->json('GET', 'api/search/', ['q' => 'Some random artist'])
            ->assertStatus(200)
            ->decodeResponseJson();

        // Assert an empty set of results
        $this->assertCount(0, $response['data']);
    }

    /**
     * @return void
     */
    public function test_searching_finds_track_based_on_valid_criteria()
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $playlist->tracks()->save(
            factory(Track::class)->make([
                'artist' => 'Run DMC'
            ])
        );

        // Attempt to find the arist with invalid search criteria
        $response = $this->json('GET', 'api/search/', ['q' => 'Run DMC'])
            ->assertStatus(200)
            ->decodeResponseJson();

        // Assert on results
        $this->assertCount(1, $response['data']);
        $this->assertEquals('Run DMC', $response['data'][0]['artist']);
    }

    /**
     * @return void
     */
    public function test_searching_tracks_returns_associated_playlist()
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $playlist->tracks()->save(
            factory(Track::class)->make([
                'artist' => 'Deep Dish'
            ])
        );

        // Attempt to find the arist with invalid search criteria
        $response = $this->json('GET', 'api/search/', ['q' => 'Deep Dish'])
            ->assertStatus(200)
            ->decodeResponseJson();

        // Assert on results
        $this->assertEquals('T3 Playlist #1', $response['data'][0]['playlist']['data']['name']);
    }
}
