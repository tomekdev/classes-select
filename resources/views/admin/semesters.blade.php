@extends('layouts.admin') @section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <h3>Semestr</h3>
                    </div>
                    <div class="text-right col-md-9">
                        <a href="{{route('admin.getSemester')}}" class="btn btn-primary">Dodaj Semestr</a>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#filter">Filtruj <i class="fa fa-filter"></i></a>
                    </h4>
                    <div class="panel-body collapse {{$filtered? 'in': ''}}" id="filter">
                        <form class="form" method="post" action="{{route('admin.semesters')}}">
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
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">
                            <a href="{{{URL::route('admin.semesters', array('sortProperty' => 'name', 'sortOrder' => $sortProperty === 'name'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Nazwa
                                @if ($sortProperty === 'name')
                                    <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                        <span class="caret"></span>
                                    </span>
                                @endif
                            </a>
                        </th>
                        <th class="text-center">
                            <a href="{{{URL::route('admin.semesters', array('sortProperty' => 'number', 'sortOrder' => $sortProperty === 'number'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Numer
                                @if ($sortProperty === 'number')
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
                    @foreach ($semesters as $index => $semester)
                        <tr>
                            <td class="text-center">{{$index+1}}</td>
                            <td class="text-center">{{{$semester->name}}}</td>
                            <td class="text-center"> {{$semester->number}}</td>
                            <td>
                                @if ($semester->active)
                                    <form action="{{ URL::route('admin.deleteSemester', $semester->id) }}" method="POST" style="display:inline-block">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{ csrf_field() }}
                                        <a href="javascript:void(0)" onclick="confirm('Czy chcesz usunąć {{{$semester->name}}}?')? $(this).closest('form').submit() : null;">Usuń</a>
                                    </form>
                                @endif
                                <a href="{{route('admin.getSemester', ['id' => $semester->id])}}">Edytuj</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection