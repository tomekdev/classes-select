@extends('layouts.admin') @section('content')
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="panel panel-default">
        <form id="del" method="post">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4">
                            <h3>Zaimportowane średnie</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="fields[faculty_id]" class="col-md-2 control-label">Wydział</label>
                            <div class="col-md-10">
                                <select id="0" name="fields[faculty_id]" class="form-control select" onchange="ajaxGetFields(this.value, this.id)">
                                    <option value ="0">--bez zmian--</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{$faculty->id}}" {{ isset($selectedFields) ? ($faculty->id == $selectedFields['faculty_id'] ? ' selected' : '') : '' }}>{{$faculty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fields[field_id]" class="col-md-2 control-label">Kierunek</label>
                            <div class="col-md-10">
                                <select id="select-field0" name="fields[field_id]" class="form-control select">
                                    <option value ="0">--bez zmian--</option>
                                    @foreach ($fields as $field)
                                        <option value="{{$field->id}}" {{ isset($selectedFields) ? $field->id == $selectedFields['field_id'] ? ' selected' : '' : '' }}>{{$field->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fields[semester_id]" class="col-md-2 control-label">Semestr</label>
                            <div class="col-md-10">
                                <select name="fields[semester_id]" class="form-control select">
                                    <option value ="0">--bez zmian--</option>
                                    @foreach($semesters as $sem)
                                        <option value="{{$sem->id}}" {{ isset($selectedFields) ? $sem->id == $selectedFields['semester_id'] ? ' selected' : '' : '' }}>{{ $sem->number . ' - ' . $sem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fields[degree_id]" class="col-md-2 control-label">Stopień</label>
                            <div class="col-md-10">
                                <select name="fields[degree_id]" class="form-control select">
                                    <option value ="0">--bez zmian--</option>
                                    @foreach ($degrees as $degree)
                                        <option value="{{$degree->id}}" {{ isset($selectedFields) ? $degree->id == $selectedFields['degree_id'] ? ' selected' : '' : '' }}>{{$degree->name .' - ' .$degree->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fields[study_form_id]" class="col-md-2 control-label">Forma studiów</label>
                            <div class="col-md-10">
                                <select name="fields[study_form_id]" class="form-control select">
                                    <option value ="0">--bez zmian--</option>
                                    @foreach ($study_forms as $study_form)
                                        <option value="{{$study_form->id}}" {{ isset($selectedFields) ? $study_form->id == $selectedFields['study_form_id'] ? ' selected' : '' : '' }}>{{$study_form->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-heading">
                <a href="javascript:void(0)" class="btn btn-primary btn-raised" onclick="selectAction('Czy na pewno chcesz przypisać poniższe średnie do wskazanych studentów?', '{{ route('admin.appendAverages')}}')">Zapisz średnie</a>
                {{--<a href="javascript:void(0)" class="btn btn-primary btn-raised" onclick="selectAction('Potwierdzenie tej operacji wiąże się z usunięciem wszystkich aktualnie istniejących studentów i utworzenie nowej bazy studentów, którzy znaleźli się w pliku CSV. Czy na pewno chcesz wykonać tą operację?','{{ route('admin.overwriteStudents')}}')">Nadpisz wszystko</a>--}}

                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Numer indeksu</th>
                            <th class="text-center">średnia</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($averages as $index => $average)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>
                                    @if(isset($average['exist']))
                                        <input type="text" name="averages[{{$index}}][index]" class="form-control student-exist" value="{{$average['index']}}"/>
                                        <div class="alert alert-danger">
                                            <strong>{{$average['exist']['index']}}</strong>
                                            <input type="hidden" name="averages[{{$index}}][exist][index]" value="{{$average['exist']['index']}}"/>
                                        </div>
                                        <strong>Student już istnieje w bazie</strong>
                                    @else
                                        <input type="text" name="averages[{{$index}}][index]" class="form-control" value="{{$average['index']}}"/>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($average['exist']))
                                        <input type="text" name="averages[{{$index}}][average]" class="form-control student-exist" value="{{$average['average']}}"/>
                                        <div class="alert alert-danger">
                                            <strong>{{$average['exist']['average']}}</strong>
                                        </div>
                                        <input type="hidden" name="averages[{{$index}}][exist][average]" value="{{$average['exist']['average']}}"/>
                                    @else
                                        <input type="text" name="averages[{{$index}}][average]" class="form-control" value="{{$average['average']}}"/>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
<script>
    function selectAction(msg, url) {
        var form = document.getElementById('del');
        form.action = url;
        if(confirm(msg)){
            form.submit();
        }
    }
</script>
@endsection