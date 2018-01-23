@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h5 class="panel-title pull-left">Playlists</h5>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default" href="{{ route('admin.playlists.create') }}">Create</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if ($playlists->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Owner</td>
                                    <td>Tracks</td>
                                    <td>Created</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr>
                                        <td>{{ $playlist->id }}</td>
                                        <td>{{ $playlist->name }}</td>
                                        <td>{{ $playlist->owner_name }}</td>
                                        <td>{{ $playlist->tracks->count() }}</td>
                                        <td>{{ $playlist->created_at }}</td>
                                        <td><a href="{{ route('admin.playlists.edit', $playlist->id) }}">Edit</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p>No Playlists exist. Fetch a Playlist from Spotify to get started.</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-center">
                {{ $playlists->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
