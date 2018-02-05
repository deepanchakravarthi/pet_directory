<?php	use App\User;
		use App\Subscription;	?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				<?php if(Auth::user()->user_type == 4 && Auth::user()->id != $user->id): ?>
                    <h2><?php echo e(trans('words.view_user')); ?></h2>
				<?php else: ?>
					<h2><?php echo e(trans('words.my_profile')); ?></h2>
				<?php endif; ?>
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
												<div class="row">
												<?php if(Auth::user()->user_type != 4): ?>
													<div class="col-md-3 col-sm-12">
													</div>
													<div class="col-md-6 col-sm-12">
												<?php endif; ?>
												<?php if(Auth::user()->user_type == 4): ?>
													<?php if($user->user_type != 2): ?>
														<div class="col-md-3 col-sm-12">
														</div>
														<div class="col-md-6 col-sm-12">
													<?php else: ?>
														<div class="col-md-6 col-sm-12">
													<?php endif; ?>
													
													<h5><?php echo e(trans('words.profile_data')); ?></h5>
												<?php endif; ?>
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
															<?php if(isset($offers) && count($offers) > 0): ?>
																<?php foreach($offers as $key => $value): ?>
															<div class="alert alert-primary" role="alert">
															<?php	$owner	= User::find($value->user_id); ?>
																<?php if($user->user_type == 2): ?>
																<strong><?php echo e(trans('words.received_request')); ?></strong> <?php echo e($owner->firstname.' '.$owner->lastname); ?> <?php echo e(trans('words.received_offer_message')); ?> <button class="btn btn-outline-primary" onclick="location.href='<?php echo e(SITE_PATH); ?>/pet/accept-offer/<?php echo e($value->id); ?>';"><?php echo e(trans('words.accept_request')); ?></button>
																<?php else: ?>
																<strong><?php echo e(trans('words.received_offer')); ?></strong> <?php echo e($owner->firstname.' '.$owner->lastname); ?> <?php echo e(trans('words.received_request_message')); ?> <button class="btn btn-outline-primary" onclick="location.href='<?php echo e(SITE_PATH); ?>/pet/accept-offer/<?php echo e($value->id); ?>';"><?php echo e(trans('words.accept_offer')); ?></button>
																<?php endif; ?>
															</div>
																<?php endforeach; ?>
															<?php endif; ?>
															</div>
															<div class="row">
																<div class="col-md-12 col-sm-12 left-alignment mt-3">
																	<table class="table">
																		<tbody>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.name')); ?></th>
																				<td><?php echo e($salutationArray[$user->salutation]); ?>. <?php echo e($user->firstname); ?> <?php echo e($user->lastname); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.user_type')); ?></th>
																				<?php if($user->user_type == 4): ?>
																				<td><?php echo e(trans('words.admin')); ?></td>
																				<?php else: ?>
																				<td><?php echo e($userTypes[$user->user_type]); ?></td>
																				<?php endif; ?>
																			</tr>
																			<?php if($user->user_type == 2): ?>
																			<?php if($user->company != ''): ?>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.company')); ?></th>
																				<td><?php echo e($user->company); ?></td>
																			</tr>
																			<?php endif; ?>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.register_number')); ?></th>
																				<td><?php echo e($user->register_number); ?></td>
																			</tr>
																			<?php endif; ?>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.email')); ?></th>
																				<td><?php echo e($user->email); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.phone')); ?></th>
																				<td><?php echo e($user->phone); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.address')); ?></th>
																				<td><?php echo e($user->address); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.zip')); ?></th>
																				<td><?php echo e($user->zip); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.city')); ?></th>
																				<td><?php echo e($user->city); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.state')); ?></th>
																				<td><?php echo e($user->state); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.country')); ?></th>
																				<td><?php echo e($countries[$user->country]); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.language')); ?></th>
																				<td><?php echo e($languages[$user->language]); ?></td>
																			</tr>
																			<?php if($user->user_type == 1): ?>
																			<?php if($user->company != ''): ?>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.company')); ?></th>
																				<td><?php echo e($user->company); ?></td>
																			</tr>
																			<?php endif; ?>
																			<?php endif; ?>
																			<?php if(Auth::user()->user_type == 1 || Auth::user()->user_type == 4): ?>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.permission')); ?></th>
																				<td><?php echo e($ownerPermissionArray[$user->permission]); ?></td>
																			</tr>
																			<?php endif; ?>
																			<?php if($user->user_type == 3): ?>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.authority_name')); ?></th>
																				<td><?php echo e($user->authority_name); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.supervisor_name')); ?></th>
																				<td><?php echo e($user->supervisor_name); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.supervisor_email')); ?></th>
																				<td><?php echo e($user->supervisor_email); ?></td>
																			</tr>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.supervisor_phone')); ?></th>
																				<td><?php echo e($user->supervisor_phone); ?></td>
																			</tr>
																			<?php endif; ?>
																			
																			<?php if(Auth::user()->user_type == 4 && Auth::user()->id != $user->id): ?>
																			<tr class="table-light">
																				<th><?php echo e(trans('words.status')); ?></th>
																				<td><?php	echo ($user->status == 0) ? trans('words.active') : trans('words.inactive'); ?></td>
																			</tr>
																			<?php endif; ?>
																		</tbody>
																	</table>
																</div>
															</div>
															<div class="row mt-3">
																<div class="col-md-6 col-sm-6 center-alignment ">
																	<?php if(Auth::user()->user_type == 4 && Auth::user()->id != $user->id): ?>
																		<?php	if($user->user_type == 1) {
																					$editUrl	= 'user';
																				} else if($user->user_type == 2) {
																					$editUrl	= 'vet';
																				} else if($user->user_type == 3) {
																					$editUrl	= 'authority';
																				} else if($user->user_type == 4) {
																					$editUrl	= 'admin';
																				} ?>
																		<input onclick='location.href="<?php echo e(SITE_PATH); ?>/edit-<?php echo e($editUrl); ?>/<?php echo e($user->id); ?>"'; type="button"  value="<?php echo e(trans('words.edit_profile')); ?>" class="btn btn-outline-primary btn-fullwidth width-100" />
																	<?php elseif(Auth::user()->id != $user->id): ?>
																		<input onclick='location.href="<?php echo e(SITE_PATH); ?>/edit-user/<?php echo e($user->id); ?>"'; type="button"  value="<?php echo e(trans('words.edit_profile')); ?>" class="btn btn-outline-primary btn-fullwidth width-100" />
																	<?php else: ?>
																		<input onclick='location.href="<?php echo e(SITE_PATH); ?>/edit-profile"'; type="button"  value="<?php echo e(trans('words.edit_profile')); ?>" class="btn btn-outline-primary btn-fullwidth width-100" />
																	<?php endif; ?>
																</div>
																<div class="col-md-6 col-sm-6 center-alignment ">
																	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="<?php echo e(trans('words.back')); ?>"  class="btn btn-outline-secondary btn-fullwidth width-100"/>
																</div>
															</div>
															
														</div>
													</div>
													<?php if(Auth::user()->user_type == 4 && $user->user_type == 2): ?>
													<div class="col-md-6 col-sm-12">
														<h5><?php echo e(trans('words.subscription')); ?></h5>
														<table class="table">
															<thead>
																<tr>
																	<th>#</th>
																	<th><?php echo e(trans('words.date')); ?></th>
																	<th><?php echo e(trans('words.description')); ?></th>
																	<th><?php echo e(trans('words.lifetime')); ?></th>
																	<th><?php echo e(trans('words.price')); ?></th>
																</tr>
															</thead>
															<tbody>
															<?php	$subscriptions	= Subscription::where('vet_id', '=', $user->id)->get();
																	$inc	= 0;	?>
															<?php if(count($subscriptions) > 0): ?>
																<?php foreach($subscriptions as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';
																		$currentSub 	= '';
																		if($value->status == 1) {
																			$currentPlan	= $planArray[$value->plan_id];
																			$currentPlanCost= ($value->plan_id == 1) ? SITE_PLAN_COST.' '.$value->currency : trans('words.free');
																			$isStripe		= $value->is_stripe;
																			$currentSub 	= 'table-dark';
																		}
																		?>
																<tr class="<?php echo $class.' '.$currentSub ;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	<td><?php echo e(date('m/d/Y', strtotime($value->created_at))); ?></td>
																	<?php if($value->plan_id == 3): ?>
																	<td><?php echo e($planArray[$value->plan_id]); ?> - <?php echo e($value->voucher); ?></td>
																	<?php else: ?>
																	<td><?php echo e($planArray[$value->plan_id]); ?></td>
																	<?php endif; ?>
																	<td><?php echo e(date('m-d-Y', strtotime($value->start_date)).' - '.date('m-d-Y', strtotime($value->end_date))); ?>

																	</td>
																	<td>
																	<?php if($value->plan_id == 1): ?>
																	<?php echo e(SITE_PLAN_COST); ?>

																	<?php else: ?>
																	<?php echo e(trans('words.free')); ?>

																	<?php endif; ?>
																	</td>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td colspan="5" style="text-align:center;"><?php echo e(trans('words.no_records_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
														
														<!-- Subscription pack assignment -->
														<h5><?php echo e(trans('words.assign_subscription')); ?></h5>
														<div class="commentform">
															<?php echo Form::open(array('url' => 'assign-subscription', 'class' => 'row')); ?>

															<div class="mt-2">
															<?php echo e(Form::hidden('vet_id', $user->id)); ?>

															<?php echo e(trans('words.plan')); ?>: <?php echo e(Form::select('plan', $planArray, old('plan'), array('id' => 'plan', 'class' => 'form-control', 'onchange' => 'checkPlan();'))); ?>

															<div>
															<div class="mt-2" id="voucher_term_div" style="display:none;">
															<?php echo e(trans('words.voucher_term')); ?>: 
															<input type="text" id="voucher_term" name="voucher_term" class = 'form-control' style="display:none;" placeholder="3 months"> 
															</div>
															<div class="mt-2">
															<input type="submit" value="Subscribe" class="btn btn-primary">
															<div>
															<div class="mt-3">
															<?php echo e(trans('words.note_assign_subscription')); ?>

															</div>
															<?php echo Form::close(); ?>

														</div>
													</div>
													<?php endif; ?>
												
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
	</section>
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>