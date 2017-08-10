@extends('layouts.master')

@section('banner')
    @include('partials/banner', [
        'title' => $playlist->name,
        'tracks' => $playlist->tracks->count(),
        'duration' => $playlist->duration,
        'return' => true
    ])
@endsection

@section('content')
    <div class="container-fluid tracks">
        <div class="row">
            @foreach ($playlist->tracks as $track)
                <div class="col-md-8 col-md-offset-2 col-sm-12">
                    <div class="spotify_track clearfix">
                        <div class="spotify_track_thumbnail">
                            <img src="{{ $track->spotify_thumbnail_url }}">
                        </div>
                        <div class="spotify_track_information">
                            <h4 class="track-title">{{ $track->title }}</h4>
                            <p class="track-artist">{{ $track->artist }} - {{ $track->album }}</p>
                            <!-- <div class="audio-controls">
                                <audio controls src="{{ $track->spotify_preview_url }}"></audio>
                            </div> -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
