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
    public function test_searching_without_criteria_throws_bad_request_exception() : void
    {
        $this->json('GET', 'api/search/')
            ->assertStatus(400)
            ->assertJsonFragment(['message' => 'Query term not specified for searching']);
    }

    /**
     * @return void
     */
    public function test_searching_fails_to_find_tracks_based_on_invalid_criteria() : void
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $track = factory(Track::class)->create([
            'artist' => 'Run DMC'
        ]);

        // Attach Track to Playlist
        $playlist->tracks()->attach($track->id);

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
    public function test_searching_finds_track_based_on_valid_criteria() : void
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $track = factory(Track::class)->create([
            'artist' => 'Run DMC'
        ]);

        // Attach Track to Playlist
        $playlist->tracks()->attach($track->id);

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
    public function test_searching_tracks_returns_associated_playlist() : void
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $track = factory(Track::class)->create([
            'artist' => 'Deep Dish'
        ]);

        // Attach Track to Playlist
        $playlist->tracks()->attach($track->id);

        // Attempt to find the arist with invalid search criteria
        $response = $this->json('GET', 'api/search/', ['q' => 'Deep Dish'])
            ->assertStatus(200)
            ->decodeResponseJson();

        // Assert on results
        $this->assertEquals('T3 Playlist #1', $response['data'][0]['playlists']['data'][0]['name']);
    }

    /**
     * @return void
     */
    public function test_searching_tracks_returns_multiple_associated_playlists() : void
    {
        $playlists = factory(Playlist::class, 2)->create();

        $track = factory(Track::class)->create([
            'artist' => 'Long Way Homewards'
        ]);

        // Attach Playlists to Track
        $track->playlists()->attach($playlists->pluck('id'));

        // Attempt to find the arist with invalid search criteria
        $response = $this->json('GET', 'api/search/', ['q' => 'Long Way Homewards'])
            ->assertStatus(200)
            ->decodeResponseJson();

        $this->assertCount(2, $response['data'][0]['playlists']['data']);
    }
}
