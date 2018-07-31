@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h5 class="panel-title pull-left">Playlists</h5>
                    <div class="btn-group pull-right">
                        <a class="btn btn-primary" href="{{ route('admin.playlists.create') }}">Create New Playlist</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if ($playlists->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td class="text-center">Owner</td>
                                    <td class="text-center">Tracks</td>
                                    <td class="text-center">Created</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr>
                                        <td>{{ $playlist->id }}</td>
                                        <td>{{ $playlist->name }}</td>
                                        <td class="text-center">{{ $playlist->owner_name }}</td>
                                        <td class="text-center">{{ $playlist->tracks->count() }}</td>
                                        <td class="text-center">{{ $playlist->created_at }}</td>
                                        <td class="text-right">
                                            <a class="btn btn-sm btn-default" href="{{ route('admin.playlists.edit', $playlist->id) }}">Edit</a>
                                            <form style="display: inline-block;" method="POST" action="{{ route('admin.playlists.destroy', $playlist->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
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
