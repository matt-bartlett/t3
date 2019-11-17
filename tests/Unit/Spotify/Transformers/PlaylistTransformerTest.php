<?php

namespace Tests\Unit\Spotify\Transformers;

use Tests\TestCase;
use App\T3\Spotify\Transformers\PlaylistTransformer;

class PlaylistTransformerTest extends TestCase
{
    public $transformer;

    /**
     * @return void
     */
    public function setUp() : void
    {
        // Instantiate Transformer class
        $this->transformer = new PlaylistTransformer;

        parent::setUp();
    }

    /**
     * @return void
     */
    public function test_transforming_playlist_object_is_successful() : void
    {
        $playlist = $this->getFixture('playlist.txt');

        $result = $this->transformer->transform($playlist);

        $this->assertInternalType('array', $result);
        $this->assertEquals('1196791157', $result['owner_id']);
        $this->assertEquals('Uplifting Trance', $result['name']);

        $this->assertArrayHasKey('tracks', $result);
        $this->assertEquals('Giver of Life - Original Mix', $result['tracks'][0]['title']);
        $this->assertEquals('Giver of Life', $result['tracks'][0]['album']);
        $this->assertEquals('New World', $result['tracks'][0]['artist']);
    }
}
