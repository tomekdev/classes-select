@extends('layouts.admin')

@section('content')

 <div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>{{ $field ? 'Edytuj kierunek' : 'Dodaj Kierunek' }}</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ $field ? route('admin.savefield', ['id' => $field->id]) : route('admin.savefield') }}" method="post">
                        <div class="form-group label-floating">

							<div class="pull-center">
								<label for="field" class="control-label">Kierunek</label>
								<input type="text" class="form-control" id="field" name="name" value="{{ $field ? $field->name : '' }}" required>
							</div>
                        </div>
                        <div class="form-group label-floating">
                            <select class="form-control" name="faculty_id">
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ $field ? $field->faculty_id == $faculty->id ? 'selected' : '' : '' }}>{{ $faculty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{ csrf_field() }}
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-raised"> {{ $field ? 'Zapisz' : 'Dodaj' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
             

@endsection