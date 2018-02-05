@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.contactus') }}</h2>
				</div>
			</div>
		</div>
	</section>
    <section class="testimonial main-block center-block">
        <div class="container">
            <div class="row">
				<div class="col-md-1"></div>
                <div class="col-md-10">
                   <p>{{ trans('words.contact_line1') }}</p>
				   <p>{{ trans('words.contact_line2') }}</p>
				   <p>{{ trans('words.contact_line3') }}</p>
				   <p>{{ trans('words.contact_line4') }}</p>
				   <p>{{ trans('words.contact_line5') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!--//END TESIMONIAL -->
    <!--============================= BOOKING =============================-->
    <section class="booking main-block center-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.contactform_line1') }}</h2>
                    <h6>{{ trans('words.contactform_line2') }}</h6>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
					{!! Form::open(array('url' => 'contact')) !!}
                    <div class="preference-radio mt-5">
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
							<div class="col-md-6">
								<div class="card-details">
									{{ Form::text('name', old('name'), array('class' => 'card-number', 'placeholder' => trans('words.your_name'), 'rows' => '3')) }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="card-details">
									{{ Form::text('email', old('email'), array('class' => 'card-number', 'placeholder' => trans('words.your_email'))) }}
								</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-md-12">
								<div class="card-details">
									{{ Form::textarea('message', old('message'), array('class' => 'card-number', 'placeholder' => trans('words.your_message'))) }}
								</div>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<button class="btn btn-block complete-booking" type="submit">{{ trans('words.submit') }}</button>
							</div>
						</div>
					</div>    
					{!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@include('layouts.footer')