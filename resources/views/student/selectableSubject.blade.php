@extends('layouts.student') @section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3>Przedmioty wybieralne</h3>
					</div>
					<div class="panel-body">
						<div id="subjects">
							<input type="hidden" id="student_id" name="student_id" value="{{ $student_id }}"/>
							@foreach ($subjects? $subjects : [] as $key => $subject)
								<div class="panel">
									<div class="panel-heading">
										<div class="form-group">
											<div class="row">
												<label for="subjects[{{$key}}][subject_id]" class="col-md-2 control-label">Nazwa przedmiotu</label>
												<div class="col-md-10">
													<input type="text" class="form-control select" disabled
													value="{{ $subject['subject']['name'] }}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<label for="subjects[{{$key}}][field_faculty]" class="col-md-2 control-label">Wydział, kierunek, semestr</label>
												<div class="col-md-10">
													<input type="text" class="form-control select" disabled value="{{ $subject['subject']['faculty'] }}, {{ $subject['subject']['field'] }}, {{ $subject['subject']['semester'] }}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<label for="subjects[{{$key}}][subSubject_id]" class="col-md-2 control-label">Nazwa zajęć</label>
												<div class="col-md-10">
														@if($subject['subject']['selectable'])
														<select id="{{'select'.$key}}" name="subjects[{{$key}}][subSubject_id]" class="form-control select">
															<option value="">-- wybierz --</option>
															@if($subject['subject']['selected'])
																@foreach ($subject['subSubjects'] as $subSubject)
																	<option value="{{$subSubject['id']}}" {{ $subSubject['active'] ? $subject['subSubject']['id'] == $subSubject['id'] ? ' selected' : '' : ' disabled' }}>{{$subSubject['name']}}</option>
																@endforeach
															@else
																@foreach ($subject['subSubjects'] as $subSubject)
																	<option value="{{$subSubject['id']}}" {{ $subSubject['active'] ? ' ' : ' disabled' }}>{{$subSubject['name']}}</option>
																@endforeach
															@endif
														</select>
													@else
														<input type="text" value="{{$subject['subject']['selected'] ? $subject['subSubject']['name'] : 'Nie dokonano wyboru' }}" class="form-control select" disabled/>
													@endif
												</div>
											</div>
											<div class="row">
												@if($subject['subject']['selectable'])
													<button id="{{$key}}" type="button" class="btn btn-primary pull-right" onclick="ajaxSaveSubject(this.id, '{{ $subject['subject']['selectable'] }}', '{{ $subject['subject']['selected'] }}', '{{ $subject['subject']['id'] }}')">Zapisz</button>
												@else
													<button type="button" class="btn pull-right" disabled>Zapisano</button>
												@endif
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
