<?php

namespace App\T3\Transformers;

use stdClass;
use League\Fractal\TransformerAbstract;

class StatsTransformer extends TransformerAbstract
{
    /**
     * Transform model output
     *
     * @param stdClass $stats
     *
     * @return array
     */
    public function transform(stdClass $stats) : array
    {
        return [
            'total_track_count' => (int) $stats->TrackCount,
            'total_playlist_count' => (int) $stats->PlaylistCount,
            'total_track_duration' => (int) $stats->AllTrackDuration
        ];
    }
}
