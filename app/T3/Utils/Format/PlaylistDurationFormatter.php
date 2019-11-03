<?php

namespace App\T3\Utils\Format;

use Illuminate\Database\Eloquent\Collection;

class PlaylistDurationFormatter
{
    /**
     * Calculate the total duration of all tracks within a playlist
     *
     * @param Illuminate\Database\Eloquent\Collection $tracks
     *
     * @return int
     */
    public function format($tracks) : int
    {
        $duration = $tracks->reduce(function (int $carry, $track) {
            return $carry + $track->duration;
        }, 0);

        return floor(($duration / 1000) / 60);
    }
}
