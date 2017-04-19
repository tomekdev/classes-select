@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>{{$degree? 'Edytuj stopień' : 'Dodaj stopień'}}</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{$degree? route('admin.saveDegree', ['id' => $degree->id]) : route('admin.saveDegree')}}" method="post">
                            <div class="form-group label-floating">
                                <label for="name" class="control-label">Nazwa</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$degree? $degree->name : ''}}">
                            </div>
                            {{ csrf_field() }}
                            <div class="form-group label-floating">
                                <label for="type" class="control-label">Typ</label>
                                <input type="text" class="form-control" id="type" name="type" value="{{$degree? $degree->type : ''}}">
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary btn-raised">{{$degree? 'Zapisz' : 'Dodaj'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection