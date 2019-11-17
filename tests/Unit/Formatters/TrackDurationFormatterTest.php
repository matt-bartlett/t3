<?php

namespace Tests\Unit\Formatters;

use Tests\TestCase;
use App\Models\Track;
use App\T3\Formatters\TrackDurationFormatter;

class TrackDurationFormatterTest extends TestCase
{
    public $formatter;

    public function setUp() : void
    {
        parent::setUp();
        $this->formatter = new TrackDurationFormatter;
    }

    /**
     * @return void
     */
    public function test_duration_formats() : void
    {
        $this->assertEquals('0:53', $this->formatter->format(53000));
        $this->assertEquals('0:53', $this->formatter->format(53500));
        $this->assertEquals('2:50', $this->formatter->format(170000));
        $this->assertEquals('3:10', $this->formatter->format(190000));
    }

    /**
     * @return void
     */
    public function test_equally_divisible_duration_formats_an_exact_minute() : void
    {
        $this->assertEquals('3:00', $this->formatter->format(180000));
    }

    /**
     * @return void
     */
    public function test_duration_formats_to_minutes() : void
    {
        $this->assertEquals(3, $this->formatter->formatToMinutes(180000));
        $this->assertEquals(3, $this->formatter->formatToMinutes(230000));
        $this->assertEquals(6, $this->formatter->formatToMinutes(360999));
        $this->assertEquals(5235, $this->formatter->formatToMinutes(314100000));
    }
}
