@extends('layouts.student') @section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Studenci</h3>
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Nr indeksu</th>
                        <th class="text-center">Nazwisko i imię</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Średnia</th>
                        <th class="text-center">Rok ukończenia</th>
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
                        <td>{{{$student->study_end}}}</td>
                        <td>
                            <a href="/">Usuń</a>
                            <a href="/">Edytuj</a>
                        </td>
                        <td class="text-right">
                            <input type="checkbox" />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
