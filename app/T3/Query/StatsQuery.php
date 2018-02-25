<?php

namespace App\T3\Query;

use DB;

class StatsQuery
{
    /**
     * Collect contribution statistics which include the total
     * amount of Playlists & Tracks added, as well as the 
     * collective Track duration
     * 
     * @return stdClass
     */
    public function getContributionStats()
    {
        $contributionStats = DB::table('playlists')
            ->selectRaw('
                COUNT(distinct(playlists.id)) as PlaylistCount,
                COUNT(tracks.id) as TrackCount,
                SUM(tracks.duration) as AllTrackDuration
            ')
            ->join('tracks', 'tracks.playlist_id', '=', 'playlists.id')
            ->first();

        return $contributionStats;
    }
}
