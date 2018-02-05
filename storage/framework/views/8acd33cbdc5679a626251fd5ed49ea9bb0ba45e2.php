<?php	use App\User;
		$currentPlan	= '';
		$currentPlanCost= '';
		$isStripe		= 0; ?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.subscriptions')); ?></h2>
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
												<div class="col-md-2 col-sm-12">
												</div>
												<div class="col-md-8 col-sm-12">
													<?php if(Session::has('message')): ?>
													<div class="alert alert-success" role="alert">
														<?php echo e(Session::get('message')); ?>

													</div>
													<?php endif; ?>
												</div>
											</div>
											<div class="row">
												<!--<div class="col-md-2 col-sm-12">
												</div>-->
												<?php if(Auth::user()->user_type == 4): ?>
													<!--<div class="col-md-2 col-sm-12">
													</div>-->
													<div class="col-md-12 col-sm-12">
												<?php else: ?>
												<div class="col-md-8 col-sm-12">
												<?php endif; ?>
													<div class="commentform">
														<table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																	<th><?php echo e(trans('words.date')); ?></th>
																	<?php if(Auth::user()->user_type == 4): ?>
																	<th><?php echo e(trans('words.user')); ?></th>
																	<th><?php echo e(trans('words.subscription_id')); ?></th>
																	<?php endif; ?>
																	<th><?php echo e(trans('words.description')); ?></th>
																	<th><?php echo e(trans('words.status')); ?></th>
																	<th><?php echo e(trans('words.lifetime')); ?></th>
																	<th><?php echo e(trans('words.cost')); ?></th>
																	<th><?php echo e(trans('words.method')); ?></th>
																	<th><?php echo e(trans('words.card_number')); ?></th>
																	<th><?php echo e(trans('words.mandate_url')); ?></th>
																	<?php if(Auth::user()->user_type != 2): ?>
																	<th><?php echo e(trans('words.mandate_ref')); ?></th>
																	<?php endif; ?>
																	<?php if(Auth::user()->user_type == 4): ?>
																	<th>Action</th>
																	<?php endif; ?>
																</tr>
															</thead>
															<tbody>
															<?php	$inc	= 0;	?>
															<?php if(count($subscriptions) > 0): ?>
																<?php foreach($subscriptions as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';
																		if($value->status == 1) {
																			$currentPlan	= $planArray[$value->plan_id];
																			//$currentPlanCost= ($value->plan_id == 1) ? SITE_PLAN_COST : trans('words.free');
																			$isStripe		= $value->is_stripe;
																		}	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	<td><?php echo e(date('m/d/Y', strtotime($value->created_at))); ?></td>
																	<?php if(Auth::user()->user_type == 4): ?>
																	<td><a href="<?php echo e(SITE_PATH); ?>/view-user/<?php echo e($value->vet_id); ?>" title="<?php echo e(trans('words.view_vet')); ?>">
																		<?php	$subUser	= User::find($value->vet_id);
																				echo $subUser->firstname.' '.$subUser->lastname;
																				if(in_array(Auth::user()->country, $euCountries)) {
																					$curr	= 'EUR';
																				} else {
																					$curr	= 'USD';
																				}
																				?></a></td>
																	<td><?php echo e($value->subscription_id); ?></td>
																	<?php endif; ?>
																	<?php
																	if(Auth::user()->user_type == 4) {
																		$currentPlanCost= ($value->plan_id == 1) ? SITE_PLAN_COST.' '.$curr : trans('words.free');
																	} else {
																		if(in_array(Auth::user()->country, $euCountries)) {
																			$curr	= 'EUR';
																		} else {
																			$curr	= 'USD';
																		}
																		$currentPlanCost= ($value->plan_id == 1) ? SITE_PLAN_COST.' '.$curr : trans('words.free');
																	}
																	
																	?>
																	<?php if($value->plan_id == 3): ?>
																	<td><?php echo e($planArray[$value->plan_id]); ?> - <?php echo e($value->voucher); ?></td>
																	<?php else: ?>
																	<td><?php echo e($planArray[$value->plan_id]); ?></td>
																	<?php endif; ?>
																	
															<?php	if($value->payment_status == 0) { ?>
																	<td><?php echo e(trans('words.pending')); ?></td>
																	<td></td>
															<?php	} else if($value->payment_status == 2) { ?>
																	<td><?php echo e(trans('words.failure')); ?></td>
																	<td></td>
															<?php	} else {	?>
																	<td><?php echo e(trans('words.success')); ?></td>
																	<td><?php echo e(date('m-d-Y', strtotime($value->start_date)).' - '.date('m-d-Y', strtotime($value->end_date))); ?>

																	</td>
															<?php	}	?>
																	<td>
																	<?php if($value->plan_id == 1): ?>
																	<?php echo e(SITE_PLAN_COST); ?> <?php echo e($value->currency); ?>

																	<?php else: ?>
																	<?php echo e(trans('words.free')); ?>

																	<?php endif; ?>
																	</td>
																	<td><?php	if($value->method == 1) { echo trans('words.credit_card'); } else { echo trans('words.sepa_direct_debit'); } ?></td>
																	<td><?php	echo $value->last4; ?></td>
																	<td><?php	if($value->method == 2) { echo '<a target="_blank" href="'.$value->mandate_url.'">Link</a>'; } ?></td>
																	<?php if(Auth::user()->user_type != 2): ?>
																	<td><?php	if($value->method == 2) { echo $value->mandate_reference; } ?></td>
																	<?php endif; ?>
																	<?php if(Auth::user()->user_type == 4): ?>
																	<td><a href="<?php echo e(SITE_PATH); ?>/cancel-subscription/<?php echo e($value->id); ?>"><?php echo e(trans('words.cancel')); ?> <?php echo e(trans('words.subscription')); ?></a></td>
																	<?php endif; ?>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td 
																	<?php if(Auth::user()->user_type == 4): ?>
																		colspan="13"
																	<?php else: ?>
																		colspan="10"
																	<?php endif; ?>
																	style="text-align:center;"><?php echo e(trans('words.no_records_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
													</div>
												</div>
												<?php if(Auth::user()->user_type != 4): ?>
												<div class="col-md-4 col-sm-12">
													<div class="row">
														<div class="col-md-4 col-sm-12" >
															
														</div>
														<?php	if($inc > 0 && $currentPlan != '') {	// Have records & valid subscription ?>
														<div class="col-md-12 col-sm-12" >
															<?php echo e(trans('words.current_plan')); ?>: <span style="color:#0069D9;font-weight:bold;"><?php echo e($currentPlan); ?></span><br>
															<?php echo e(trans('words.plan_cost')); ?>: <span style="color:#0069D9;font-weight:bold;"><?php echo e($currentPlanCost); ?></span>
														</div>
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-primary btn-fullwidth mt-3" onclick="location.href='<?php echo e(SITE_PATH); ?>/change-subscription';" value="<?php echo e(trans('words.change_subscription')); ?>">
														</div>
														<?php if($isStripe): ?>
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-primary btn-fullwidth mt-3" onclick="location.href='<?php echo e(SITE_PATH); ?>/change-payment-details';"  value="<?php echo e(trans('words.change_payment_details')); ?>">
														</div>
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-secondary btn-fullwidth mt-3" onclick="location.href='<?php echo e(SITE_PATH); ?>/cancel-subscription/<?php echo e($value->id); ?>';"  value="<?php echo e(trans('words.cancel')); ?> <?php echo e(trans('words.subscription')); ?>">
														</div>
														<?php endif; ?>
														<?php	} else if($inc > 0 && $currentPlan == '' || $inc == 0) { //	Have records and no valid subscription	?>
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-primary btn-fullwidth mt-3" onclick="location.href='<?php echo e(SITE_PATH); ?>/change-subscription';" value="<?php echo e(trans('words.change_subscription')); ?>">
														</div>
														<?php	} ?>
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