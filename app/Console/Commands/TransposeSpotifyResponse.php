<?php

namespace App\Console\Commands;

use App\Models\Track;
use App\Models\Playlist;
use App\T3\Spotify\Transposer;
use Illuminate\Console\Command;

class TransposeSpotifyResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't3:transpose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transpose the Spotify API response';

    /**
     * @var App\T3\Spotify\Transposer
     */
    private $transposer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Transposer $transposer)
    {
        $this->transposer = $transposer;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $playlistJson = file_get_contents(public_path() . '/playlist03:08-3.json');
        $playlistJson = json_decode($playlistJson);

        return $this->transposer->transpose($playlistJson);
    }
}
