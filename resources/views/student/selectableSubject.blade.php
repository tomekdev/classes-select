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
								<div class="panel-heading">
									<div class="form-group">
										<label for="subjects[{{$key}}][subject_id]" class="col-md-2 control-label">Nazwa przedmiotu</label>
										<div class="col-md-10">
											<input type="text" class="form-control select" disabled
											value="{{ $subject['subject']->name }}, {{ $subject['subject']->getField()->name }}, {{$subject['subject']->getSemester()->number . '-' .$subject['subject']->getSemester()->name}}">
											<input type="hidden" value="{{ $subject['subject']->id }}" name="subjects[{{$key}}][subject_id]"/>
										</div>
									</div>
									<div class="form-group">
										<label for="subjects[{{$key}}][subSubject_id]" class="col-md-2 control-label">Nazwa zajęć</label>
										<div class="col-md-10">
											@if(!$subject['selected'])
											<select id="{{'select'. $key}}" name="subjects[{{$key}}][subSubject_id]" class="form-control select">
												<option value="">-- wybierz --</option>
												@foreach ($subject['subSubjects'] as $subSubject)
													<option value="{{$subSubject->id}}">{{$subSubject->name}}</option>
												@endforeach
											</select>
											@else
												<input type="text" value="{{$subject['selected']}}" class="form-control select" disabled/>
											@endif
										</div>
									</div>
									<div class="col-lg-12">
										@if(!$subject['selected'])
											<button id={{$key}} type="button" class="btn btn-primary btn-raised pull-right" onclick="ajaxSaveSubject(this.id)">Zapisz</button>
										@else
											<button type="button" class="btn pull-right" disabled>Zapisano</button>
										@endif
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
