@extends('layouts.admin') @section('content')

    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <h3>Zaimportowani studenci</h3>
                    </div>
                    {{--<div class="text-right col-md-9">--}}
                        {{--<form action="{{ route('admin.importStudents') }}" method="post">--}}
                            {{--<a href="{{route('admin.getstudent')}}" class="btn btn-primary">Dodaj do już intniejących studentów</a>--}}
                            {{--{{ csrf_field() }}--}}
                        {{--</form>--}}
                        {{--<form action="{{ route('admin.importStudents') }}" method="post">--}}
                            {{--<a href="{{route('admin.getstudent')}}" class="btn btn-primary">Nadpisz Wszystko</a>--}}
                            {{--{{ csrf_field() }}--}}
                        {{--</form>--}}
                    {{--</div>--}}
                </div>
                <form id="del" method="post">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAction('Czy na pewno chcesz dodać tych studentów do już istniejących?', '{{ route('admin.appendStudents')}}')">Dodaj do istniejących</a>
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAction('Potwierdzenie tej operacji wiąże się z usunięciem wszystkich aktualnie istniejących studentów i utworzenie nowej bazy studentów, którzy znaleźli się w pliku CSV. Czy na pewno chcesz wykonać tą operację?','{{ route('admin.overwriteStudents')}}')">Nadpisz wszystko</a>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Numer indeksu</th>
                                <th class="text-center">Imię</th>
                                <th class="text-center">Nazwisko</th>
                                <th class="text-center">email</th>
                                <th class="text-center">hasło</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $index => $student)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <input type="text" name="students[{{$index}}][index]" class="form-control" value="{{$student['index']}}"/>
                                    </td>
                                    <td>
                                        <input type="text" name="students[{{$index}}][name]" class="form-control" value="{{$student['name']}}"/>
                                    </td>
                                    <td>
                                        <input type="text" name="students[{{$index}}][surname]" class="form-control" value="{{$student['surname']}}"/>
                                    </td>
                                    <td>
                                        <input type="text" name="students[{{$index}}][email]" class="form-control" value="{{$student['email']}}"/>
                                    </td>
                                    <td>
                                        <input type="text" name="students[{{$index}}][password]" class="form-control" value="{{$student['password']}}"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
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