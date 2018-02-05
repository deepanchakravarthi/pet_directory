@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.create_pet') }}</h2>
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
                                                {!! Form::open(array('url' => 'create-pet', 'class' => 'row', 'enctype' => 'multipart/form-data')) !!}
													<div class="col-md-3 col-sm-12">
													</div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="commentform">
															<p>{{ trans('words.create_pet_text') }}</p>
															<div class="row">
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
															</div>
															<div class="row">
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.name') }} <span class="required">*</span></label>
																		{{ Form::text('name', old('name'), array('class' => 'form-control', 'placeholder' => trans('words.pet_name'))) }}
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.species') }} <span class="required">*</span></label>
																		{{ Form::select('species', $speciesArray, old('species'), array('class' => 'form-control', 'placeholder' => trans('words.select'))) }}
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.color') }} <span class="required">*</span></label>
																		{{ Form::text('color', old('color'), array('class' => 'form-control', 'placeholder' => '')) }}
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.strain') }} <span class="required"></span></label>
																		{{ Form::text('strain', old('strain'), array('class' => 'form-control', 'placeholder' => '')) }}
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.gender') }} <span class="required">*</span></label>
																		{{ Form::select('gender', $genderArray, old('gender'), array('class' => 'form-control')) }}
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.geld') }} <span class="required">*</span></label>
																		{{ Form::select('geld', $geldArray, old('geld'), array('class' => 'form-control')) }}
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.country_of_birth') }} <span class="required">*</span></label>
																		{{ Form::select('country_of_birth', $pet_countries, old('country_of_birth'), array('class' => 'form-control')) }}
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.date_of_birth') }} <span class="required"></span></label>
																		{{ Form::text('date_of_birth', old('date_of_birth'), array('id' => 'date_of_birth', 'class' => 'form-control', 'placeholder' => 'dd/mm/yyyy')) }}
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.chip_id') }} <span class="required"></span></label>
																		{{ Form::text('chip_id', old('chip_id'), array('class' => 'form-control', 'placeholder' => '')) }}
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.pass_id') }} <span class="required"></span></label>
																		{{ Form::text('pass_id', old('pass_id'), array('id' => 'pass_id', 'class' => 'form-control', 'placeholder' => '')) }}
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.tattoo_id') }} <span class="required"></span></label>
																		{{ Form::text('tattoo_id', old('tattoo_id'), array('class' => 'form-control', 'placeholder' => '')) }}
																	</div>
																</div>
																<div class="col-md-6 col-sm-12">
																	<div class="card-details">
																		<label>{{ trans('words.tattoo_location') }} <span class="required"></span></label>
																		{{ Form::text('tattoo_location', old('tattoo_location'), array('class' => 'form-control', 'placeholder' => '')) }}
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-12 col-sm-12">
																	<label>{{ trans('words.pet_id') }} <span class="required">*</span></label>
																		{{ Form::text('pet_id', old('pet_id'), array('class' => 'form-control', 'placeholder' => '')) }}
																</div>
															</div>
															<div class="row">
																<div class="col-md-12 col-sm-12 mt-2">
																	<div class="card-details">
																		<label>{{ trans('words.characteristics') }} <span class="required"></span></label>
																		{{ Form::textarea('characteristics', old('characteristics'), array("rows" => "5", 'class' => 'form-control', 'placeholder' => trans('words.enter_characteristics'))) }}
																	</div>
																</div>
															</div>
															@if(Auth::user()->user_type == 1 || Auth::user()->user_type == 4)
															<div class="row">
																<div class="col-md-12 col-sm-12 mt-2">
																	<div class="card-details">
																		<label>{{ trans('words.permission') }} <span class="required"></span></label>
																		{{ Form::select('permission', $petPermissionArray, old('permission'), array('class' => 'form-control')) }}
																	</div>
																</div>
															</div>
															@endif
															<div class="row ">
																<div class="col-md-6 col-sm-12 center-alignment mt-3">
																	<input type="submit" value="{{ trans('words.submit') }}" class="btn btn-outline-primary btn-fullwidth width-100" />
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