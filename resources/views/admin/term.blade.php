@extends('layouts.admin') @section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>{{$term? 'Edycja' : 'Dodawanie'}} terminu zapisu</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post" class="form form-horizontal">
                        <div class="form-group">
                            <label for="faculty_id" class="col-md-2 control-label">Wydział</label>
                            <div class="col-md-10">
                                <select id="0" name="faculty_id" class="form-control select" onchange="ajaxGetFields(this.value, this.id)">
                                    <option value="">-- wybierz --</option>
                                    @foreach ($faculties as $faculty)
                                    <option value="{{$faculty->id}}" {{((old('faculty_id') && old('faculty_id') == $faculty->id) || ($term && !old('faculty_id') && $faculty->id == $term->getField()->getFaculty()->id))? 'selected' : ''}}>{{$faculty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field_id" class="col-md-2 control-label">Kierunek</label>
                            <div class="col-md-10">
                                <select id="select-field0" name="field_id" class="form-control select" onchange="">
                                    <option value="">-- wybierz --</option>
                                    @foreach ($fields as $field)
                                    <option value="{{$field->id}}" {{((old('field_id') && old('field_id') == $field->id) || ($term && !old('field_id') && $field->id == $term->getField()->id))? 'selected' : ''}}>{{$field->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="semester_id" class="col-md-2 control-label">Semestr</label>
                            <div class="col-md-10">
                                <select id="semester_id" name="semester_id" class="form-control select" onchange="">
                                    <option value="">-- wybierz --</option>
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->id}}" {{((old('semester_id') && old('semester_id') == $semester->id) || ($term && !old('semester_id') && $semester->id == $term->getSemester()->id))? 'selected' : ''}}>{{$semester->number}}, {{$semester->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="degree_id" class="col-md-2 control-label">Stopień</label>
                            <div class="col-md-10">
                                <select id="degree_id" name="degree_id" class="form-control select" onchange="">
                                    <option value="">-- wybierz --</option>
                                    @foreach ($degrees as $degree)
                                        <option value="{{$degree->id}}" {{((old('degree_id') && old('degree_id') == $degree->id) || ($term && !old('degree_id') && $degree->id == $term->getDegree()->id))? 'selected' : ''}}>{{$degree->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="study_form_id" class="col-md-2 control-label">Forma studiów</label>
                            <div class="col-md-10">
                                <select id="study_form_id" name="study_form_id" class="form-control select" onchange="">
                                    <option value="">-- wybierz --</option>
                                    @foreach ($study_forms as $study_form)
                                        <option value="{{$study_form->id}}" {{((old('study_form_id') && old('study_form_id') == $study_form->id) || ($term && !old('study_form_id') && $study_form->id == $term->getStudyForm()->id))? 'selected' : ''}}>{{$study_form->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min_average" class="col-md-2 control-label">Minimalna średnia</label>
                            <div class="col-md-10">
                                <input type="number" id="min_average" name="min_average" class="form-control" min="2" max="5" step="0.01" value="{{old('min_average')?: ($term? $term->min_average : '')}}" required />
                            </div>
                        </div>
						<div class="form-group">
                            <label for="start_date" class="control-label col-md-2">Data rozpoczęcia</label>
							<div class="col-md-4">
								<input type="text" class="form-control datetimepicker" name="start_date" id="start_date" value="{{old('start_date')?: ($term? $term->start_date : '')}}" required/>
							</div>
							
							<label for="finish_date" class="control-label col-md-2">Data zakończenia</label>
							<div class="col-md-4">
								<input type="text" class="form-control datetimepicker" name="finish_date" id="finish_date" value="{{old('finish_date')?: ($term? $term->finish_date : '')}}" required/>
							</div>
						</div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-raised pull-right">{{$term? 'Zapisz' : 'Dodaj'}} termin zapisu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection