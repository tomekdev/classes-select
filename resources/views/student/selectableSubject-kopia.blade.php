@extends('layouts.student')

@section('content')

<div class="container">
	<div class="row">
		 <div class="col-md-6 col-md-offset-3">
            <div class="card">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#faculty1" aria-controls="faculty1" role="tab" data-toggle="tab">Informatyka</a></li>
					 <li role="presentation"><a href="#faculty2" aria-controls="faculty2" role="tab" data-toggle="tab">Ekonomia</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active id="faculty1">
						<div class="panel-heading">
							<a href="javascript:void(0)" onclick="removeField(this)" class="pull-right">Usuń</a>
								<div class="form-group">
									<div class="card  panel">
											<div class="info panel-heading">Semestr VI zimowy (2017/2018)</div>
												<div class="form-group">
													<label for="selectsub" class="col-md-2 control-label">PW X</label>
														<div class="col-md-10">
															<select name="selectsub" class="form-control select">
																<option value="">-- wybierz --</option>
																	<option value="PWX">Technologia</option>
																	<option value="PWX">Nietechnologia</option>
															</select>
														</div>
												</div>

												<div class="form-group">
													<label for="selectsub" class="col-md-2 control-label">PW X</label>
														<div class="col-md-10">
															<select name="selectsub" class="form-control select">
																<option value="">-- wybierz --</option>
																	<option value="PWX">Technologia</option>
																	<option value="PWX">Nietechnologia</option>
															</select>
														</div>
												</div>
									</div>
								</div>

								<div class="form-group">
									<div class="card  panel">
										<div class="info panel-heading">Semestr VII letni (2018/2019)</div>
										<div class="form-group">
											<label for="selectsub" class="col-md-2 control-label">PW X</label>
												<div class="col-md-10">
													<select name="selectsub" class="form-control select">
														<option value="">-- wybierz --</option>
															<option value="PWX">Technologia</option>
															<option value="PWX">Nietechnologia</option>
													</select>
												</div>
										</div>
										<div class="form-group">
											<label for="selectsub" class="col-md-2 control-label">PW X</label>
												<div class="col-md-10">
													<select name="selectsub" class="form-control select">
														<option value="">-- wybierz --</option>
															<option value="PWX">Technologia</option>
															<option value="PWX">Nietechnologia</option>
													</select>
												</div>
										</div>
									</div>
								</div>
						</div>															
						<center>						
						  <button type="submit" class="btn btn-primary btn-raised"> Zapisz</button>          
						</center>
					</div>
					
			</div>				 
        </div>
    </div>
</div>

@endsection
