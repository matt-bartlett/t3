<?php

namespace Tests\Unit\Utils\Format;

use Tests\TestCase;
use App\Models\Track;
use App\T3\Utils\Format\PlaylistDurationFormatter;

class PlaylistDurationFormatterTest extends TestCase
{
    public $formatter;

    public function setUp() : void
    {
        parent::setUp();
        $this->formatter = new PlaylistDurationFormatter;
    }

    /**
     * @return void
     */
    public function test_total_track_ms_durations_formats_to_minutes() : void
    {
        $a = new Track;
        $a->duration = 120000; // 2 Minutes

        $b = new Track;
        $b->duration = 360000; // 6 Minutes

        $c = new Track;
        $c->duration = 480000; // 8 Minutes

        $tracks = collect([$a, $b, $c]);

        $duration = $this->formatter->format($tracks);

        $this->assertEquals(16, $duration);
        $this->assertInternalType('integer', $duration);
    }

    /**
     * @return void
     */
    public function test_total_duration_is_rounded_down_to_nearest_integer() : void
    {
        $a = new Track;
        $a->duration = 179000; // 2:59 Minutes

        $b = new Track;
        $b->duration = 50000; // 0:50 Minutes

        $tracks = collect([$a, $b]);

        $duration = $this->formatter->format($tracks);

        $this->assertEquals(3, $duration);
    }
}
