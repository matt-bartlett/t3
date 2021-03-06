<?php

namespace App\T3\Transformers;

use App\Models\Track;
use League\Fractal\TransformerAbstract;
use App\T3\Transformers\PlaylistTransformer;
use App\T3\Formatters\TrackDurationFormatter;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TrackTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'playlists'
    ];

    /**
     * Transform model output
     *
     * @param App\Models\Track $track
     *
     * @return array
     */
    public function transform(Track $track) : array
    {
        return [
            'title' => (string) $track->title,
            'album' => (string) $track->album,
            'artist' => (string) $track->artist,
            'duration' => (int) $track->duration,
            'spotify_url' => (string) $track->spotify_url,
            'spotify_track_id' => (string) $track->spotify_track_id,
            'duration_formatted' => $this->formatTrackDuration($track->duration),
            'spotify_preview_url' => (string) $track->spotify_preview_url,
            'spotify_thumbnail_url' => (string) $track->spotify_thumbnail_url,
        ];
    }

    /**
     * Include Playlist in transformation
     *
     * @param App\Models\Track $track
     *
     * @return League\Fractal\Resource\Item
     */
    public function includePlaylists(Track $track)
    {
        $playlists = $track->playlists()->get();

        $resource = ($this->collection($playlists, new PlaylistTransformer));

        return $resource;
    }

    /**
     * Format seconds into a human readable minute:second
     *
     * @param int $duration
     *
     * @return string
     */
    protected function formatTrackDuration(int $duration) : string
    {
        return (new TrackDurationFormatter)->format($duration);
    }
}
