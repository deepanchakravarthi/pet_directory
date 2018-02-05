@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.login') }}</h2>
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
												{!! Form::open(array('url' => 'login', 'class' => 'row')) !!}
													<div class="col-md-3 col-sm-12">
													</div>
													<div class="col-md-6 col-sm-12">
														<div class="commentform">
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
																<div class="col-md-6 col-sm-12">
																	<label>{{ trans('words.email') }} <span class="required">*</span></label>
																	{{ Form::text('email', old('email'), array('class' => 'form-control', 'placeholder' => 'abc@email.com')) }}
																</div>
																<div class="col-md-6 col-sm-12">
																	<label>{{ trans('words.password') }} <span class="required">*</span></label>
																	{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
																</div>
															</div>
															<div class="row">
																<div class="col-md-12 col-sm-12 left-alignment mt-3">
																	<div class="terms-reminder">
																		<label class="custom-control custom-checkbox">
																			<input type="checkbox" name="persist" id="persist" value="1" class="custom-control-input">
																			<span class="custom-control-indicator"></span>
																			<span class="custom-control-description">{{ trans('words.remember_me') }}</span>
																		</label>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-6 col-sm-12 center-alignment mt-3">
																	<input type="submit" value="{{ trans('words.login') }}" class="btn btn-outline-primary btn-fullwidth width-100" />
																</div>
																<div class="col-md-6 col-sm-12 center-alignment mt-3">
																	<input onclick='location.href="forgot-password"'; type="button" value="{{ trans('words.forgot_password') }}" class="btn btn-outline-secondary btn-fullwidth width-100" />
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