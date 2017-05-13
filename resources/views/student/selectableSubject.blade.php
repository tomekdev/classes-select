@extends('layouts.student') @section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3>Przedmioty wybieralne</h3>
					</div>
					<div class="panel-body">
						<form action="{{ $subjects ? route('student.saveSubjects') : route('student.dashboard') }}" method="post">
							<div id="subjects">
								@foreach ($subjects? $subjects : [] as $key => $subject)
									<div class="panel-heading">
										<div class="form-group">
											<label for="subjects[{{$key}}][subject_id]" class="col-md-2 control-label">Wydział</label>
											<div class="col-md-10">
												<input type="text" class="form-control select" disabled
												value="{{ $subject['subject']->name }}, {{ $subject['subject']->getField()->name }}, {{$subject['subject']->getSemester()->number . '-' .$subject['subject']->getSemester()->name}}">
												<input type="hidden" value="{{ $subject['subject']->id }}" name="subjects[{{$key}}][subject_id]"/>
											</div>
										</div>
										<div class="form-group">
											<label for="subjects[{{$key}}][subSubject_id]" class="col-md-2 control-label">Nazwa zajęć</label>
											<div class="col-md-10">
												<select id="{{$key}}" name="subjects[{{$key}}][subSubject_id]" class="form-control select" onchange="">
													<option value="">-- wybierz --</option>
													@foreach ($subject['subSubjects'] as $subSubject)
														<option value="{{$subSubject->id}}">{{$subSubject->name}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								@endforeach
							{{ csrf_field() }}
						</div>
							<button type="submit" class="btn btn-primary btn-raised pull-right">Zapisz</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
