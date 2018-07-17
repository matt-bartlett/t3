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
     * @return array
     */
    public function transform(stdClass $stats)
    {
        return [
            'total_track_count' => (integer) $stats->TrackCount,
            'total_playlist_count' => (integer) $stats->PlaylistCount,
            'total_track_duration' => (integer) $stats->AllTrackDuration
        ];
    }
}
