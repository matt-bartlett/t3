<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Track;
use App\Models\Account;
use App\Models\Playlist;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlaylistTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @return void
     */
    public function test_visitor_can_view_playlists() : void
    {
        factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $response = $this->json('GET', 'api/playlists')
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'T3 Playlist #1']);
    }

    /**
     * @return void
     */
    public function test_visitor_can_view_specific_playlist() : void
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $tracks = factory(Track::class, 3)->create();

        // Attach all Tracks to Playlist
        $playlist->tracks()->attach($tracks->pluck('id'));

        $response = $this->json('GET', 'api/playlists/' . $playlist->id)
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'T3 Playlist #1'])
            ->decodeResponseJson();

        $this->assertCount(3, $response['data']['tracks']['data']);
    }

    /**
     * @return void
     */
    public function test_user_account_name_appears_on_playlist() : void
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1',
            'owner_id' => '123xyz789'
        ]);

        $account = factory(Account::class)->make([
            'name' => 'Matt Bartlett',
            'spotify_account_id' => '123xyz789'
        ]);

        $playlist->account()->save($account);

        $response = $this->json('GET', 'api/playlists/' . $playlist->id)
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'T3 Playlist #1'])
            ->decodeResponseJson();

        $this->assertEquals('Matt Bartlett', $response['data']['owner_name']);
    }

    /**
     * @return void
     */
    public function test_fetching_nonexistent_playlist_throws_404() : void
    {
        $this->json('GET', 'api/playlists/999')
            ->assertStatus(404)
            ->assertJsonFragment(['message' => 'Specified resource not found']);
    }

    /**
     * @return void
     */
    public function test_forbidden_http_method_when_fetching_playlist_throws_405() : void
    {
        $playlist = factory(Playlist::class)->create([
            'name' => 'T3 Playlist #1'
        ]);

        $this->json('POST', 'api/playlists/' . $playlist->id)
            ->assertStatus(405)
            ->assertJsonFragment(['message' => 'HTTP method forbidden on this resource']);
    }
}
