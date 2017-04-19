@extends('layouts.admin') @section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <h3>Przedmioty wybieralne</h3>
                    </div>
                    <div class="text-right col-md-9">
                        {{--<a href="{{route('admin.getSubject')}}" class="btn btn-primary">Dodaj przemiot wybieralny</a>--}}
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#filter">Filtruj <i class="fa fa-filter"></i></a>
                        </h4>
                        <div class="panel-body collapse {{$filtered? 'in': ''}}" id="filter">
                            <form class="form" method="post" action="{{route('admin.subjects')}}">
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
                                    <a href="{{{URL::route('admin.subjects', array('sortProperty' => 'name', 'sortOrder' => $sortProperty === 'name'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Nazwa
                                        @if ($sortProperty === 'name')
                                            <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">
                                    <a href="{{{URL::route('admin.subjects', array('sortProperty' => 'max_person', 'sortOrder' => $sortProperty === 'max_person'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Max osób
                                        @if ($sortProperty === 'max_person')
                                            <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">
                                    <a href="{{{URL::route('admin.subjects', array('sortProperty' => 'min_person', 'sortOrder' => $sortProperty === 'min_person'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Min osób
                                        @if ($sortProperty === 'min_person')
                                            <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">Opcje</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $index => $subject)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $subject->name }}</td>
                                    <td class="text-center">{{ $subject->max_person }}</td>
                                    <td class="text-center">{{ $subject->min_person }}</td>
                                    {{--<td>--}}
                                        {{--<a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz ten przedmiot wybieralny?', '{{ route('admin.deleteSubject', ['id' => $subject->id]) }}')">Usuń</a>--}}
                                        {{--<a href="{{route('admin.getfield', ['id' => $field->id])}}">Edytuj</a>--}}
                                    {{--</td>--}}
                                    <td class="text-right">
                                        <label for="checkboxes[{{$index}}][checkbox]"></label>
                                        <input name="checkboxes[{{$index}}][checkbox]" type="checkbox" />
                                        <label for="checkboxes[{{$index}}][id]"></label>
                                        <input type="hidden" name="checkboxes[{{$index}}][id]" value="{{ $subject->id }}"/>
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
                        {{--<a a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz usunąć zaznaczone przedmioty wybieralne?', '{{ route('admin.deleteSubject', ['id' => 0]) }}')">Usuń</a>--}}
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection
