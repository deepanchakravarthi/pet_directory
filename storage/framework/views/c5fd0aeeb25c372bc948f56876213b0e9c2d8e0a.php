<?php	use App\User;
		$userArray	= Auth::user();	?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.users')); ?></h2>
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
												<div class="col-md-2 col-sm-12">
												</div>
												<div class="col-md-8 col-sm-12">
													<div class="commentform">
														<div class="row">
															<div class="col-md-12 col-sm-12" >
																<?php if($userArray->user_type == 4): ?>
																<input type="button" value="<?php echo e(trans('words.create_new_user')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/create-user';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																<input type="button" value="<?php echo e(trans('words.create_vet')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/create-vet';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																<input type="button" value="<?php echo e(trans('words.create_auth')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/create-authority';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																<input type="button" value="<?php echo e(trans('words.create_admin')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/create-admin';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																<?php endif; ?>
															</div>
														</div>
														<?php if($userArray->user_type != 4): ?>
														<table class="mt-3 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																	<th><?php echo e(trans('words.firstname')); ?></th>
																	<th><?php echo e(trans('words.lastname')); ?></th>
																	<th><?php echo e(trans('words.city')); ?></th>
																	<th><?php echo e(trans('words.zip')); ?></th>
																	<th><?php echo e(trans('words.actions')); ?></th>
																</tr>
															</thead>
															<tbody>
															<?php if(count($users) > 0): ?>
																<?php	$inc	= 0;	?>
																<?php foreach($users as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	
																	<td><?php echo e($value->firstname); ?></td>
																	<td><?php echo e($value->lastname); ?></td>
																	<td><?php echo e($value->city); ?></td>
																	<td><?php echo e($value->zip); ?></td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="<?php echo e(trans('words.view_user')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/view-user/<?php echo e($value->id); ?>';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		<?php if($userArray->user_type == 4): ?>
																		<button type="button"  onclick="location.href='<?php echo e(SITE_PATH); ?>/edit-user/<?php echo e($value->id); ?>'" title="<?php echo e(trans('words.edit_user')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		<?php endif; ?>
																	</td>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td 
																	<?php if($userArray->user_type == 4): ?>
																		colspan="7" 
																	<?php else: ?>
																		colspan="6" 
																	<?php endif; ?>
																	style="text-align:center;"><?php echo e(trans('words.no_user_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
														<?php else: ?>
														<h4><?php echo e(trans('words.owner')); ?> <?php echo e(trans('words.list')); ?></h4>
														<table class="mt-3 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																	
																	<th><?php echo e(trans('words.firstname')); ?></th>
																	<th><?php echo e(trans('words.lastname')); ?></th>
																	<th><?php echo e(trans('words.city')); ?></th>
																	<th><?php echo e(trans('words.zip')); ?></th>
																	<th><?php echo e(trans('words.actions')); ?></th>
																</tr>
															</thead>
															<tbody>
															<?php if(count($users) > 0): ?>
																<?php	$inc	= 0;	?>
																<?php foreach($users as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	
																	<td><?php echo e($value->firstname); ?></td>
																	<td><?php echo e($value->lastname); ?></td>
																	<td><?php echo e($value->city); ?></td>
																	<td><?php echo e($value->zip); ?></td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="<?php echo e(trans('words.view_user')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/view-user/<?php echo e($value->id); ?>';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		<?php if($userArray->user_type == 4): ?>
																		<button type="button"  onclick="location.href='<?php echo e(SITE_PATH); ?>/edit-user/<?php echo e($value->id); ?>'" title="<?php echo e(trans('words.edit_user')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		<?php endif; ?>
																	</td>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td 
																	<?php if($userArray->user_type == 4): ?>
																		colspan="7" 
																	<?php else: ?>
																		colspan="6" 
																	<?php endif; ?>
																	style="text-align:center;"><?php echo e(trans('words.no_user_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
														<h4 class="mt-5"><?php echo e(trans('words.veterinary')); ?> <?php echo e(trans('words.list')); ?></h4>
														<table class="mt-5 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable2">
															<thead>
																<tr>
																	<th>#</th>
																	<th><?php echo e(trans('words.firstname')); ?></th>
																	<th><?php echo e(trans('words.lastname')); ?></th>
																	<th><?php echo e(trans('words.city')); ?></th>
																	<th><?php echo e(trans('words.zip')); ?></th>
																	<th><?php echo e(trans('words.actions')); ?></th>
																</tr>
															</thead>
															<tbody>
															<?php if(count($vet) > 0): ?>
																<?php	$inc	= 0;	?>
																<?php foreach($vet as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	
																	<td><?php echo e($value->firstname); ?></td>
																	<td><?php echo e($value->lastname); ?></td>
																	<td><?php echo e($value->city); ?></td>
																	<td><?php echo e($value->zip); ?></td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="<?php echo e(trans('words.view_user')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/view-user/<?php echo e($value->id); ?>';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		<?php if($userArray->user_type == 4): ?>
																		<button type="button"  onclick="location.href='<?php echo e(SITE_PATH); ?>/edit-vet/<?php echo e($value->id); ?>'" title="<?php echo e(trans('words.edit_user')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		<?php endif; ?>
																	</td>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td 
																	<?php if($userArray->user_type == 4): ?>
																		colspan="7" 
																	<?php else: ?>
																		colspan="6" 
																	<?php endif; ?>
																	style="text-align:center;"><?php echo e(trans('words.no_user_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
														<h5 class="mt-5"><?php echo e(trans('words.authority')); ?> <?php echo e(trans('words.list')); ?></h5>
														<table class="mt-5 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable3">
															<thead>
																<tr>
																	<th>#</th>
																	
																	<th><?php echo e(trans('words.firstname')); ?></th>
																	<th><?php echo e(trans('words.lastname')); ?></th>
																	<th><?php echo e(trans('words.city')); ?></th>
																	<th><?php echo e(trans('words.zip')); ?></th>
																	<th><?php echo e(trans('words.actions')); ?></th>
																</tr>
															</thead>
															<tbody>
															<?php if(count($authority) > 0): ?>
																<?php	$inc	= 0;	?>
																<?php foreach($authority as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	
																	<td><?php echo e($value->firstname); ?></td>
																	<td><?php echo e($value->lastname); ?></td>
																	<td><?php echo e($value->city); ?></td>
																	<td><?php echo e($value->zip); ?></td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="<?php echo e(trans('words.view_user')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/view-user/<?php echo e($value->id); ?>';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		<?php if($userArray->user_type == 4): ?>
																		<button type="button"  onclick="location.href='<?php echo e(SITE_PATH); ?>/edit-authority/<?php echo e($value->id); ?>'" title="<?php echo e(trans('words.edit_user')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		<?php endif; ?>
																	</td>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td 
																	<?php if($userArray->user_type == 4): ?>
																		colspan="7" 
																	<?php else: ?>
																		colspan="6" 
																	<?php endif; ?>
																	style="text-align:center;"><?php echo e(trans('words.no_user_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
														<h4 class="mt-5"><?php echo e(trans('words.admin')); ?> <?php echo e(trans('words.list')); ?></h4>
														<table class="mt-5 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable1">
															<thead>
																<tr>
																	<th>#</th>
																	<th><?php echo e(trans('words.firstname')); ?></th>
																	<th><?php echo e(trans('words.lastname')); ?></th>
																	<th><?php echo e(trans('words.city')); ?></th>
																	<th><?php echo e(trans('words.zip')); ?></th>
																	<th><?php echo e(trans('words.actions')); ?></th>
																</tr>
															</thead>
															<tbody>
															<?php if(count($admins) > 0): ?>
																<?php	$inc	= 0;	?>
																<?php foreach($admins as $key => $value): ?>
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row"><?php echo e($inc+1); ?></th>
																	
																	<td><?php echo e($value->firstname); ?></td>
																	<td><?php echo e($value->lastname); ?></td>
																	<td><?php echo e($value->city); ?></td>
																	<td><?php echo e($value->zip); ?></td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="<?php echo e(trans('words.view_user')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/view-user/<?php echo e($value->id); ?>';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		<?php if($userArray->user_type == 4): ?>
																		<button type="button"  onclick="location.href='<?php echo e(SITE_PATH); ?>/edit-admin/<?php echo e($value->id); ?>'" title="<?php echo e(trans('words.edit_user')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		<?php endif; ?>
																	</td>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td 
																	<?php if($userArray->user_type == 4): ?>
																		colspan="7" 
																	<?php else: ?>
																		colspan="6" 
																	<?php endif; ?>
																	style="text-align:center;"><?php echo e(trans('words.no_user_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
														<?php endif; ?>
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