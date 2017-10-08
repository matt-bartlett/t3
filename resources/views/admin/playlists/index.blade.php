@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Playlists</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Owner</td>
                                <td>Tracks</td>
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
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center">
                {{ $playlists->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
