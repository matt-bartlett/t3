<?php

namespace App\T3\Query;

use stdClass;
use App\Models\Track;
use App\Models\Playlist;
use App\T3\Formatters\TrackDurationFormatter;

class StatsQuery
{
    /**
     * @var App\Models\Track
     */
    private $track;

    /**
     * @var App\Models\Playlist
     */
    private $playlist;

    /**
     * @var App\T3\Formatters\TrackDurationFormatter
     */
    private $formatter;

    /**
     * Create a new class instance.
     *
     * @param App\Models\Track $track
     * @param App\Models\Playlist $playlist
     * @param App\T3\Formatters\TrackDurationFormatter $formatter
     */
    public function __construct(
        Track $track,
        Playlist $playlist,
        TrackDurationFormatter $formatter
    ) {
        $this->track = $track;
        $this->playlist = $playlist;
        $this->formatter = $formatter;
    }

    /**
     * Collect contribution statistics which include the total
     * amount of Playlists & Tracks added, as well as the
     * collective Track duration
     *
     * @return stdClass
     */
    public function getContributionStats() : stdClass
    {
        $totalTracks = $this->track->select(['id'])->count();
        $trackDuration = $this->track->select(['duration'])->sum('duration');
        $totalPlaylists = $this->playlist->select(['id'])->count();

        $contributionStats = new stdClass;
        $contributionStats->TrackCount = $totalTracks;
        $contributionStats->PlaylistCount = $totalPlaylists;
        $contributionStats->AllTrackDuration = $trackDuration;

        $contributionStats->AllTrackDuration = $this->formatter
            ->formatToMinutes($contributionStats->AllTrackDuration);

        return $contributionStats;
    }
}
