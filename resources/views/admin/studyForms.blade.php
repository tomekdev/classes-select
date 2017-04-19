@extends('layouts.admin') @section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <h3>Formy studiów</h3>
                </div>
                <div class="text-right col-md-9">
                    <a href="{{route('admin.getStudyForm')}}" class="btn btn-primary">Dodaj formę studiów</a>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" href="#filter">Filtruj <i class="fa fa-filter"></i></a>
                </h4>
                    <div class="panel-body collapse {{$filtered? 'in': ''}}" id="filter">
                        <form class="form" method="post" action="{{route('admin.studyForms')}}">
                            <div class="form-group col-md-4">
                                <label for="active">Status</label>
                                <select id="active" name="active" class="form-control select">
                                    <option value="1" {{old( 'active')==='1' ? 'selected' : ''}}>Aktywny</option>
                                    <option value="0" {{old( 'active')==='0' ? 'selected' : ''}}>Usunięty</option>
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
                                    <a href="{{{URL::route('admin.studyForms', array('sortProperty' => 'name', 'sortOrder' => $sortProperty === 'name'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Nazwa
                                @if ($sortProperty === 'name')
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
                            @foreach ($study_forms as $index => $study_form)
                            <tr>
                                <td class="text-center">{{$index+1}}</td>
                                <td class="text-center">{{$study_form->name}}</td>
                                <td>
                                    <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz tą formę studiów?', '{{ route('admin.deleteStudyForm', ['id' => $study_form->id]) }}')">Usuń</a>
                                    <a href="{{route('admin.getStudyForm', ['id' => $study_form->id])}}">Edytuj</a>
                                </td>
                                <td class="text-right">
                                    <label for="checkboxes[{{$index}}][checkbox]"></label>
                                    <input name="checkboxes[{{$index}}][checkbox]" type="checkbox" />
                                    <label for="checkboxes[{{$index}}][id]"></label>
                                    <input type="hidden" name="checkboxes[{{$index}}][id]" value="{{ $study_form->id }}" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="javascript:void(0)" onclick="selectAll()">Zaznacz wszystko</a> /
                    <a href="javascript:void(0)" onclick="deselectAll()">Usuń zaznaczenia</a>
                </div>
                <div class="text-right">
                    <a a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz usunąć zaznaczone formy studiów?', '{{ route('admin.deleteStudyForm', ['id' => 0]) }}')">Usuń</a>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection
