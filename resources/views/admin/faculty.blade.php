@extends('layouts.admin')

@section('content')

 <div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>{{$faculty? 'Edytuj wydział' : 'Dodaj wydział'}}</h3>
                </div>
                <div class="panel-body">
                    <form action="{{$faculty? route('admin.savefaculty', ['id' => $faculty->id]) : route('admin.savefaculty')}}" method="post">
                        <div class="form-group label-floating">
                            <label for="name" class="control-label">Nazwa</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$faculty? $faculty->name : ''}}">
                        </div>    
                        {{ csrf_field() }}
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised">{{$faculty? 'Zapisz' : 'Dodaj'}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
             

@endsection