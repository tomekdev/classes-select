@extends('layouts.admin')

@section('content')

 <div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Nowy kierunek</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="form-group label-floating">
							<div class="pull-right">
								<select class="form-control">
									<option value="one">WEAII</option>
									<option value="two">WM</option>
								</select>
							</div>	
							
							<div class="pull-center">
								<label for="field" class="control-label">Kierunek</label>
								<input type="text" class="form-control" id="field" name="field" required>
							</div>	
							
                        </div> 
						
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised"> Dodaj nastepny kierunek</button>
                        </div>
						<button type="submit" class="btn btn-primary btn-raised"> Dodaj wszystkie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
             

@endsection