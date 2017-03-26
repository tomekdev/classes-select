@extends('layouts.admin') @section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <h3>Studenci</h3>
                </div>
                <div class="text-right col-md-9">
                    <button class="btn btn-primary">Dodaj studenta</button>
                    <button class="btn btn-primary">Importuj studentów</button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" href="#filter">Filtruj <i class="fa fa-filter"></i></a>
                </h4>
                <div class="panel-body collapse {{$filtered? 'in': ''}}" id="filter">
                    <form class="form" method="post" action="{{route('admin.students')}}">
                        <div class="form-group col-md-4">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control select">
                                <option value="">-- wybierz --</option>
                                <option value="active">Aktywny</option>
                                <option value="removed">Usunięty</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="faculty">Wydział</label>
                            <select id="faculty" name="faculty" class="form-control select">
                                <option value="">-- wybierz --</option>
                                <option value="weaii">WEAiI</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="field">Kierunek</label>
                            <select id="field" name="field" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach ($fields as $field)
                                    <option value="{{$field->id}}">{{$field->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="study_end">Rok ukończenia</label>
                            <select id="study_end" name="study_end" class="form-control select">
                                <option value="">-- wybierz --</option>
                                @foreach ($years as $name)
                                    <option value="{{$name->study_end}}" {{old('study_end') == $name->study_end? 'selected' : ''}}>{{$name->study_end}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="classes_status">Status zapisu</label>
                            <select id="classes_status" name="classes_status" class="form-control select">
                                <option value="">-- wybierz --</option>
                                <option value="ready">Zapisany</option>
                                <option value="pending">Niezapisany</option>
                            </select>
                        </div>
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <button type="submit" class="pull-right btn btn-primary">Filtruj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">
                        <a href="{{{URL::route('admin.students', array('sortProperty' => 'index', 'sortOrder' => $sortProperty === 'index'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Nr indeksu
                            @if ($sortProperty === 'index')
                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                    <span class="caret"></span>
                                </span>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">
                        <a href="{{{URL::route('admin.students', array('sortProperty' => 'surname', 'sortOrder' => $sortProperty === 'surname'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Nazwisko i imię
                            @if ($sortProperty === 'surname')
                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                    <span class="caret"></span>
                                </span>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">
                        <a href="{{{URL::route('admin.students', array('sortProperty' => 'email', 'sortOrder' => $sortProperty === 'email'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Email
                            @if ($sortProperty === 'email')
                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                    <span class="caret"></span>
                                </span>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">
                        <a href="{{{URL::route('admin.students', array('sortProperty' => 'average', 'sortOrder' => $sortProperty === 'average'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Średnia
                            @if ($sortProperty === 'average')
                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                    <span class="caret"></span>
                                </span>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">Kierunki</th>
                    <th class="text-center">Opcje</th>
                    <th class="text-right">Zaznacz</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $student)
                <tr>
                    <td>{{{$index+1}}}</td>
                    <td>{{{$student->index}}}</td>
                    <td>{{{$student->surname}}} {{{$student->name}}}</td>
                    <td>{{{$student->email}}}</td>
                    <td>{{{$student->average}}}</td>
                    <td>
                        @foreach ($student->getStudies() as $study)
                        <p>{{{$study['field']->name}}}, {{{$study['semester']->number}}} semestr</p>
                        @endforeach
                    </td>
                    <td>
                        <a href="/">Usuń</a>
                        <a href="/">Edytuj</a>
                        <a href="/">Pokaż zapisy</a>
                    </td>
                    <td class="text-right">
                        <input type="checkbox" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <a href="javascript:void(0)" onclick="selectAll()">Zaznacz wszystko</a>
            /
            <a href="javascript:void(0)" onclick="deselectAll()">Usuń zaznaczenia</a>
        </div>
        <div class="text-right">
            <a href="/">Usuń</a>
        </div>
    </div>
</div>

@endsection
