<?php

namespace App\T3\Transformers;

use App\Models\Playlist;
use League\Fractal\TransformerAbstract;
use App\T3\Transformers\TrackTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PlaylistTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'tracks'
    ];

    /**
     * Transform model output
     *
     * @param App\Models\Playlist $playlist
     * @return array
     */
    public function transform(Playlist $playlist)
    {
        return [
            'id' => (integer) $playlist->id,
            'name' => (string) $playlist->name,
            'owner' => (string) $playlist->owner_id,
            'duration' => (integer) $playlist->duration,
            'owner_name' => (string) $playlist->owner_name,
            'playlist_url' => (string) $playlist->playlist_url,
            'owner_profile_url' => (string) $playlist->owner_profile_url,
            'playlist_thumbnail_url' => (string) $playlist->playlist_thumbnail_url
        ];
    }

    /**
     * Transform model output
     *
     * @param App\Models\Playlist $playlist
     * @return League\Fractal\Resource\Collection
     */
    public function includeTracks(Playlist $playlist)
    {
        $tracks = $playlist->tracks()->paginate(20);

        $resource = ($this->collection($tracks, new TrackTransformer))
            ->setPaginator(new IlluminatePaginatorAdapter($tracks));

        return $resource;
    }
}
