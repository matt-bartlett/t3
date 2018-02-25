<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use App\T3\Transformers\TrackTransformer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TrackController extends Controller
{
    /**
     * @var App\Models\Track
     */
    private $track;

    /**
     * Initialise the controller
     *
     * @param App\Models\Track $track
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    /**
     * Search for track titles, artists or albums matching the search term
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     * @throws BadRequestHttpException
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        // Throw exception if query parameter isn't supplied
        if ($query === null) {
            throw new BadRequestHttpException('Query term not specified for searching');
        }

        $tracks = $this->track->with('playlist')->search($query)->get();

        $tracks = fractal($tracks, new TrackTransformer)
            ->includePlaylist()
            ->toArray();

        return response()->json($tracks);
    }
}
