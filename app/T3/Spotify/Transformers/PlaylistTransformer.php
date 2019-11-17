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
     *
     * @return array
     */
    public function transform(stdClass $object) : array
    {
        $playlist = [];
        $playlist['name'] = $this->get($object, 'name');
        $playlist['owner_id'] = $this->get($object->owner, 'id');
        $playlist['playlist_url'] = $this->get($object->external_urls, 'spotify');
        $playlist['owner_profile_url'] = $this->get($object->owner->external_urls, 'spotify');
        $playlist['playlist_thumbnail_url'] = $this->get($object->images, 'url');

        $playlist['tracks'] = collect($object->tracks->items)
            ->map(function ($track) {
                return [
                    'title' => $this->get($track->track, 'name'),
                    'album' => $this->get($track->track->album, 'name'),
                    'artist' => $this->get($track->track->album->artists, 'name'),
                    'duration' => $this->get($track->track, 'duration_ms'),
                    'spotify_url' => $this->get($track->track->external_urls, 'spotify'),
                    'spotify_track_id' => $this->get($track->track, 'id'),
                    'spotify_preview_url' => $this->get($track->track, 'preview_url'),
                    'spotify_thumbnail_url' => $this->get($track->track->album->images, 'url'),
                ];
            });

        return $playlist;
    }
}
