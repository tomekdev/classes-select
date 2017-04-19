@extends('layouts.admin') @section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <h3>{{savesSubject? 'Edytuj' : 'Dodaj'}} przedmiot wybieralny</h3>
                </div>
                <form class="form form-horizontal col-lg-8 col-lg-offset-2" method="post" action="{{$subject? route('admin.savesSubject', ['id' => $subject->id]) : route('admin.savesSubject')}}">
                    <h4>Dane studenta</h4>
                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Nazwa</label>

                        <div class="col-md-10">
                            <input type="text" name="name" class="form-control" id="name" required value="{{$subject? $subject->name : (old('name')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max_person" class="col-md-2 control-label">Max osób</label>

                        <div class="col-md-10">
                            <input type="text" name="max_person" class="form-control" id="max_person" required value="{{$subject? $subject->max_person : (old('max_person')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_person" class="col-md-2 control-label">Min osób</label>

                        <div class="col-md-10">
                            <input type="text" name="min_person" class="form-control" id="min_person" required value="{{$subject? $subject->min_person : (old('min_person')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[faculty_id]" class="col-md-2 control-label">Wydział</label>
                        <div class="col-md-10">
                            <select id="0" name="fields[faculty_id]" class="form-control select" onchange="ajaxGetFields(this.value, this.id)">
                                <option value="">-- wybierz --</option>
                                @foreach ($faculties as $faculty)
                                    <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[field_id]" class="col-md-2 control-label">Kierunek</label>
                        <div class="col-md-10">
                            <select id="select-field0" name="fields[field_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[semester_id]" class="col-md-2 control-label">Semestr</label>
                        <div class="col-md-10">
                            <select name="fields[semester_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach($semesters as $sem)
                                    <option value="{{$sem->id}}" {{ $sem->id == $study['semester']->id ? 'selected' : '' }}>{{ $sem->number . ', ' . $sem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="fields[{{$key}}][id]" value="{{ $study['id'] }}"/>
                    </div>
                    <div class="form-group">
                        <label for="fields[{{$key}}][degree_id]" class="col-md-2 control-label">Stopień</label>
                        <div class="col-md-10">
                            <select name="fields[{{$key}}][degree_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach ($degrees as $degree)
                                    <option value="{{$degree->id}}" {{$study['degree']->id == $degree->id? 'selected' : ''}}>{{$degree->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[{{$key}}][study_form_id]" class="col-md-2 control-label">Forma studiów</label>
                        <div class="col-md-10">
                            <select name="fields[{{$key}}][study_form_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach ($study_forms as $study_form)
                                    <option value="{{$study_form->id}}" {{$study['study_form']->id == $study_form->id? 'selected' : ''}}>{{$study_form->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-raised pull-right">{{$student? 'Zapisz' : 'Dodaj'}} studenta</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
