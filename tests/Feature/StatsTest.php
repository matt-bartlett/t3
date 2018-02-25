<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatsTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @return void
     */
    public function test_stats_generation()
    {
        factory(Playlist::class)->create()
            ->tracks()
            ->saveMany(
                factory(Track::class, 30)->make([
                    'duration' => 1000
                ])
            );

        $response = $this->json('GET', 'api/stats')->decodeResponseJson();

        $this->assertEquals($response['data']['PlaylistCount'], 1);
        $this->assertEquals($response['data']['TrackCount'], 30);
        $this->assertEquals($response['data']['AllTrackDuration'], 30000);
    }
}
