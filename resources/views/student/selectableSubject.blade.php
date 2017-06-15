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
                            @if(count($subjects) === 0)
                            <h4>W tej chwili nie możesz zapisać się na przedmioty.</h4>
                            <h4>Zapraszamy w późniejszym terminie</h4>
                            @endif
							@foreach ($subjects? $subjects : [] as $key => $subject)
								<div class="panel">
									<div class="panel-heading">
										<div class="form-group">
											<div class="row">
												<label for="subjects[{{$key}}][subject_id]" class="col-md-2 control-label">Nazwa przedmiotu</label>
												<div class="col-md-10">
													<input type="text" class="form-control select" disabled
													value="{{ $subject['name'] }}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<label for="subjects[{{$key}}][field_faculty]" class="col-md-2 control-label">Wydział, kierunek, semestr</label>
												<div class="col-md-10">
													<input type="text" class="form-control select" disabled value="{{ $subject['faculty'] }}, {{ $subject['field'] }}, {{ $subject['semester'] }}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<label for="subjects[{{$key}}][subSubject_id]" class="col-md-2 control-label">Nazwa zajęć</label>
												<div class="col-md-10">
														@if($subject['selectable'])
														<select id="{{'select'.$key}}" name="subjects[{{$key}}][subSubject_id]" class="form-control select">
															<option value="0">-- wybierz --</option>
															@if($subject['selected'])
																@foreach ($subject['subSubjects'] as $subSubject)
																	<option value="{{$subSubject['id']}}" {{ $subSubject['active'] ? $subject['subSubject']['id'] == $subSubject['id'] ? ' selected' : '' : ' disabled' }}>{{$subSubject['name']}}{{' ('.$subSubject['selectedCount'].'/'.$subSubject['max_person'].')'}}{{ $subSubject['active'] ? $subject['subSubject']['id'] == $subSubject['id'] ? ' - aktualnie wybrany' : '' : ''}}</option>
																@endforeach
															@else
																@foreach ($subject['subSubjects'] as $subSubject)
																	<option value="{{$subSubject['id']}}" {{ $subSubject['active'] ? ' ' : ' disabled' }}>{{$subSubject['name']}}{{' ('.$subSubject['selectedCount'].'/'.$subSubject['max_person'].')'}}</option>
																@endforeach
															@endif
														</select>
													@else
														<input type="text" value="{{$subject['selected'] ? $subject['subSubject']['name'] : 'Nie dokonano wyboru' }}" class="form-control select" disabled/>
													@endif
												</div>
											</div>
											<div class="row">
                                                @if($subject['active'])
                                                    @if($subject['selectable'])
                                                        <button id="{{$key}}" type="button" class="btn btn-primary pull-right btn-raised" onclick="ajaxSaveSubject(this.id, '{{ $subject['selectable'] }}', '{{ $subject['selected'] }}', '{{ $subject['id'] }}')" style="margin-right:1rem">Zapisz</button>
                                                    @else
                                                        <button type="button" class="btn pull-right" disabled>Zapisano</button>
                                                    @endif
                                                @endif
											</div>
										</div>
									</div>
                                    @if($subject['selectable'])
                                    <div class="panel panel-primary">
									   <div class="panel-heading">
                                           @if(!$subject['active'])
                                             Zapisy na ten przedmiot będą możliwe dnia <strong>{{$subject['start_date']}}</strong> o godzinie <strong>{{$subject['start_time']}}</strong>.
                                            <br />
                                           @endif
                                           Termin zapisu na ten przedmiot upływa dnia <strong>{{$subject['finish_date']}}</strong> o godzinie <strong>{{$subject['finish_time']}}</strong>.
                                           @if (isset($subject['alternatives']))
                                           @foreach($subject['alternatives'] as $alternative)
                                                <br />
                                                Kolejny termin: <strong>{{$alternative['start_date']}} {{$alternative['start_time']}}</strong> - <strong>{{$alternative['finish_date']}} {{$alternative['finish_time']}}</strong>.
                                           @endforeach
                                           @endif
                                        </div>
                                    </div>
                                    @endif
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
