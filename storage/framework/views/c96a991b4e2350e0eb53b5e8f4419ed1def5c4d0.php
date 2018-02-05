<?php	use App\User; ?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.search_result')); ?></h2>
				</div>
			</div>
		</div>
	</section>
    <section class="booking-details center-block main-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				<?php	if(isset($petData) && isset($ownerData)) { ?>
                    <h2><?php echo e(trans('words.id_found')); ?></h2>
                    <h6><?php echo e(trans('words.id_found_text')); ?></h6>
					<?php if($petData->vet_id != 0): ?>
					<div style="width:35%;float:right;margin-top:10px;color:#45c3d3;">
					<img src="<?php echo e(SITE_PATH); ?>/images/verified-pet.png" alt="<?php echo e(trans('words.verified_pet')); ?>" width="24">&nbsp;<?php echo e(trans('words.verified_pet')); ?>

					</div>
					<?php endif; ?>
				<?php	} else {	?>
					<h2 style="color:red;"><?php echo e(trans('words.id_not_found')); ?></h2>
                    <h6><?php echo e(trans('words.id_not_found_text')); ?></h6>
				<?php	}	?>
                </div>
            </div>
            <div class="row mt-3">
<?php	if(isset($petData) && isset($ownerData)) { ?>
		<?php	if(Auth::check()) {
					$user	= Auth::user();
				}
				if(isset($user) && $user->user_type != 1) { ?>
				<div class="col-md-12 set-sm-fit mb-4">
					<!-- preferences Wrap -->
					<div class="preferences">
						<div class="row">
							<div class="col-md-6">
								<div>
									<h4><?php echo e(trans('words.pet_data')); ?></h4>
								</div>
								<table class="table">
									<tbody>
										<tr class="table-light">
											<th><?php echo e(trans('words.name')); ?></th>
											<td><?php echo e($petData->name); ?></td>
										</tr>
										<tr class="table-light">
											<th><?php echo e(trans('words.species')); ?></th>
											<td><?php echo e($speciesArray[$petData->species]); ?></td>
										</tr>
										<?php if((Auth::user()->user_type == 2 && $petData->permission == 1) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<?php if($petData->color != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.color')); ?></th>
											<td><?php echo e($petData->color); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($petData->strain != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.strain')); ?></th>
											<td><?php echo e($petData->strain); ?></td>
										</tr>
										<?php endif; ?>
										<?php endif; ?>
										<?php if($petData->gender != 0): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.gender')); ?></th>
											<td><?php echo e($genderArray[$petData->gender]); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($petData->geld != 0): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.geld')); ?></th>
											<td><?php echo e($geldArray[$petData->geld]); ?></td>
										</tr>
										<?php endif; ?>
										<?php if((Auth::user()->user_type == 2 && $petData->permission == 1) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<?php if($petData->country_of_birth != 0): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.country_of_birth')); ?></th>
											<td><?php echo e($countries[$petData->country_of_birth]); ?></td>
										</tr>
										<?php endif; ?>
										<?php endif; ?>
										<?php if($petData->date_of_birth != '0000-00-00'): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.dob')); ?></th>
											<?php	$date	= date('m/d/Y', strtotime($petData->date_of_birth));	?>
											<td><?php echo e($date); ?></td>
										</tr>
										<?php endif; ?>
										<?php if((Auth::user()->user_type == 2 && $petData->permission == 1) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<?php if($petData->chip_id != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.chip_id')); ?></th>
											<td><?php echo e($petData->chip_id); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($petData->pass_id != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.pass_id')); ?></th>
											<td><?php echo e($petData->pass_id); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($petData->tattoo_id != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.tattoo_id')); ?></th>
											<td><?php echo e($petData->tattoo_id); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($petData->tattoo_location != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.tattoo_location')); ?></th>
											<td><?php echo e($petData->tattoo_location); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($petData->pet_id != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.pet_id')); ?></th>
											<td><?php echo e($petData->pet_id); ?></td>
										</tr>
										<?php endif; ?>
										<?php if($petData->characteristics != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.characteristics')); ?></th>
											<td><?php echo e($petData->characteristics); ?></td>
										</tr>
										<?php endif; ?>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
							<div class="col-md-6">
								<div>
									<h4><?php echo e(trans('words.owner_data')); ?></h4>
								</div>
								<table class="table">
									<tbody>
										
										<!--<tr class="table-light">
											<th><?php echo e(trans('words.name')); ?></th>
											<td><?php echo e($salutationArray[$ownerData->salutation]); ?> <?php echo e($ownerData->firstname); ?> <?php echo e($ownerData->lastname); ?></td>
										</tr>-->
										<?php if((Auth::user()->user_type == 2 && $ownerData->permission != 0) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.name')); ?></th>
											<td><?php echo e($salutationArray[$ownerData->salutation]); ?> <?php echo e($ownerData->firstname); ?> <?php echo e($ownerData->lastname); ?></td>
										</tr>
										<?php endif; ?>
										<?php if(Auth::user()->user_type == 2 && $ownerData->permission == 0): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.lastname')); ?></th>
											<td><?php echo e($ownerData->lastname); ?></td>
										</tr>
										<?php endif; ?>
										<?php if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.email')); ?></th>
											<td><?php echo e($ownerData->email); ?></td>
										</tr>
										<?php endif; ?>
										<?php if((Auth::user()->user_type == 2 && $ownerData->permission != 0) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.phone')); ?></th>
											<td><?php echo e($ownerData->phone); ?></td>
										</tr>
										<?php endif; ?>
										<?php if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.address')); ?></th>
											<td><?php echo e($ownerData->address); ?></td>
										</tr>
										<?php endif; ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.zip')); ?></th>
											<td><?php echo e($ownerData->zip); ?></td>
										</tr>
										<?php if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.city')); ?></th>
											<td><?php echo e($ownerData->city); ?></td>
										</tr>
										<tr class="table-light">
											<th><?php echo e(trans('words.state')); ?></th>
											<td><?php echo e($ownerData->state); ?></td>
										</tr>
										<?php endif; ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.country')); ?></th>
											<td><?php echo e($countries[$ownerData->country]); ?></td>
										</tr>
										<?php if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.language')); ?></th>
											<td><?php echo e($languages[$ownerData->language]); ?></td>
										</tr>
										<?php if($ownerData->company != ''): ?>
										<tr class="table-light">
											<th><?php echo e(trans('words.company')); ?></th>
											<td><?php echo e($ownerData->company); ?></td>
										</tr>
										<?php endif; ?>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
							
							<div class="col-md-12 mt-5">
								<div>
									<h4><?php echo e(trans('words.pet_notes')); ?></h4>
									<h6><?php echo e(trans('words.history')); ?></h6>
								</div>
								<table class="table mt-2">
									<tbody>
										<tr>
											<th><?php echo e(trans('words.date')); ?></th>
											<th><?php echo e(trans('words.author')); ?></th>
											<th><?php echo e(trans('words.message')); ?></th>
										</tr>
										<?php if(count($notes) > 0): ?>
											<?php foreach($notes as $key => $value): ?>
											<tr class="table-light">
												<td><?php echo date('m-d-Y', strtotime($value->created_at)); ?></td>
												<?php	$vetData	= User::find($value->vet_id); ?>
												<td><?php echo e($salutationArray[$vetData->salutation].'. '.$vetData->firstname.' '.$vetData->lastname); ?></td>
												<td><?php echo $value->notes ?></td>
											</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr class="table-light">
												<td colspan="3"><?php echo e(trans('words.no_notes_found')); ?></td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
								<?php echo Form::open(array('url' => 'search-result-authority-response', 'class' => 'row')); ?>

								<div class="preference-radio mt-5">
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
										<div class="col-lg-2"></div>
										<div class="col-md-12 col-lg-8">
											
											<input name="pet_id" type="hidden" id="pet_id" value="<?php echo e($petData->id); ?>">
											<p><?php echo e(trans('words.contact_form_text')); ?></p>
											<div id="search_resut_form_authority" style="display:none;"></div>
											<div id="authority_form">
											<div class="card-details mt-2">
												<?php echo e(Form::textarea('your_message', old('your_message'), array('id' => 'your_message', 'class' => 'card-number', 'placeholder' => '"'.trans("words.your_message").'"', 'rows' => '5'))); ?>

											</div>
											
											<div class="terms-reminder">
												<label class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" id="confirm" value="1" name="confirm">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description"><?php echo e(trans('words.contact_form_confirm_text')); ?></span>
												</label>
											</div>
											</div>
										</div>
									</div>
									
									<div class="row mt-2" id="authority_form2">
										<div class="col-md-4"></div>
										<div class="col-md-4">
											<button class="btn btn-block complete-booking" type="button" onclick="validateResultFormAuthority();"><?php echo e(trans('words.submit')); ?></button>
										</div>
									</div>
								</div>
								<?php echo Form::close(); ?>

							</div>
							<?php	} else {	?>
				<div class="col-md-2"></div>
                <div class="col-md-8 set-sm-fit mb-4">
					<!-- preferences Wrap -->
					<div class="preferences">
						<div class="row">
							<div class="col-md-12">
								<div>
									<h4><?php echo e(trans('words.pet_data')); ?></h4>
								</div>
								<table class="table">
									<tbody>
										<tr>
											<td><?php echo e(trans('words.home_country')); ?></td>
											<td><?php echo e($countries[$ownerData->country]); ?></td>
										</tr>
										<tr>
											<td><?php echo e(trans('words.home_city')); ?></td>
											<td><?php echo e($ownerData->city); ?></td>
										</tr>
										<tr>
											<td><?php echo e(trans('words.home_zip')); ?></td>
											<td><?php echo e($ownerData->zip); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<hr>
							<div class="col-md-12 mt-2">
								<div>
									<h4><?php echo e(trans('words.call_owner')); ?></h4>
								</div>
								<div><?php echo e(trans('words.for_calling_owner')); ?> <?php echo e($ownerData->phone); ?></div>
							</div>
							<div class="col-md-12 mt-5">
								<div>
									<h4><?php echo e(trans('words.send_message_to_ower')); ?></h4>
								</div>
								<div style="display:none;" id="search_resut_form"></div>
								<div class="preference-radio mt-3" id="search-result-form-div">						
								<?php echo e(Form::open(array('url' => 'search-result-response', 'class' => 'form-wrap mt-5', 'onsubmit' => 'return validateResultForm();'))); ?>

									<span><?php echo e(trans('words.all_fields_mandatory')); ?></span>
									<input type="hidden" name="pet_id" id="pet_id" value="<?php echo e($petData->id); ?>">
									<div class="row">
										<div class="col-md-6 mt-2">
											<div class="card-details">
												<input type="text" name="your_name" id="your_name" placeholder="<?php echo e(trans('words.your_name')); ?>" class="card-number">
											</div>
										</div>
										<div class="col-md-6 mt-2">
											<div class="card-details">
												<input type="email" name="your_email" id="your_email" placeholder="<?php echo e(trans('words.your_email')); ?>" class="card-number">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="card-details">
												<input type="text" placeholder="<?php echo e(trans('words.your_phone')); ?>" name="your_phone" id="your_phone" class="card-number">
											</div>
										</div>
										<div class="col-md-6">
											<div class="card-details">
												<input type="text" placeholder="<?php echo e(trans('words.location_of_pet_found')); ?>" name="location" id="location" class="card-number">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="card-details">
												<textarea placeholder="<?php echo e(trans('words.your_message')); ?>" class="card-number" name="your_message" id="your_message"></textarea>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-4"></div>
										<div class="col-md-4">
											<button class="btn btn-block complete-booking" type="button" onclick="validateResultForm();"><?php echo e(trans('words.submit')); ?></button>
										</div>
									</div>
								</div>
							</div>
							<?php	} ?>
						</div>
					<?php	} else {	?>
						<!-- <div class="row"> -->
							<div class="col-md-4"></div>
							<div class="col-md-6">
								<div>
									<h4>Extended Search</h4>
								</div>
								<table class="table">
									<thead>
										<tr>
											<th>Provider</th>
											<th>Status</th>
											<th>URL</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Tasso</td>
											<td>Found</td>
											<td>details</td>
										</tr>
										<tr>
											<td>IFTA</td>
											<td>Unknown</td>
											<td>details</td>
										</tr>
									</tbody>
								</table>
							</div>
						<!--</div>-->
					<?php	} ?>
					</div>
					<!--// preferences Wrap -->
                </div>
            </div>
        </div>
    </section>
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>