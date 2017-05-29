@extends('layouts.admin') @section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <h3>Terminy zapisu</h3>
                    </div>
                    <div class="text-right col-md-9">
                        <a href="{{route('admin.getTerm')}}" class="btn btn-primary">Dodaj termin</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#filter">Filtruj <i class="fa fa-filter"></i></a>
                        </h4>
                        <div class="panel-body collapse {{$filtered? 'in': ''}}" id="filter">
                            <form class="form" method="post" action="{{route('admin.terms')}}">
                                <div class="form-group col-md-4">
                                    <label for="faculty">Wydział</label>
                                    <select id="faculty" name="faculty" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($faculties as $faculty)
                                            <option value="{{$faculty->id}}" {{old('faculty') == $faculty->id? 'selected' : ''}}>{{$faculty->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="field">Kierunek</label>
                                    <select id="field" name="field" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($fields as $field)
                                            <option value="{{$field->id}}" {{old('field') == $field->id? 'selected' : ''}}>{{$field->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="semester">Semestr</label>
                                    <select id="semester" name="semester" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($semesters as $semester)
                                            <option value="{{$semester->id}}" {{old('semester') == $semester->id? 'selected' : ''}}>{{$semester->number}}, {{$semester->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="active">Status</label>
                                    <select id="active" name="active" class="form-control select">
                                        <option value="1" {{old('active') === '1'? 'selected' : ''}}>Aktywny</option>
                                        <option value="0" {{old('active') === '0'? 'selected' : ''}}>Usunięty</option>
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
                <form id="del" method="post">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">
                                    <a href="{{{URL::route('admin.terms', array('sortProperty' => 'start_date', 'sortOrder' => $sortProperty === 'start_date'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Data rozpoczęcia
                                        @if ($sortProperty === 'start_date')
                                            <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                                <span class="caret"></span>
                                            </span>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">
                                    <a href="{{{URL::route('admin.terms', array('sortProperty' => 'finish_date', 'sortOrder' => $sortProperty === 'finish_date'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Data zakończenia
                                        @if ($sortProperty === 'finish_date')
                                            <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                                <span class="caret"></span>
                                            </span>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">
                                    <a href="{{{URL::route('admin.terms', array('sortProperty' => 'min_average', 'sortOrder' => $sortProperty === 'min_average'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Min. średnia
                                        @if ($sortProperty === 'min_average')
                                            <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                                <span class="caret"></span>
                                            </span>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">Wydział</th>
                                <th class="text-center">Kierunek</th>
                                <th class="text-center">Semestr</th>
                                <th class="text-center">Opcje</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($terms as $index => $term)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $term->start_date}}</td>
                                    <td class="text-center">{{ $term->finish_date}}</td>
                                    <td class="text-center">{{ $term->min_average}}</td>
                                    <td class="text-center">{{ $term->getField()->getFaculty()->name}}</td>
                                    <td class="text-center">{{ $term->getField()->name}}</td>
                                    <td class="text-center">{{ $term->getSemester()->number}}, {{ $term->getSemester()->name}}</td>
                                    <td>
                                        @if($term->active)
                                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz usunąć ten termin?', '{{ route('admin.deleteTerm', ['id' => $term->id]) }}')">Usuń</a>
                                        @else
                                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz przywrócić ten termin?', '{{ route('admin.restoreTerm', ['id' => $term->id]) }}')">Przywróć</a>
                                        @endif
                                        <a href="{{route('admin.getTerm', ['id' => $term->id])}}">Edytuj</a>
                                        <a href="{{ route('admin.sendTermReminders', ['id' => $term->id]) }}" onclick="return confirm('Czy na pewno chcesz wysłać powiadomienia mailowe do wszystkich studentów objętych terminem? {{$term->last_remind_date? '\n\nDla tego terminu wysłano już przypomnienia, ostatnie '.$term->last_remind_date.'.' : ''}} \n\nUWAGA: Proces wysyłania może trwać do kilku minut!')">Przypomnij</a>
                                    </td>
                                    <td class="text-right">
                                        <label for="checkboxes[{{$index}}][checkbox]"></label>
                                        <input name="checkboxes[{{$index}}][checkbox]" type="checkbox" />
                                        <label for="checkboxes[{{$index}}][id]"></label>
                                        <input type="hidden" name="checkboxes[{{$index}}][id]" value="{{ $term->id }}"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a href="javascript:void(0)" onclick="selectAll()">Zaznacz wszystko</a>
                        /
                        <a href="javascript:void(0)" onclick="deselectAll()">Usuń zaznaczenia</a>
                    </div>
                    <div class="text-right">
                        <a a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz wysłać powiadomienia mailowe do wszystkich studentów objętych terminami? \n\nUWAGA: Proces wysyłania może trwać do kilku minut!', '{{ route('admin.sendTermReminders', ['id' => 0]) }}')">Przypomnij</a>
                        @if($active)
                            <a a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz usunąć zaznaczone terminy?', '{{ route('admin.deleteTerm', ['id' => 0]) }}')">Usuń</a>
                        @else
                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz przywrócić te terminy?', '{{ route('admin.restoreTerm', ['id' => 0]) }}')">Przywróć</a>
                        @endif
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection