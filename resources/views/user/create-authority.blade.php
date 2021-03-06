@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.create_user') }}</h2>
				</div>
			</div>
		</div>
	</section>
	<section class="testimonial main-block center-block">
		<div class="container sitecontainer bgw">
            <div class="row">
                <div class="col-md-12 m22 single-post">
                    <div class="widget">
                        <div class="large-widget m30">
                            <div class="post-desc">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="appoform-wrapper">
												{!! Form::open(array('url' => 'create-authority', 'class' => 'row')) !!}
													<div class="col-md-3 col-sm-12">
													</div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="commentform">
														@if(count($errors->all()) > 0)
															<div class="col-md-12 col-sm-12">
															@foreach( $errors->all() as $message )
																<div class="alert alert-danger" role="alert">
																	{{ $message }}
																</div>
															@endforeach
															</div>
														@endif
														@if(Session::has('message'))
															<div class="col-md-12 col-sm-12">
																<div class="alert alert-success" role="alert">
																	{{ Session::get('message') }}
																</div>
															</div>
														@endif
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.user_type') }} <span class="required">*</span></label>
																	{{ Form::hidden('user_type', 3) }}
																	{{ Form::text('user_type_text', trans('words.authority'), array('class' => 'form-control', 'readonly' => 'readonly')) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.salutation') }} <span class="required">*</span></label>
																	{{ Form::select('salutation', $salutationArray, old('salutation'), array('class' => 'form-control', 'placeholder' => trans('words.select_salutation'))) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.firstname') }} <span class="required">*</span></label>
																	{{ Form::text('firstname', old('firstname'), array('class' => 'form-control', 'placeholder' => trans('words.firstname'))) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.lastname') }} <span class="required">*</span></label>
																	{{ Form::text('lastname', old('lastname'), array('class' => 'form-control', 'placeholder' => trans('words.lastname'))) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.email') }} <span class="required">*</span></label>
																	{{ Form::text('email', old('email'), array('class' => 'form-control', 'placeholder' => 'example@test.com')) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.phone') }} <span class="required">*</span></label>
																	{{ Form::text('phone', old('phone'), array('class' => 'form-control', 'placeholder' => '1234567890')) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.password') }} <span class="required">*</span></label>
																	{{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('words.password'), 'id' => 'create_user_password')) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.cpassword') }} <span class="required">*</span></label>
																	{{ Form::password('confirm_password', array('class' => 'form-control', 'placeholder' => trans('words.cpassword'), 'id' => 'create_user_cpassword')) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-12 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.address') }} <span class="required">*</span></label>
																	{{ Form::text('address', old('address'), array('class' => 'form-control', 'placeholder' => trans('words.address'))) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.zip') }} <span class="required">*</span></label>
																	{{ Form::text('zip', old('zip'), array('class' => 'form-control', 'placeholder' => '12345')) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.city') }} <span class="required">*</span></label>
																	{{ Form::text('city', old('city'), array('class' => 'form-control', 'placeholder' => trans('words.city'))) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.state') }} <span class="required">*</span></label>
																	{{ Form::text('state', old('state'), array('class' => 'form-control', 'placeholder' => trans('words.state'))) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.country') }} <span class="required">*</span></label>
																	{{ Form::select('country', $countries, old('country'), array('class' => 'form-control', 'placeholder' => trans('words.select_country'))) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.language') }} <span class="required">*</span></label>
																	{{ Form::select('language', $languages, old('language'), array('class' => 'form-control', 'placeholder' => 'Select Language')) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.authority_name') }} <span class="required">*</span></label>
																	{{ Form::text('authority_name', old('authority_name'), array('class' => 'form-control', 'placeholder' => trans('words.authority_name'))) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.supervisor_name') }} <span class="required">*</span></label>
																	{{ Form::text('supervisor_name', old('supervisor_name'), array('class' => 'form-control', 'placeholder' => trans('words.supervisor_name'))) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.supervisor_email') }} <span class="required">*</span></label>
																	{{ Form::text('supervisor_email', old('supervisor_email'), array('class' => 'form-control', 'placeholder' => trans('words.supervisor_email'))) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.supervisor_phone') }} <span class="required">*</span></label>
																	{{ Form::text('supervisor_phone', old('supervisor_phone'), array('class' => 'form-control', 'placeholder' => trans('words.supervisor_phone'))) }}
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label>{{ trans('words.status') }} <span class="required">*</span></label>
																	{{ Form::select('status', array(trans('words.active'), trans('words.inactive')), old('status'), array('class' => 'form-control')) }}
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12 center-alignment mt-3">
																<input type="submit" value="{{ trans('words.create_user') }}" class="btn btn-outline-primary btn-fullwidth width-100" />
															</div>
															<div class="col-md-6 col-sm-12 center-alignment mt-3">
																<input type="button" onclick="window.history.go(-1); return false;" value="{{ trans('words.reset') }}" class="btn btn-outline-secondary btn-fullwidth width-100" />
															</div>
														</div>
													</div>
													</div>
													<div class="col-md-3 col-sm-12"></div>
                                                {!! Form::close() !!}
                                            
                                            <!-- end newsletter -->
                                        </div>
                                        <!-- end form-container -->
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                            </div>
                            <!-- end post-desc -->
                        </div>
                        <!-- end large-widget -->
                    </div>
                    <!-- end widget -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
	</section>
@include('layouts.footer')