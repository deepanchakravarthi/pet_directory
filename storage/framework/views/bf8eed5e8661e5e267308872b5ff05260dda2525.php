<?php	use App\User;	?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.view_pet')); ?></h2>
				</div>
			</div>
		</div>
	</section>
	<section class="testimonial main-block center-block">
		<div class="container sitecontainer bgw">
            <div class="row">
                <div class="col-md-12 m22 single-post">
                    <div class="widget">
                        <div class="large-widget ">
                            <div class="post-desc">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="appoform-wrapper">
											<div class="row">
											<div class="col-md-2 col-sm-12"></div>
											<div class="col-md-8 col-sm-12">
												<?php if($pet->vet_id != 0): ?>
												<div style="float:right;margin-bottom:10px;color:#45c3d3;">
												<img src="<?php echo e(SITE_PATH); ?>/images/verified-pet.png" alt="<?php echo e(trans('words.verified_pet')); ?>" width="24">&nbsp;<?php echo e(trans('words.verified_pet')); ?>

												</div>
												<?php endif; ?>
												<table class="table">
													<tbody>
														<tr class="table-light">
															<th><?php echo e(trans('words.name')); ?></th>
															<td><?php echo e($pet->name); ?></td>
														</tr>
														<tr class="table-light">
															<th><?php echo e(trans('words.species')); ?></th>
															<td><?php echo e($speciesArray[$pet->species]); ?></td>
														</tr>
														<?php if($pet->color != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.color')); ?></th>
															<td><?php echo e($pet->color); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->strain != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.strain')); ?></th>
															<td><?php echo e($pet->strain); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->gender != 0): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.gender')); ?></th>
															<td><?php echo e($genderArray[$pet->gender]); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->geld != 0): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.geld')); ?></th>
															<td><?php echo e($geldArray[$pet->geld]); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->country_of_birth != 0): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.country_of_birth')); ?></th>
															<td><?php echo e($countries[$pet->country_of_birth]); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->date_of_birth != '0000-00-00'): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.date_of_birth')); ?></th>
															<?php	$date	= date('m/d/Y', strtotime($pet->date_of_birth));	?>
															<td><?php echo e($date); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->chip_id != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.chip_id')); ?></th>
															<td><?php echo e($pet->chip_id); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->pass_id != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.pass_id')); ?></th>
															<td><?php echo e($pet->pass_id); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->tattoo_id != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.tattoo_id')); ?></th>
															<td><?php echo e($pet->tattoo_id); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->tattoo_location != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.tattoo_location')); ?></th>
															<td><?php echo e($pet->tattoo_location); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->pet_id != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.pet_id')); ?></th>
															<td><?php echo e($pet->pet_id); ?></td>
														</tr>
														<?php endif; ?>
														<?php if($pet->characteristics != ''): ?>
														<tr class="table-light">
															<th><?php echo e(trans('words.characteristics')); ?></th>
															<td><?php echo e($pet->characteristics); ?></td>
														</tr>
														<?php endif; ?>
													</tbody>
												</table>
												<h5><?php echo e(trans('words.notes_history')); ?></h5>
												<table class="table">
													<tbody>
														<tr class="table-light">
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
												<div class="commentform">
													<div class="row ">
														<div class="col-md-6 col-sm-12 center-alignment mt-3">
															<input type="button" onclick="location.href='<?php echo e(SITE_PATH); ?>/edit-pet/<?php echo e($pet->id); ?>';" value="<?php echo e(trans('words.edit_data')); ?>" class="btn btn-outline-primary btn-fullwidth width-100" />
														</div>
														<div class="col-md-6 col-sm-12 center-alignment mt-3">
															<input type="button" onclick="location.href='<?php echo e(SITE_PATH); ?>/my-pets';" value="<?php echo e(trans('words.back_to_mypets')); ?>" class="btn btn-outline-secondary btn-fullwidth width-100" />
														</div>
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