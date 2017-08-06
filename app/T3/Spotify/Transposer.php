<?php

namespace App\T3\Spotify;

use DB;
use stdClass;
use Exception;
use App\Models\Track;
use App\Models\Playlist;

class Transposer
{
    /**
     * Transpose the resulting object obtained from the Spotify API,
     * into the desired structure needed for creating both tracks
     * and playlists.
     *
     * @param stdClass $object
     * @return string
     */
    public function transpose(stdClass $object)
    {
        try {
            $playlist = array();
            $playlist['name'] = $this->get($object, 'name');
            $playlist['owner_id'] = $this->get($object->owner, 'id');
            $playlist['owner_profile_url'] = $this->get($object->owner->external_urls, 'spotify');
            $playlist['playlist_url'] = $this->get($object->external_urls, 'spotify');
            $playlist['playlist_thumbnail_url'] = $this->getFromArray($object->images, 'url');

            $tracks = array();
            foreach ($object->tracks->items as $track) {
                $trackArray = array();
                $trackArray['title'] = $this->get($track->track, 'name');
                $trackArray['artist'] = $this->getFromArray($track->track->album->artists, 'name');
                $trackArray['album'] = $this->get($track->track->album, 'name');
                $trackArray['duration'] = $this->get($track->track, 'duration_ms');
                $trackArray['spotify_track_id'] = $this->get($track->track, 'id');
                $trackArray['spotify_url'] = $this->get($track->track->external_urls, 'spotify');
                $trackArray['spotify_preview_url'] = $this->get($track->track, 'preview_url');
                $trackArray['spotify_thumbnail_url'] = $this->getFromArray($track->track->album->images, 'url');

                $trackObject = new Track($trackArray);
                $tracks[] = $trackObject;
            }

            DB::beginTransaction();
            $playlist = Playlist::create($playlist);
            $playlist->tracks()->saveMany($tracks);
            DB::commit();

            return $playlist;
        } catch (Exception $e) {
            DB::rollBack();
            var_dump($e->getMessage());
        }
    }

    /**
     * Helper method to check for the existance of the desired property
     * from an array. Returns the value if found, or an empty string.
     * Throws an exception if the property doesn't exist.
     *
     * @param array $array
     * @param string $property
     * @return string
     * @throws Exception
     */
    protected function getFromArray($array, $property)
    {
        if (is_array($array)) {
            if (property_exists($array[0], $property)) {
                if (!empty($array[0]->{$property})) {
                    return $array[0]->{$property};
                }

                return '';
            }
        }

        throw new Exception("Can't find that property");
    }

    /**
     * Helper method to check for the existance of the desired property
     * from an object. Returns the value if found, or an empty string.
     * Throws an exception if the property doesn't exist.
     *
     * @param array $array
     * @param string $property
     * @return string
     * @throws Exception
     */
    protected function get($object, $property)
    {
        if (property_exists($object, $property)) {
            if (!empty($object->{$property})) {
                return $object->{$property};
            }

            return '';
        }

        throw new Exception("Can't find that property");
    }
}
