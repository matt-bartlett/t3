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
            'id' => $playlist->id,
            'name' => $playlist->name,
            'owner' => $playlist->owner_id,
            'playlist_uri' => $playlist->playlist_uri
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
