<?php

namespace App\T3\Formatters;

class TrackDurationFormatter
{
    /**
     * Format seconds into a human readable minute:second
     *
     * @param int $duration
     *
     * @return string
     */
    public function format(int $duration) : string
    {
        $seconds = floor($duration / 1000) % 60;

        if (strlen($seconds) == 1) {
            $seconds = '0' . $seconds;
        }

        $minutes = floor(($duration / 1000) / 60) % 60;

        return $minutes . ':' . $seconds;
    }

    /**
     * Format seconds into minutes
     *
     * @param int $duration
     *
     * @return int
     */
    public function formatToMinutes(int $duration) : int
    {
        return floor(($duration / 1000) / 60);
    }
}
