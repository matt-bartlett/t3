<div class="container-fluid banner">
    <div class="row">
        <div>
            <h1 class="banner-title">{{ $title }}</h1>
            @if (isset($duration) && isset($tracks))
                <div class="banner-details">
                    <h3 class="banner-span"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;&nbsp;{{ $duration }} Minutes</h3>
                    <h3 class="banner-span"><i class="fa fa-music" aria-hidden="true"></i>&nbsp;&nbsp;{{ $tracks }} Tracks</h3>
                </div>
            @endif
            @if (isset($return))
                <a class="btn btn-default" href="{{ route('playlists.index') }}">Go back</a>
                <a class="btn btn-danger" href="{{ $playlist->playlist_url }}" target="_blank">Go To Playlist</a>
                <a class="btn btn-danger" href="{{ $playlist->owner_profile_url }}" target="_blank">Go To Creator</a>
            @endif
        </div>
    </div>
</div>
