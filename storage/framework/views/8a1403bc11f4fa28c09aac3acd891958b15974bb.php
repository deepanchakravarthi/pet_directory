<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.reset_password')); ?></h2>
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
										<?php echo Form::open(array('url' => 'reset-password', 'class' => 'row')); ?>

											<?php echo Form::hidden('token', $token); ?>

											<div class="col-md-3 col-sm-12">
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="commentform">
													<div class="row">
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
													</div>
													<div class="row">
														<div class="col-md-12 col-sm-12">
															<label><?php echo e(trans('words.email')); ?> <span class="required">*</span></label>
															<?php echo e(Form::text('email', old('email'), array('class' => 'form-control', 'placeholder' => 'abc@email.com'))); ?>

														</div>
													</div>
													<div class="row mt-2">
														<div class="col-md-6 col-sm-12">
															<label><?php echo e(trans('words.password')); ?> <span class="required">*</span></label>
															<?php echo e(Form::password('password', array('class' => 'form-control', 'placeholder' => trans('words.password')))); ?>

														</div>
													
														<div class="col-md-6 col-sm-12">
															<label><?php echo e(trans('words.cpassword')); ?> <span class="required">*</span></label>
															<?php echo e(Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => trans('words.cpassword')))); ?>

														</div>
													</div>
													<div class="row">
														<div class="col-md-6 col-sm-12 center-alignment mt-3">
															<input type="submit" value="<?php echo e(trans('words.submit')); ?>" class="btn btn-outline-primary btn-fullwidth width-100" />
														</div>
														<div class="col-md-6 col-sm-12 center-alignment mt-3">
															<input onclick='location.href="<?php echo e(SITE_PATH); ?>/login"'; type="button" value="<?php echo e(trans('words.back_login')); ?>" class="btn btn-outline-secondary btn-fullwidth width-100" />
														</div>
													</div>
												</div>
											</div>
										<?php echo Form::close(); ?>

									<!-- end form-container -->
										</div>
									</div>
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
	</section>
	<!-- end container -->
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>