<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Track;
use App\Models\Playlist;
use App\T3\Query\StatsQuery;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatsTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @var StatsQuery
     */
    private $query;

    /**
     * @return void
     */
    public function setUp() : void
    {
        $this->query = app(StatsQuery::class);

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_stats_generation()
    {
        $tracks = factory(Track::class, 30)->create([
            'duration' => 20000
        ]);

        $playlist = factory(Playlist::class)->create();

        // Attach all Tracks to Playlist
        $playlist->tracks()->attach($tracks->pluck('id'));

        $response = $this->json('GET', 'api/stats')->decodeResponseJson();

        // Get statistics for assertions
        $stats = $this->query->getContributionStats();

        $this->assertEquals($response['data']['total_playlist_count'], $stats->PlaylistCount);
        $this->assertEquals($response['data']['total_track_count'], $stats->TrackCount);
        $this->assertEquals($response['data']['total_track_duration'], $stats->AllTrackDuration);
    }
}
