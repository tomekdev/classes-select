@extends('layouts.student')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>{{$firstTime? 'Witamy!' : 'Resetowanie hasła'}}</h3>
                </div>
                <div class="panel-body">
                    @if ($firstTime)
                        <span class="help-block">Twoja tożsamość musi zostać potwierdzona przed rozpoczęciem korzystania z systemu. W tym celu prosimy o uzupełnienie maila uczelnianego, na który zostaną przesłane dalsze instrukcje. </span>
                    @endif
                    <form action="{{ route('student.sendToken', ['firstTime' => $firstTime]) }}" method="post">
                        <div class="form-group label-floating">
                            <label for="email" class="control-label">Adres e-mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{{ old('email') }}}" autofocus>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised">{{$firstTime? 'Dalej' : 'Resetuj'}}</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
