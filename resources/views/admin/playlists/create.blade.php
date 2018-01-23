@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Create Playlist</h5>
                </div>
                <div class="panel-body">

                    @include('partials/errors')

                    <form class="form-horizontal" method="POST" action="{{ route('admin.playlists.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="spotify_playlist_id" class="col-md-4 control-label">Spotify Playlist ID</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="spotify_playlist_id" name="spotify_playlist_id" value="{{ old('spotify_playlist_id') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="spotify_account_id" class="col-md-4 control-label">Spotify Account ID</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="spotify_account_id" name="spotify_account_id" value="{{ old('spotify_account_id') }}">
                            </div>
                        </div>

                        <div class="alert alert-panel-info">
                            <p>If you wish to give this Playlist an alternative name to the one on Spotify, fill the <strong>Playlist Name</strong> field below.
                                Otherwise, leave it blank.
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Playlist Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Playlist
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
