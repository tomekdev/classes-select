@extends('layouts.admin')

@section('content')

 <div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>{{$study_form? 'Edytuj formę studiów' : 'Dodaj formę studiów'}}</h3>
                </div>
                <div class="panel-body">
                    <form action="{{$study_form? route('admin.saveStudyForm', ['id' => $study_form->id]) : route('admin.saveStudyForm')}}" method="post">
                        <div class="form-group label-floating">
                            <label for="name" class="control-label">Nazwa</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$study_form? $study_form->name : ''}}">
                        </div>    
                        {{ csrf_field() }}
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised">{{$study_form? 'Zapisz' : 'Dodaj'}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
             

@endsection