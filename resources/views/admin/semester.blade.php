@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>{{$semester ? 'Edytuj semestr' : 'Dodaj semestr'}}</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{$semester? route('admin.saveSemester', ['id' => $semester->id]) : route('admin.saveSemester')}}" method="post">
                            <div class="form-group label-floating">
                                <label for="name" class="control-label">Nazwa semestru</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$semester? $semester->name : ''}}">
                            </div>
                            <div class="form-group label-floating">
                                <label for="number" class="control-label">Numer semestru</label>
                                <input type="text" class="form-control" id="number" name="number" value="{{$semester? $semester->number : ''}}">
                            </div>
                            {{ csrf_field() }}
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary btn-raised">{{$semester? 'Zapisz' : 'Dodaj'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection