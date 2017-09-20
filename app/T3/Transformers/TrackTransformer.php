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
            'title' => $track->title,
            'album' => $track->album,
            'artist' => $track->artist,
            'duration' => $track->duration,
            'spotify_url' => $track->spotify_url,
            'spotify_track_id' => $track->spotify_track_id,
            'duration_formatted' => $track->duration_formatted,
            'spotify_preview_url' => $track->spotify_preview_url,
            'spotify_thumbnail_url' => $track->spotify_thumbnail_url,
        ];
    }
}
