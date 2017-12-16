<?php

namespace App\T3\Spotify\Transformers;

use stdClass;

class PlaylistTransformer extends Transformer implements TransformerInterface
{
    /**
     * Transform the resulting object obtained from the Spotify API,
     * into the desired structure needed for creating both tracks
     * and playlists.
     *
     * @param stdClass $object
     * @return array
     */
    public function transform(stdClass $object)
    {
        $playlist = array();
        $playlist['name'] = $this->get($object, 'name');
        $playlist['owner_id'] = $this->get($object->owner, 'id');
        $playlist['playlist_url'] = $this->get($object->external_urls, 'spotify');
        $playlist['owner_profile_url'] = $this->get($object->owner->external_urls, 'spotify');
        $playlist['playlist_thumbnail_url'] = $this->get($object->images, 'url');

        $tracks = array();
        foreach ($object->tracks->items as $track) {
            $trackArray = array();
            $trackArray['title'] = $this->get($track->track, 'name');
            $trackArray['album'] = $this->get($track->track->album, 'name');
            $trackArray['artist'] = $this->get($track->track->album->artists, 'name');
            $trackArray['duration'] = $this->get($track->track, 'duration_ms');
            $trackArray['spotify_url'] = $this->get($track->track->external_urls, 'spotify');
            $trackArray['spotify_track_id'] = $this->get($track->track, 'id');
            $trackArray['spotify_preview_url'] = $this->get($track->track, 'preview_url');
            $trackArray['spotify_thumbnail_url'] = $this->get($track->track->album->images, 'url');
            $tracks[] = $trackArray;
        }

        $playlist['tracks'] = $tracks;

        return $playlist;
    }
}
