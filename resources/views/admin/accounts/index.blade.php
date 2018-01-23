@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h5 class="panel-title pull-left">Spotify Accounts</h5>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default" href="{{ route('admin.accounts.create') }}">Create</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if ($accounts->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Spotify ID</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->spotify_user_id }}</td>
                                        <td><a href="{{ route('admin.accounts.edit', $account->id) }}">Edit</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p>No Spotify accounts exist. Create a Spotify account to get started.</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-center">
                {{ $accounts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
