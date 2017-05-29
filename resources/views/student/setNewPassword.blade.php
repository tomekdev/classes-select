@extends('layouts.student')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Nowe hasło</h3>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group label-floating">
                            <input type="password" class="form-control" id="password" name="password">
                            <label for="password" class="control-label">Nowe hasło</label>
                        </div>
                        <div class="form-group label-floating">
                            <input type="password" class="form-control" id="password_repeat" name="password_repeat">
                            <label for="password_repeat" class="control-label">Powtórz nowe hasło</label>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised">Zapisz</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
