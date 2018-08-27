<?php

namespace App\T3\Query;

use stdClass;
use App\Models\Track;
use App\Models\Playlist;

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
     * Create a new class instance.
     *
     * @param App\Models\Track $track
     * @param App\Models\Playlist $playlist
     */
    public function __construct(Track $track, Playlist $playlist)
    {
        $this->track = $track;
        $this->playlist = $playlist;
    }

    /**
     * Collect contribution statistics which include the total
     * amount of Playlists & Tracks added, as well as the
     * collective Track duration
     *
     * @return stdClass
     */
    public function getContributionStats()
    {
        $totalTracks = $this->track->select(['id'])->count();
        $trackDuration = $this->track->select(['duration'])->sum('duration');
        $totalPlaylists = $this->playlist->select(['id'])->count();

        $contributionStats = new stdClass;
        $contributionStats->TrackCount = $totalTracks;
        $contributionStats->PlaylistCount = $totalPlaylists;
        $contributionStats->AllTrackDuration = $trackDuration;

        $contributionStats->AllTrackDuration = app('TrackDurationFormatter')
            ->formatToMinutes($contributionStats->AllTrackDuration);

        return $contributionStats;
    }
}
