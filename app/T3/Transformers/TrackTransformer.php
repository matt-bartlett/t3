<?php

namespace App\T3\Transformers;

use App\Models\Track;
use League\Fractal\TransformerAbstract;

class TrackTransformer extends TransformerAbstract
{
    /**
     * Transform model output
     *
     * @param App\Models\Track $track
     * @return array
     */
    public function transform(Track $track)
    {
        return [
            'title' => (string) $track->title,
            'album' => (string) $track->album,
            'artist' => (string) $track->artist,
            'duration' => (integer) $track->duration,
            'spotify_url' => (string) $track->spotify_url,
            'spotify_track_id' => (string) $track->spotify_track_id,
            'duration_formatted' => (string) $track->duration_formatted,
            'spotify_preview_url' => (string) $track->spotify_preview_url,
            'spotify_thumbnail_url' => (string) $track->spotify_thumbnail_url,
        ];
    }
}
