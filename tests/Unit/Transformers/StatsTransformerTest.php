<?php

namespace Tests\Unit\Transformers;

use stdClass;
use Tests\TestCase;
use App\T3\Transformers\StatsTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatsTransformerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /**
     * @return void
     */
    public function test_stats_query_transforms() : void
    {
        $expected = [
            'data' => [
                'total_track_count' => 30,
                'total_playlist_count' => 5,
                'total_track_duration' => 3000
            ]
        ];

        $stats = new stdClass;
        $stats->TrackCount = 30;
        $stats->PlaylistCount = 5;
        $stats->AllTrackDuration = 3000;

        $output = fractal($stats, new StatsTransformer)->toArray();

        $this->assertEquals($output, $expected);
    }
}
