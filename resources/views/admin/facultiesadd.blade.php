@extends('layouts.admin')

@section('content')

 <div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Nowy wydział</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="form-group label-floating">
                            <label for="faculty" class="control-label">Wydział</label>
                            <input type="text" class="form-control" id="faculty" name="faculty">
                        </div>                  
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised">Dodaj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
             

@endsection