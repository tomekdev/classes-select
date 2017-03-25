@extends('layouts.student')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Logowanie</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('student.login') }}" method="post">
                        <div class="form-group label-floating">
                            <label for="login" class="control-label">Login</label>
                            <input type="text" class="form-control" id="login" name="login">
                            <span class="help-block">Jako login może posłużyć numer indeksu, lub mail przypisany do konta</span>
                        </div>
                        <div class="form-group label-floating">
                            <label for="password" class="control-label">Hasło</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="pull-right">
                            <button class="btn">Zapomniałem hasła</button>
                            <button type="submit" class="btn btn-primary">Zaloguj</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
