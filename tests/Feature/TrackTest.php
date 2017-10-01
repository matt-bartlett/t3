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
        $response = $this->json('GET', 'api/search/', ['q' => 'Some random artist']);
        $response->assertStatus(200);

        // Decode JSON resposne to an array
        $decodedResponse = $response->decodeResponseJson();

        // Assert an empty set of results
        $this->assertCount(0, $decodedResponse['data']);
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
        $response = $this->json('GET', 'api/search/', ['q' => 'Run DMC']);
        $response->assertStatus(200);

        // Decode JSON resposne to an array
        $decodedResponse = $response->decodeResponseJson();

        // Assert on results
        $this->assertCount(1, $decodedResponse['data']);
        $this->assertEquals('Run DMC', $decodedResponse['data'][0]['artist']);
    }
}
