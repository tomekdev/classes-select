@extends('layouts.admin') @section('content')

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <h3>Importowanie z CSV</h3>
					<button class="btn btn-primary btn-raised">Plik CSV</button>
					<div class="text-right">
						<div class="col-md-12 " >													
							<button class="btn btn-primary" id="overnew">Nadpisz wszystko i dodaj nowe</button>
							<button class="btn btn-primary" id="onlynew">Dodaj tylko nowe</button>
							<button class="btn btn-primary" id="overexist">Nadpisz tylko istniejące</button>
							<button class="btn btn-primary" id="reset">De/Aktywacja studenta</button>
						</div>
					</div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Imie</th>
                        <th class="text-center">Nazwisko</th>
						<th class="text-center">Nr indeksu</th>
						<th class="text-center">Email</th>
						<th class="text-center">Wydział</th>
						<th class="text-center">Kierunek</th>
						
                        <th class="text-right">Zaznacz</th>
                    </tr>
                </thead>
            <tbody>
				<tr>
						<th class="text-center">1</th>
                        <th class="text-center">Mateusz</th>
                        <th class="text-center">Torbus</th>
						<th class="text-center">89545</th>
						<th class="text-center">email@gmail.com</th>
						<th class="text-center">EAiI</th>
						<th class="text-center">Chyba informatyka</th>
						
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
		<div class="col-md-12">
		</br>
				<div class="text-left">
								Dodano: </br>     
								Nadpisano: </br>
				</div>	
		</div>
    </div>
</div>

@endsection
