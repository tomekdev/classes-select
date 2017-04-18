@extends('layouts.admin') @section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <h3>{{$student? 'Edytuj' : 'Dodaj'}} studenta</h3>
                </div>
                <form class="form form-horizontal col-lg-8 col-lg-offset-2" method="post" action="{{$student? route('admin.savestudent', ['id' => $student->id]) : route('admin.savestudent')}}">
                    <h4>Dane studenta</h4>
                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Imię</label>

                        <div class="col-md-10">
                            <input type="text" name="name" class="form-control" id="name" required value="{{$student? $student->name : (old('name')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="surname" class="col-md-2 control-label">Nazwisko</label>

                        <div class="col-md-10">
                            <input type="text" name="surname" class="form-control" id="surname" required value="{{$student? $student->surname : (old('surname')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="index" class="col-md-2 control-label">Numer indeksu</label>

                        <div class="col-md-10">
                            <input type="text" name="index" class="form-control" id="index" required value="{{$student? $student->index : (old('index')?: '')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-2 control-label">Email</label>

                        <div class="col-md-10">
                            <input type="email" name="email" class="form-control" id="email" required value="{{$student? $student->email : (old('email')?: '')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Kierunki studenta</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:void(0)" onclick="addField()"><h4>Dodaj kierunek</h4></a>
                        </div>
                    </div>
                    <div id="fields">
                        @foreach ($student? $student->getStudies() : [] as $key => $study)
                            <div class="panel">
                                <div class="panel-heading">
                                    <a href="javascript:void(0)" onclick="removeField(this)" class="pull-right">Usuń</a>
                                    <div class="form-group">
                                        <label for="fields[{{$key}}][faculty_id]" class="col-md-2 control-label">Wydział</label>
                                        <div class="col-md-10">
                                            <select id="{{$key}}" name="fields[{{$key}}][faculty_id]" class="form-control select" onchange="ajaxGetFields(this.value, this.id)">
                                                <option value="">-- wybierz --</option>
                                                @foreach ($faculties as $faculty)
                                                    <option value="{{$faculty->id}}" {{$study['field']->faculty_id == $faculty->id? 'selected' : ''}}>{{$faculty->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fields[{{$key}}][field_id]" class="col-md-2 control-label">Kierunek</label>
                                        <div class="col-md-10">
                                            <select id="select-field{{$key}}" name="fields[{{$key}}][field_id]" class="form-control select">
                                                <option value="">-- wybierz --</option>
                                                @foreach ($study['faculty']->getFields() as $field)
                                                    <option value="{{$field->id}}" {{$study['field']->id == $field->id? 'selected' : ''}}>{{$field->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fields[{{$key}}][semester_id]" class="col-md-2 control-label">Semestr</label>
                                        <div class="col-md-10">
                                            <select name="fields[{{$key}}][semester_id]" class="form-control select">
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-raised pull-right">{{$student? 'Zapisz' : 'Dodaj'}} studenta</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="panel" id="field-template" style="display:none">
    <div class="panel-heading">
        <a href="javascript:void(0)" onclick="removeField(this)" class="pull-right">Usuń</a>
        <div class="form-group">
            <label for="fields[@counter@][faculty_id]" class="col-md-2 control-label">Wydział</label>
            <div class="col-md-10">
                <select id="@counter@" name="fields[@counter@][faculty_id]" class="form-control select@counter@" onchange="ajaxGetFields(this.value, this.id)">
                    <option value="">-- wybierz --</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="fields[@counter@][field_id]" class="col-md-2 control-label">Kierunek</label>

            <div class="col-md-10">
                <select id="select-field@counter@" name="fields[@counter@][field_id]" class="form-control select@counter@">
                    <option value="">-- wybierz --</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="fields[@counter@][semester_id]" class="col-md-2 control-label">Semestr</label>
            <div class="col-md-10">
                <select name="fields[@counter@][semester_id]" class="form-control select@counter@">
                    <option value="">-- wybierz --</option>
                    @foreach($semesters as $sem)
                        <option value="{{$sem->id}}">{{ $sem->id . ', ' . $sem->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="fields[@counter@][id]" value="0"/>
        </div>
        <div class="form-group">
            <label for="fields[@counter@][degree_id]" class="col-md-2 control-label">Stopień</label>
            <div class="col-md-10">
                <select name="fields[@counter@][degree_id]" class="form-control select@counter@">
                    <option value="">-- wybierz --</option>
                    @foreach ($degrees as $degree)
                        <option value="{{$degree->id}}">{{$degree->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="fields[@counter@][study_form_id]" class="col-md-2 control-label">Forma studiów</label>
            <div class="col-md-10">
                <select name="fields[@counter@][study_form_id]" class="form-control select@counter@">
                    <option value="">-- wybierz --</option>
                    @foreach ($study_forms as $study_form)
                        <option value="{{$study_form->id}}">{{$study_form->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var counter = {{count($student? $student->getStudies() : [])}};
    function removeField(link) {
        $(link).closest('.panel').slideUp('normal', function() { $(this).remove(); } );
    }
    function addField() {
        var template = document.getElementById('field-template').outerHTML;
        var template = template.replace('id="field-template"', '');
        var template = template.replace('display:none', '');
        var template = template.split('@counter@').join(counter);//inna wersja replace, zamienia wszystkie wystąpienia
        $('#fields').append(template);
        $(".select" + counter).dropdown({"optionClass": "withripple"});
        counter++;
    }
</script>


@endsection
