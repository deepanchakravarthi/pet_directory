<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.create_user')); ?></h2>
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
												<?php echo Form::open(array('url' => 'create-admin', 'class' => 'row')); ?>

													<div class="col-md-3 col-sm-12">
													</div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="commentform">
														<?php if(count($errors->all()) > 0): ?>
															<div class="col-md-12 col-sm-12">
															<?php foreach( $errors->all() as $message ): ?>
																<div class="alert alert-danger" role="alert">
																	<?php echo e($message); ?>

																</div>
															<?php endforeach; ?>
															</div>
														<?php endif; ?>
														<?php if(Session::has('message')): ?>
															<div class="col-md-12 col-sm-12">
																<div class="alert alert-success" role="alert">
																	<?php echo e(Session::get('message')); ?>

																</div>
															</div>
														<?php endif; ?>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.user_type')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::hidden('user_type', 4)); ?>

																	<?php echo e(Form::text('user_type_text', trans('words.admin'), array('class' => 'form-control', 'readonly' => 'readonly'))); ?>

																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.salutation')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::select('salutation', $salutationArray, old('salutation'), array('class' => 'form-control', 'placeholder' => trans('words.select_salutation')))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.firstname')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('firstname', old('firstname'), array('class' => 'form-control', 'placeholder' => trans('words.firstname')))); ?>

																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.lastname')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('lastname', old('lastname'), array('class' => 'form-control', 'placeholder' => trans('words.lastname')))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.email')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('email', old('email'), array('class' => 'form-control', 'placeholder' => 'example@test.com'))); ?>

																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.phone')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('phone', old('phone'), array('class' => 'form-control', 'placeholder' => '1234567890'))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.password')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::password('password', array('class' => 'form-control', 'placeholder' => trans('words.password'), 'id' => 'create_user_password'))); ?>

																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.cpassword')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::password('confirm_password', array('class' => 'form-control', 'placeholder' => trans('words.cpassword'), 'id' => 'create_user_cpassword'))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-12 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.address')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('address', old('address'), array('class' => 'form-control', 'placeholder' => trans('words.address')))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.zip')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('zip', old('zip'), array('class' => 'form-control', 'placeholder' => '12345'))); ?>

																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.city')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('city', old('city'), array('class' => 'form-control', 'placeholder' => trans('words.city')))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.state')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::text('state', old('state'), array('class' => 'form-control', 'placeholder' => trans('words.state')))); ?>

																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.country')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::select('country', $countries, old('country'), array('class' => 'form-control', 'placeholder' => trans('words.select_country')))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.location')); ?>Language <span class="required">*</span></label>
																	<?php echo e(Form::select('language', $languages, old('language'), array('class' => 'form-control', 'placeholder' => 'Select Language'))); ?>

																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.company')); ?> <span class="required"></span></label>
																	<?php echo e(Form::text('company', old('company'), array('class' => 'form-control', 'placeholder' => trans('words.company')))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="card-details">
																	<label><?php echo e(trans('words.status')); ?> <span class="required">*</span></label>
																	<?php echo e(Form::select('status', array(trans('words.active'), trans('words.inactive')), old('status'), array('class' => 'form-control'))); ?>

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12 center-alignment mt-3">
																<input type="submit" value="<?php echo e(trans('words.create_user')); ?>" class="btn btn-outline-primary btn-fullwidth width-100" />
															</div>
															<div class="col-md-6 col-sm-12 center-alignment mt-3">
																<input type="button" onclick="window.history.go(-1); return false;" value="<?php echo e(trans('words.reset')); ?>" class="btn btn-outline-secondary btn-fullwidth width-100" />
															</div>
														</div>
													</div>
													</div>
													<div class="col-md-3 col-sm-12"></div>
                                                <?php echo Form::close(); ?>

                                            
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
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>