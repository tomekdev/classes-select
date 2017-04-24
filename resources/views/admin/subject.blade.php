@extends('layouts.admin') @section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>{{$subject? 'Edytuj przedmiot wybieralny' : 'Dodaj przedmiot wybieralny'}}</h3>
                    </div>
                    <div class="panel-body">
                <form class="form form-horizontal" method="post" action="{{$subject? route('admin.saveSubject', ['id' => $subject->id]) : route('admin.saveSubject')}}">
                    <h4>Dane przedmiotu wybieralnego</h4>
                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Nazwa</label>

                        <div class="col-md-10">
                            <input type="text" name="name" class="form-control" id="name" required value="{{$subject? $subject->name : (old('name')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_person" class="col-md-2 control-label">Min osób</label>

                        <div class="col-md-10">
                            <input type="text" name="min_person" class="form-control" id="min_person" required value="{{$subject? $subject->min_person : (old('min_person')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max_person" class="col-md-2 control-label">Max osób</label>

                        <div class="col-md-10">
                            <input type="text" name="max_person" class="form-control" id="max_person" required value="{{$subject? $subject->max_person : (old('max_person')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[faculty_id]" class="col-md-2 control-label">Wydział</label>
                        <div class="col-md-10">
                            <select id="0" name="fields[faculty_id]" class="form-control select" onchange="ajaxGetFields(this.value, this.id)">
                                <option value="">-- wybierz --</option>
                                @foreach ($faculties as $faculty)
                                    <option value="{{$faculty->id}}" {{ $subject ? $faculty->id == $subject->getFaculty()->id ? 'selected' : '' : '' }}>{{$faculty->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[field_id]" class="col-md-2 control-label">Kierunek</label>
                        <div class="col-md-10">
                            <select id="select-field0" name="fields[field_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach ($fields as $field)
                                    <option value="{{$field->id}}" {{ $subject ? $field->id == $subject->getField()->id ? 'selected' : '' : '' }}>{{$field->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[semester_id]" class="col-md-2 control-label">Semestr</label>
                        <div class="col-md-10">
                            <select name="fields[semester_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach($semesters as $sem)
                                    <option value="{{$sem->id}}" {{ $subject ? $sem->id == $subject->getSemester()->id ? 'selected' : '' : '' }}>{{ $sem->number . ', ' . $sem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[degree_id]" class="col-md-2 control-label">Stopień</label>
                        <div class="col-md-10">
                            <select name="fields[degree_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach ($degrees as $degree)
                                    <option value="{{$degree->id}}" {{ $subject ? $degree->id == $subject->getDegree()->id ? 'selected' : '' : '' }}>{{$degree->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fields[study_form_id]" class="col-md-2 control-label">Forma studiów</label>
                        <div class="col-md-10">
                            <select name="fields[study_form_id]" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach ($study_forms as $study_form)
                                    <option value="{{$study_form->id}}" {{ $subject ? $study_form->id == $subject->getStudyForm()->id ? 'selected' : '' : '' }}>{{$study_form->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-raised pull-right">{{$subject? 'Zapisz' : 'Dodaj'}} przedmiot wybieralny</button>
                </form>
            </div>
                </div>
        </div>
    </div>
</div>
@endsection
