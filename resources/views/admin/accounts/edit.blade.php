@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Update Spotify User</h5>
                </div>
                <div class="panel-body">

                    @include('partials/errors')

                    <form class="form-horizontal" method="POST" action="{{ route('admin.accounts.update', $account->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Display Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $account->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="spotify_account_id" class="col-md-4 control-label">Spotify Account ID</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="spotify_account_id" name="spotify_account_id" value="{{ $account->spotify_account_id }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Account
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
