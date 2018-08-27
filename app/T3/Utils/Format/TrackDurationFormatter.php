<?php

namespace App\T3\Utils\Format;

class TrackDurationFormatter
{
    /**
     * Format seconds into a human readable minute:second
     *
     * @param integer $duration
     * @return string
     */
    public function format($duration) : string
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
     * @param integer $duration
     * @return integer
     */
    public function formatToMinutes($duration) : int
    {
        return floor(($duration / 1000) / 60);
    }
}
