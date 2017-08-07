@extends('layouts.master')

@section('banner')
    @include('partials/banner', [
        'title' => '#ThrowTogetherThursdays'
    ])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($playlists as $playlist)
                <div class="col-md-4">
                    <div class="spotify_playlist">
                        <a href="{{ route('playlists.show', $playlist->id) }}">
                            <div class="spotify_playlist_thumbnail">
                                <img src="{{ $playlist->playlist_thumbnail_url }}">
                                <div class="spotify_playlist_thumbnail_overlay">
                                    <h3>{{ $playlist->name }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="container text-center">
                <div class="row">
                    <div class="col-md-12">{{ $playlists->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
