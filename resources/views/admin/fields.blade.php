@extends('layouts.admin') @section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <h3>Kierunki</h3>
                </div>
                <div class="text-right col-md-9">
                    <button class="btn btn-primary">Dodaj kierunek</button>
					<button class="btn btn-primary">Edytuj kierunek</button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Kierunek</th>
                        <th class="text-center">Wydział</th>
                        <th class="text-right">Zaznacz</th>
                    </tr>
                </thead>
            <tbody>
               
                    <tr>
						<td class="text-center">1</td>
						<td class="text-center">Informatyka</t>
						<td class="text-center">Elektrotechniki, Automatyki i Informatyki</td>
						
                        <td class="text-right">
                            <input type="checkbox" />
                        </td>
                    </tr>
             
                </tbody>
            </table>
        </div>
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
