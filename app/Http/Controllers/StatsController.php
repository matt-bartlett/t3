<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\T3\Query\StatsQuery;
use App\T3\Transformers\StatsTransformer;

class StatsController extends Controller
{
    /**
     * @var App\T3\Query\StatsQuery
     */
    private $query;

    /**
     * Initialise the controller
     * 
     * @param App\T3\Query\StatsQuery $query
     */
    public function __construct(StatsQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Get the contribution statistics for T3
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->query->getContributionStats();

        $stats = fractal($data, new StatsTransformer)->toArray();

        return response()->json($stats);
    }
}
