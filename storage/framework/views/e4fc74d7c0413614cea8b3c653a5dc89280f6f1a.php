<?php	use App\User;
		$userArray	= Auth::user();	?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.my_pets')); ?></h2>
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
														<?php if(count($offers) > 0): ?>
															<?php foreach($offers as $key => $value): ?>
														<div class="alert alert-primary" role="alert">
														<?php	$owner	= User::find($value->user_id); ?>
															<?php if($userArray->user_type == 2): ?>
															<strong><?php echo e(trans('words.received_request')); ?></strong> <?php echo e($owner->firstname.' '.$owner->lastname); ?> <?php echo e(trans('words.received_offer_message')); ?> <button class="btn btn-outline-primary" onclick="location.href='<?php echo e(SITE_PATH); ?>/pet/accept-offer/<?php echo e($value->id); ?>';"><?php echo e(trans('words.accept_request')); ?></button>
															<?php else: ?>
															<strong><?php echo e(trans('words.received_offer')); ?></strong> <?php echo e($owner->firstname.' '.$owner->lastname); ?> <?php echo e(trans('words.received_request_message')); ?> <button class="btn btn-outline-primary" onclick="location.href='<?php echo e(SITE_PATH); ?>/pet/accept-offer/<?php echo e($value->id); ?>';"><?php echo e(trans('words.accept_offer')); ?></button>
															<?php endif; ?>
														</div>
															<?php endforeach; ?>
														<?php endif; ?>
														
														<div class="row">
															<div class="col-md-12 col-sm-12" >
																<input type="button" value="<?php echo e(trans('words.create_new_pet')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/create-pet';" class="btn btn-outline-primary width-100" style="float:right;margin-bottom:10px;margin-right:20px;" />
															</div>
														</div>
														<div class="table-responsive">
														<table class="table table-striped table-hover responsive" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																<?php if($userArray->user_type == 2 || $userArray->user_type == 4): ?>
																	<th><?php echo e(trans('words.country')); ?></th>
																<?php endif; ?>
																	<th><?php echo e(trans('words.species')); ?></th>
																	<th><?php echo e(trans('words.name')); ?></th>
																	<th><?php echo e(trans('words.age')); ?></th>
																<?php if($userArray->user_type == 2 || $userArray->user_type == 4): ?>
																	<th><?php echo e(trans('words.chip_id')); ?></th>
																	<th><?php echo e(trans('words.pet_id')); ?></th>
																	<th><?php echo e(trans('words.tag_id')); ?></th>
																	<th><?php echo e(trans('words.tattoo_id')); ?></th>
																<?php endif; ?>
																<?php if($userArray->user_type == 2 || $userArray->user_type == 4): ?>
																<th><?php echo e(trans('words.owner')); ?></th>
																<?php endif; ?>
																<?php if($userArray->user_type == 1 || $userArray->user_type == 4): ?>
																	<th><?php echo e(trans('words.veterinary')); ?></th>
																<?php endif; ?>
																	<th><?php echo e(trans('words.actions')); ?></th>
																</tr>
															</thead>
															<tbody>
															<?php if(count($pets) > 0): ?>
																<?php	$inc	= 0;	?>
																<?php foreach($pets as $key => $value): ?>
																<?php	//$class	= ($inc%2!=0) ? '' : 'table-light';
																		$class	= '';
																		if($value->date_of_birth != '0000-00-00') {
																			$birthdate	= new DateTime($value->date_of_birth);
																			$today		= new DateTime('today');
																			$age		= $birthdate->diff($today)->y;
																		} else {
																			$age		= '';
																		}	?>
																<tr class="<?php echo $class;	?>">
																	<td scope="row"><?php echo e($inc+1); ?></td>
																<?php if($userArray->user_type == 2 || $userArray->user_type == 4): ?>
																<?php	$ownerData	= User::find($value->owner_id);	?>
																	<td><?php echo e($countries[$ownerData->country]); ?></td>
																<?php endif; ?>
																	<td><?php echo e($speciesArray[$value->species]); ?></td>
																	<td><?php echo e($value->name); ?></td>
																	<td><?php echo e($age); ?></td>
																	<?php if($value->date_of_death == '0000-00-00'): ?>
																		
																	<?php if($userArray->user_type != 2): ?>
																	<!-- Modal -->
																	<div class="modal" id="removeModal<?php echo e($value->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans('words.move_pet_to_another_account')); ?></h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<h5><?php echo e(trans('words.move_to_other_account')); ?></h5>
																					<p style="display:none;text-align:center;" id="confirm_offer_error_message_<?php echo e($value->id); ?>_1"></p>
																					<div id="confirm_offer_form_<?php echo e($value->id); ?>_1">
																						<form method="post" action="">
																						<div class="card-details">
																							<label><?php echo e(trans('words.new_owner_mail')); ?> <span class="required">*</span></label>
																							<input type="text" name="email" id="new_owner_email_<?php echo e($value->id); ?>_1" class="form-control">
																						</div>
																						<div class="card-details">
																							<input type="button" value="<?php echo e(trans('words.send_offer')); ?>" onclick="confirmOffer(<?php echo e($value->id); ?>, 1);"  class="btn btn-outline-primary">
																						</div>
																						</form>
																					</div>
																					<h5 clas="mt-3"><?php echo e(trans('words.set_pet_as_dead')); ?></h5>
																					<p style="display:none;text-align:center;" id="confirm_death_error_message_<?php echo e($value->id); ?>"></p>
																					<div id="confirm_death_form_<?php echo e($value->id); ?>">
																						<form method="post" action="">
																							<div class="card-details">
																								<label><?php echo e(trans('words.day_of_death')); ?> <span class="required">*</span></label>
																								<input type="text" name="email" id="date_of_death_<?php echo e($value->id); ?>" class="form-control datepicker">
																							</div>
																							<div class="card-details">
																								<label><?php echo e(trans('words.cause_of_death')); ?> <span class="required">*</span></label>
																								<input type="text" name="cause" id="cause_of_death_<?php echo e($value->id); ?>" class="form-control">
																							</div>
																							<div class="card-details">
																								<input type="button" value="<?php echo e(trans('words.set_as_dead')); ?>" onclick="confirmDeath(<?php echo e($value->id); ?>);" class="btn btn-outline-primary">
																							</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<?php endif; ?>
																	
																	<!-- Modal 2 -->
																	<div class="modal" id="searchModal<?php echo e($value->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans('words.set_as_lost')); ?></h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<h6><?php echo e(trans('words.lost_header')); ?></h6>
																					<p style="display:none;text-align:center;" id="confirm_lost_error_message_<?php echo e($value->id); ?>"></p>
																					<div id="confirm_lost_form_<?php echo e($value->id); ?>">
																						<form method="post" action="">
																							<div class="card-details">
																								<label><?php echo e(trans('words.location')); ?> <span class="required">*</span></label>
																								<input type="text" name="lost_location" id="lost_location_<?php echo e($value->id); ?>" class="form-control">
																							</div>
																							<div id="map"></div>
																							<div class="card-details">
																								<label><?php echo e(trans('words.lost_date')); ?> <span class="required">*</span></label>
																								<input type="text" name="lost_date" id="lost_date_<?php echo e($value->id); ?>" class="form-control datepicker">
																							</div>
																							<div class="card-details">
																								<label><?php echo e(trans('words.lost_time')); ?> <span class="required">*</span></label>
																								<input type="text" name="lost_time" id="lost_time_<?php echo e($value->id); ?>" class="form-control timepicker">
																							</div>
																							<div class="card-details">
																								<input type="button" value="<?php echo e(trans('words.set_lost_download_poster')); ?>" onclick="confirmLost(<?php echo e($value->id); ?>);" class="btn btn-outline-primary">
																							</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	
																	<!-- Modal 3 -->
																	<div class="modal" id="foundModal<?php echo e($value->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans('words.pet_found')); ?></h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<form method="post" action="">
																						<p style="display:none;text-align:center;" id="confirm_found_error_message_<?php echo e($value->id); ?>"></p>
																						<div class="card-details" id="confirm_found_form_<?php echo e($value->id); ?>">
																							<input type="button" value="<?php echo e(trans('words.confirm_found')); ?>" onclick="confirmFound(<?php echo e($value->id); ?>);" class="btn btn-outline-primary">
																							&nbsp;
																							<input onclick="location.href='<?php echo e(SITE_PATH); ?>/create-poster/<?php echo e($value->id); ?>';" type="button" value="<?php echo e(trans('words.not_found')); ?>" class="btn btn-outline-primary">
																						</div>
																					</form>
																				</div>
																			</div>
																		</div>
																	</div>
																	
																	<!-- Modal 4 -->
																	<div class="modal" id="noteModal<?php echo e($value->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans('words.add_note')); ?></h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<p style="display:none;text-align:center;" id="add_note_error_message_<?php echo e($value->id); ?>"></p>
																					<div id="add_note_form_<?php echo e($value->id); ?>">
																						<form method="post" action="">
																							<div class="card-details">
																								<label><?php echo e(trans('words.note')); ?> <span class="required">*</span></label>
																								<input type="text" name="notes" id="notes_<?php echo e($value->id); ?>" class="form-control">
																							</div>
																							<div class="card-details">
																								<input type="button" value="<?php echo e(trans('words.save')); ?>" onclick="confirmAddNote(<?php echo e($value->id); ?>);" class="btn btn-outline-primary">
																							</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<!-- Modal 5-->
																	<?php if(($userArray->user_type == 2 && $value->vet_id == $value->owner_id) || ($userArray->user_type == 4 && $value->owner_id == $userArray->id)): ?>
																	<div class="modal" id="assignModal<?php echo e($value->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans('words.assign_pet_to_owner')); ?></h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<p style="display:none;text-align:center;" id="confirm_offer_error_message_<?php echo e($value->id); ?>_2"></p>
																					<div id="assign_offer_form_<?php echo e($value->id); ?>_2">
																						<form method="post" action="">
																						<div class="card-details">
																							<label><?php echo e(trans('words.owner_email')); ?> <span class="required">*</span></label>
																							<input type="text" name="email" id="new_owner_email_<?php echo e($value->id); ?>_2" class="form-control">
																						</div>
																						<div class="card-details">
																							<input type="button" value="<?php echo e(trans('words.send_request')); ?>" onclick="confirmOffer(<?php echo e($value->id); ?>, 2);"  class="btn btn-outline-primary">
																						</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<?php endif; ?>
																	<!-- Modal 6-->
																	<?php if(($userArray->user_type == 1 || $userArray->user_type == 4) && $value->vet_id == 0): ?>
																	<div class="modal" id="assignVetModal<?php echo e($value->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans('words.assign_pet_to_vet')); ?></h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<p style="display:none;text-align:center;" id="confirm_vet_offer_error_message_<?php echo e($value->id); ?>"></p>
																					<div id="confirm_vet_offer_form_<?php echo e($value->id); ?>">
																						<form method="post" action="">
																						<div class="card-details">
																							<label><?php echo e(trans('words.vet_email')); ?> <span class="required">*</span></label>
																							<input type="text" name="email" id="vet_email_<?php echo e($value->id); ?>" class="form-control">
																						</div>
																						<div class="card-details">
																							<input type="button" value="<?php echo e(trans('words.send_request')); ?>" onclick="confirmVetOffer(<?php echo e($value->id); ?>);"  class="btn btn-outline-primary">
																						</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<?php endif; ?>
																	
																	<?php endif; ?>
																<?php if($userArray->user_type == 2 || $userArray->user_type == 4): ?>
																	<td><?php echo e($value->chip_id); ?></td>
																	<td><?php echo e($value->pet_id); ?></td>
																	<td><?php echo e($value->tag_id); ?></td>
																	<td><?php echo e($value->tattoo_id); ?></td>
																	<?php if($userArray->user_type == 2 || $userArray->user_type == 4): ?>
																	<?php	$ownerData	= User::find($value->owner_id);	?>
																	<td><?php echo e($ownerData->firstname.' '.$ownerData->lastname); ?></td>
																	<?php endif; ?>
																<?php endif; ?>
																<?php if($userArray->user_type == 1 || $userArray->user_type == 4): ?>
																	<?php	$vetData	= User::find($value->vet_id);	
																			if($vetData) { ?>
																	<td><?php echo e($vetData->firstname.' '.$vetData->lastname); ?></td>
																	<?php	} else { ?>
																	<td></td>
																	<?php	} ?>
																<?php endif; ?>
																	<td>
																		<?php if($value->date_of_death == '0000-00-00'): ?>
																		
																		<!-- Button trigger modal -->
																		<button type="button"  title="<?php echo e(trans('words.view_data')); ?>" onclick="location.href='<?php echo e(SITE_PATH); ?>/view-pet/<?php echo e($value->id); ?>';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																																				
																		<button type="button"  onclick="location.href='<?php echo e(SITE_PATH); ?>/edit-pet/<?php echo e($value->id); ?>'" title="<?php echo e(trans('words.edit_data')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		
																		<?php if($userArray->user_type != 2): ?>
																		<button type="button"  data-toggle="modal" data-target="#removeModal<?php echo e($value->id); ?>" title="<?php echo e(trans('words.remove_data')); ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
																		<?php endif; ?>
																		
																		<?php if($value->lost_date != '0000-00-00'): ?>
																		<button type="button"  data-toggle="modal" data-target="#foundModal<?php echo e($value->id); ?>" title="<?php echo e(trans('words.found')); ?>"><i class="fa fa-search" aria-hidden="true"></i></button>
																		<?php else: ?>
																		<button type="button"  data-toggle="modal" data-target="#searchModal<?php echo e($value->id); ?>" title="<?php echo e(trans('words.lost')); ?>"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
																		<?php endif; ?>
																		
																		<?php if($userArray->user_type == 2): ?>
																		<button type="button"  data-toggle="modal" data-target="#noteModal<?php echo e($value->id); ?>" title="<?php echo e(trans('words.note_data')); ?>"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></button>
																		<?php if($value->vet_id == $value->owner_id): ?>
																		<button type="button"  data-toggle="modal" data-target="#assignModal<?php echo e($value->id); ?>" title="<?php echo e(trans('words.assign_owner')); ?>"><i class="fa fa-user" aria-hidden="true"></i></button>
																		<?php endif; ?>
																		<?php endif; ?>
																		
																		<?php if($userArray->user_type == 4 && $value->owner_id == $userArray->id): ?>
																		<button type="button"  data-toggle="modal" data-target="#assignModal<?php echo e($value->id); ?>" title="<?php echo e(trans('words.assign_owner')); ?>"><i class="fa fa-user" aria-hidden="true"></i></button>
																		<?php endif; ?>
																		
																		<?php if(($userArray->user_type == 1 || $userArray->user_type == 4) && $value->vet_id == 0): ?>
																		<button type="button"  data-toggle="modal" data-target="#assignVetModal<?php echo e($value->id); ?>" title="<?php echo e(trans('words.assign_vet')); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
																		<?php endif; ?>
																		
																		<?php endif; ?>
																	</td>
																</tr>
																<?php	$inc++;	?>
															<?php endforeach; ?>
															<?php else: ?>
																<tr class="table-primary">
																	<td 
																	<?php if($userArray->user_type == 4): ?>
																		colspan="12"
																	<?php elseif($userArray->user_type == 1): ?>
																		colspan="5"
																	<?php elseif($userArray->user_type == 2): ?>
																		colspan="11"
																	<?php endif; ?>
																	style="text-align:center;"><?php echo e(trans('words.no_pets_found')); ?></td>
																</tr>
															<?php endif; ?>
														  </tbody>
														</table>
														</div>
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