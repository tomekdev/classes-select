@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Logowanie</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.login') }}" method="post">
                        <div class="form-group label-floating">
                            <label for="login" class="control-label">Login</label>
                            <input type="text" class="form-control" id="login" name="login" value="{{{ old('login') }}}" autofocus>
                            <span class="help-block">Jako login może posłużyć mail przypisany do konta</span>
                        </div>
                        <div class="form-group label-floating">
                            <input type="password" class="form-control" id="password" name="password">
                            <label for="password" class="control-label">Hasło</label>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised">Zaloguj</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
