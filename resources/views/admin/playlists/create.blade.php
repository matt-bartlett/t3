@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Playlist</div>
                <div class="panel-body">

                    @include('partials/errors')

                    <form class="form-horizontal" method="POST" action="{{ route('admin.playlists.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('spotify_playlist_id') ? ' has-error' : '' }}">
                            <label for="spotify_playlist_id" class="col-md-4 control-label">Spotify Playlist ID</label>
                            <div class="col-md-6">
                                <input id="spotify_playlist_id" type="text" class="form-control" name="spotify_playlist_id" value="{{ old('spotify_playlist_id') }}">
                                @if ($errors->has('spotify_playlist_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('spotify_playlist_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('spotify_user_id') ? ' has-error' : '' }}">
                            <label for="spotify_user_id" class="col-md-4 control-label">Spotify User ID</label>
                            <div class="col-md-6">
                                <input id="spotify_user_id" type="text" class="form-control" name="spotify_user_id">
                                @if ($errors->has('spotify_user_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('spotify_user_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Get Playlist
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
