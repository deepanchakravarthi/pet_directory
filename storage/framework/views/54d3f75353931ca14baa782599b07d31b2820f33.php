<?php	use App\User;
		$currentPlan	= '';
		$currentPlanCost= '';
		$isStripe		= 0; ?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.payments')); ?></h2>
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
												
												<div class="col-md-12 col-sm-12">
													<div class="commentform">
														<table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>																	
																	<th><?php echo e(trans('words.veterinary')); ?></th>
																	<th><?php echo e(trans('words.status')); ?></th>
																	<th><?php echo e(trans('words.charge_id')); ?></th>
																	<th><?php echo e(trans('words.customer_id')); ?></th>
																	<th><?php echo e(trans('words.subscription_id')); ?></th>
																	<th><?php echo e(trans('words.amount')); ?></th>
																	<th><?php echo e(trans('words.date')); ?></th>
																	
																</tr>
															</thead>
															<tbody>
															<?php	$inc	= 0;	?>
															<?php if(count($payments) > 0): ?>
																<?php foreach($payments as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';
																		if($value->status == 0) {
																			$status	= trans('words.pending');
																		} else if($value->status == 1) {
																			$status	= trans('words.success');
																		} else if($value->status == 2) {
																			$status	= trans('words.failure');
																		}
																		$vet	= User::find($value->vet_id);
																		if($vet) {
																			$vetname	= $vet->firstname.' '.$vet->lastname;
																		} else {
																			$vetname	= '';
																		}	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	<td><?php echo e($vetname); ?></td>
																	<td>
																	<?php echo e($status); ?>

																	</td>
																	<td><?php echo e($value->charge_id); ?></td>
																	<td><?php echo e($value->customer_id); ?></td>
																	<td><?php echo e($value->subscription_id); ?></td>
																	<td><?php echo e($value->amount); ?></td>
																	<td><?php echo e(date('m/d/Y', strtotime($value->created_at))); ?></td>
																	
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td colspan="8" style="text-align:center;"><?php echo e(trans('words.no_records_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
													</div>
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
	</section>
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>