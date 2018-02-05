@include('layouts.header')
<div class="container sitecontainer bgw">
            <div class="row">
                <div class="col-md-12 m22 single-post">
                    <div class="widget">
                        <div class="large-widget m30">
                            <div class="post-desc">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="appoform-wrapper">
                                            <header class="form-header">
                                                <h3>Contact Form</h3>
                                            </header>

                                                <div class="commentform">
													<div class="row">
														@if(count($errors->all()) > 0)
															<div class="col-md-6 col-sm-12">
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
													{!! Form::open(array('url' => 'contact', 'class' => 'row')) !!}
														<div class="col-md-4 col-sm-12">
															<label>Name <span class="required">*</span></label>
															{{ Form::text('name', old('name'), array('class' => 'form-control', 'placeholder' => 'Name')) }}
															
														</div>
														<div class="col-md-4 col-sm-12">
															<label>Email <span class="required">*</span></label>
															{{ Form::text('email', old('email'), array('class' => 'form-control', 'placeholder' => 'Email')) }}
														</div>

														<div class="col-md-4 col-sm-12">
															<label>Subject</label>
															{{ Form::text('subject', old('subject'), array('class' => 'form-control', 'placeholder' => 'Subject')) }}
														</div>
														<div class="col-md-12 col-sm-12">
															<label>Your Message <span class="required">*</span></label>
															{{ Form::textarea('message', old('message'), array('class' => 'form-control', 'placeholder' => 'Enter the message')) }}
														</div>
														<div class="col-md-12 col-sm-12">
															<input type="submit" value="Send Message" class="btn btn-primary" />
														</div>
													{!! Form::close() !!}
													</div>
												</div>
                                            
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
@include('layouts.footer')