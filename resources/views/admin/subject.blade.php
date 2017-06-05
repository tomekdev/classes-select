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
                                    <option value="{{$sem->id}}" {{ $subject ? $sem->id == $subject->getSemester()->id ? 'selected' : '' : '' }}>{{ $sem->number . ' - ' . $sem->name }}</option>
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
                                    <option value="{{$degree->id}}" {{ $subject ? $degree->id == $subject->getDegree()->id ? 'selected' : '' : '' }}>{{$degree->name .' - ' .$degree->type}}</option>
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
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Zajęcia</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:void(0)" onclick="addSubSubject()"><h4>Dodaj zajęcia</h4></a>
                        </div>
                    </div>
                    <div id="subSubjects">
                        @foreach ($subject? $subject->getSubSubjects() : [] as $index => $subSubject)
                            <div class="panel">
                                <div class="panel-heading">
                                  <!--  <a href="javascript:void(0)" onclick="removeSubSubject(this)" class="pull-right">Usuń</a>-->
                                    <div class="form-group">
                                        <input id="subSubjects[{{$index}}][id]" name="subSubjects[{{$index}}][id]" type="hidden" value="{{$subSubject->id}}">
                                        <label for="subSubjects[{{$index}}][name]" class="col-md-2 control-label">Nazwa zajęć</label>
                                        <div class="col-md-8">
                                            <input id="subSubjects[{{$index}}][name]" name="subSubjects[{{$index}}][name]" class="form-control select" value="{{$subSubject->name}}" >
                                        </div>
                                        <div class="col-md-2">
                                            <div class="togglebutton">
                                                <label for="subSubjects[{{$index}}][active]">Zapisy
                                                <input id="subSubjects[{{$index}}][active]" name="subSubjects[{{$index}}][active]" type="checkbox" {{$subSubject->active? 'checked' : ''}}>
                                              </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subSubjects[{{$index}}][min_person]" class="col-md-2 control-label">Min osób</label>
                                        <div class="col-md-10">
                                            <input type="text" name="subSubjects[{{$index}}][min_person]" class="form-control" id="subSubjects[{{$index}}][min_person]" required value="{{$subSubject? $subSubject->min_person : (old('min_person')?: '')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subSubjects[{{$index}}][max_person]" class="col-md-2 control-label">Max osób</label>
                                        <div class="col-md-10">
                                            <input type="text" name="subSubjects[{{$index}}][max_person]" class="form-control" id="subSubjects[{{$index}}][max_person]" required value="{{$subSubject? $subSubject->max_person : (old('max_person')?: '')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-raised pull-right">{{$subject? 'Zapisz' : 'Dodaj'}} przedmiot wybieralny</button>
                </form>
            </div>
                </div>
        </div>
    </div>
</div>


<div class="panel" id="subSubject-template" style="display:none">
    <div class="panel-heading">
       <a href="javascript:void(0)" onclick="removeSubSubject(this)" class="pull-right">Usuń</a>
        <div class="form-group">
            <input id="subSubjects[@counter@][id]" name="subSubjects[@counter@][id]" type="hidden">
            <label for="subSubjects[@counter@][name]" class="col-md-2 control-label">Nazwa zajęć</label>
            <div class="col-md-8">
                <input id="subSubjects[@counter@][name]" name="subSubjects[@counter@][name]" class="form-control select@counter@" onchange="">
			</div>
			<div class="col-md-2">
                <div class="togglebutton">
					<label for="subSubjects[@counter@][active]">Zapisy
					    <input name="subSubjects[@counter@][active]" id="subSubjects[@counter@][active]" type="checkbox" checked="">
                    </label>
                </div>
			</div>
		</div>
        <div class="form-group">
            <label for="subSubjects[@counter@][min_person]" class="col-md-2 control-label">Min osób</label>
            <div class="col-md-10">
                <input type="text" name="subSubjects[@counter@][min_person]" class="form-control" id="subSubjects[@counter@][min_person]" required>
            </div>
        </div>
        <div class="form-group">
            <label for="subSubjects[@counter@][max_person]" class="col-md-2 control-label">Max osób</label>
            <div class="col-md-10">
                <input type="text" name="subSubjects[@counter@][max_person]" class="form-control" id="subSubjects[@counter@][max_person]" required>
            </div>
        </div>
	</div>
</div>	
       
<script type="text/javascript">
    var counter = {{count($subject? $subject->getSubSubjects() : [])}};
    function removeSubSubject(link) {
        $(link).closest('.panel').slideUp('normal', function() { $(this).remove(); } );
    }
    function addSubSubject() {
        var template = document.getElementById('subSubject-template').outerHTML;
        var template = template.replace('id="subSubject-template"', '');
        var template = template.replace('display:none', '');
        var template = template.split('@counter@').join(counter);//inna wersja replace, zamienia wszystkie wystąpienia
        $('#subSubjects').append(template);
        counter++;
    }
</script>
@endsection
