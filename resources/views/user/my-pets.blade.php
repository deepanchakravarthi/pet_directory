<?php	use App\User;
		$userArray	= Auth::user();	?>
@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.my_pets') }}</h2>
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
													@if(Session::has('message'))
													<div class="alert alert-success" role="alert">
														{{ Session::get('message') }}
													</div>
													@endif
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-12 col-sm-12">
													<div class="commentform">
														@if(count($offers) > 0)
															@foreach($offers as $key => $value)
														<div class="alert alert-primary" role="alert">
														<?php	$owner	= User::find($value->user_id); ?>
															@if($userArray->user_type == 2)
															<strong>{{ trans('words.received_request') }}</strong> {{ $owner->firstname.' '.$owner->lastname }} {{ trans('words.received_offer_message') }} <button class="btn btn-outline-primary" onclick="location.href='{{ SITE_PATH }}/pet/accept-offer/{{ $value->id }}';">{{ trans('words.accept_request') }}</button>
															@else
															<strong>{{ trans('words.received_offer') }}</strong> {{ $owner->firstname.' '.$owner->lastname }} {{ trans('words.received_request_message') }} <button class="btn btn-outline-primary" onclick="location.href='{{ SITE_PATH }}/pet/accept-offer/{{ $value->id }}';">{{ trans('words.accept_offer') }}</button>
															@endif
														</div>
															@endforeach
														@endif
														
														<div class="row">
															<div class="col-md-12 col-sm-12" >
																<input type="button" value="{{ trans('words.create_new_pet') }}" onclick="location.href='{{ SITE_PATH }}/create-pet';" class="btn btn-outline-primary width-100" style="float:right;margin-bottom:10px;margin-right:20px;" />
															</div>
														</div>
														<div class="table-responsive">
														<table class="table table-striped table-hover responsive" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																@if($userArray->user_type == 2 || $userArray->user_type == 4)
																	<th>{{ trans('words.country') }}</th>
																@endif
																	<th>{{ trans('words.species') }}</th>
																	<th>{{ trans('words.name') }}</th>
																	<th>{{ trans('words.age') }}</th>
																@if($userArray->user_type == 2 || $userArray->user_type == 4)
																	<th>{{ trans('words.chip_id') }}</th>
																	<th>{{ trans('words.pet_id') }}</th>
																	<th>{{ trans('words.tag_id') }}</th>
																	<th>{{ trans('words.tattoo_id') }}</th>
																@endif
																@if($userArray->user_type == 2 || $userArray->user_type == 4)
																<th>{{ trans('words.owner') }}</th>
																@endif
																@if($userArray->user_type == 1 || $userArray->user_type == 4)
																	<th>{{ trans('words.veterinary') }}</th>
																@endif
																	<th>{{ trans('words.actions') }}</th>
																</tr>
															</thead>
															<tbody>
															@if(count($pets) > 0)
																<?php	$inc	= 0;	?>
																@foreach($pets as $key => $value)
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
																	<td scope="row">{{ $inc+1 }}</td>
																@if($userArray->user_type == 2 || $userArray->user_type == 4)
																<?php	$ownerData	= User::find($value->owner_id);	?>
																	<td>{{ $countries[$ownerData->country] }}</td>
																@endif
																	<td>{{ $speciesArray[$value->species] }}</td>
																	<td>{{ $value->name }}</td>
																	<td>{{ $age }}</td>
																	@if($value->date_of_death == '0000-00-00')
																		
																	@if($userArray->user_type != 2)
																	<!-- Modal -->
																	<div class="modal" id="removeModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel">{{ trans('words.move_pet_to_another_account') }}</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<h5>{{ trans('words.move_to_other_account') }}</h5>
																					<p style="display:none;text-align:center;" id="confirm_offer_error_message_{{ $value->id }}_1"></p>
																					<div id="confirm_offer_form_{{ $value->id }}_1">
																						<form method="post" action="">
																						<div class="card-details">
																							<label>{{ trans('words.new_owner_mail') }} <span class="required">*</span></label>
																							<input type="text" name="email" id="new_owner_email_{{ $value->id }}_1" class="form-control">
																						</div>
																						<div class="card-details">
																							<input type="button" value="{{ trans('words.send_offer') }}" onclick="confirmOffer({{ $value->id }}, 1);"  class="btn btn-outline-primary">
																						</div>
																						</form>
																					</div>
																					<h5 clas="mt-3">{{ trans('words.set_pet_as_dead') }}</h5>
																					<p style="display:none;text-align:center;" id="confirm_death_error_message_{{ $value->id }}"></p>
																					<div id="confirm_death_form_{{ $value->id }}">
																						<form method="post" action="">
																							<div class="card-details">
																								<label>{{ trans('words.day_of_death') }} <span class="required">*</span></label>
																								<input type="text" name="email" id="date_of_death_{{ $value->id }}" class="form-control datepicker">
																							</div>
																							<div class="card-details">
																								<label>{{ trans('words.cause_of_death') }} <span class="required">*</span></label>
																								<input type="text" name="cause" id="cause_of_death_{{ $value->id }}" class="form-control">
																							</div>
																							<div class="card-details">
																								<input type="button" value="{{ trans('words.set_as_dead') }}" onclick="confirmDeath({{ $value->id }});" class="btn btn-outline-primary">
																							</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	@endif
																	
																	<!-- Modal 2 -->
																	<div class="modal" id="searchModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel">{{ trans('words.set_as_lost') }}</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<h6>{{ trans('words.lost_header') }}</h6>
																					<p style="display:none;text-align:center;" id="confirm_lost_error_message_{{ $value->id }}"></p>
																					<div id="confirm_lost_form_{{ $value->id }}">
																						<form method="post" action="">
																							<div class="card-details">
																								<label>{{ trans('words.location') }} <span class="required">*</span></label>
																								<input type="text" name="lost_location" id="lost_location_{{ $value->id }}" class="form-control">
																							</div>
																							<div id="map"></div>
																							<div class="card-details">
																								<label>{{ trans('words.lost_date') }} <span class="required">*</span></label>
																								<input type="text" name="lost_date" id="lost_date_{{ $value->id }}" class="form-control datepicker">
																							</div>
																							<div class="card-details">
																								<label>{{ trans('words.lost_time') }} <span class="required">*</span></label>
																								<input type="text" name="lost_time" id="lost_time_{{ $value->id }}" class="form-control timepicker">
																							</div>
																							<div class="card-details">
																								<input type="button" value="{{ trans('words.set_lost_download_poster') }}" onclick="confirmLost({{ $value->id }});" class="btn btn-outline-primary">
																							</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	
																	<!-- Modal 3 -->
																	<div class="modal" id="foundModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel">{{ trans('words.pet_found') }}</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<form method="post" action="">
																						<p style="display:none;text-align:center;" id="confirm_found_error_message_{{ $value->id }}"></p>
																						<div class="card-details" id="confirm_found_form_{{ $value->id }}">
																							<input type="button" value="{{ trans('words.confirm_found') }}" onclick="confirmFound({{ $value->id }});" class="btn btn-outline-primary">
																							&nbsp;
																							<input onclick="location.href='{{ SITE_PATH }}/create-poster/{{ $value->id }}';" type="button" value="{{ trans('words.not_found') }}" class="btn btn-outline-primary">
																						</div>
																					</form>
																				</div>
																			</div>
																		</div>
																	</div>
																	
																	<!-- Modal 4 -->
																	<div class="modal" id="noteModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel">{{ trans('words.add_note') }}</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<p style="display:none;text-align:center;" id="add_note_error_message_{{ $value->id }}"></p>
																					<div id="add_note_form_{{ $value->id }}">
																						<form method="post" action="">
																							<div class="card-details">
																								<label>{{ trans('words.note') }} <span class="required">*</span></label>
																								<input type="text" name="notes" id="notes_{{ $value->id }}" class="form-control">
																							</div>
																							<div class="card-details">
																								<input type="button" value="{{ trans('words.save') }}" onclick="confirmAddNote({{ $value->id }});" class="btn btn-outline-primary">
																							</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<!-- Modal 5-->
																	@if(($userArray->user_type == 2 && $value->vet_id == $value->owner_id) || ($userArray->user_type == 4 && $value->owner_id == $userArray->id))
																	<div class="modal" id="assignModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel">{{ trans('words.assign_pet_to_owner') }}</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<p style="display:none;text-align:center;" id="confirm_offer_error_message_{{ $value->id }}_2"></p>
																					<div id="assign_offer_form_{{ $value->id }}_2">
																						<form method="post" action="">
																						<div class="card-details">
																							<label>{{ trans('words.owner_email') }} <span class="required">*</span></label>
																							<input type="text" name="email" id="new_owner_email_{{ $value->id }}_2" class="form-control">
																						</div>
																						<div class="card-details">
																							<input type="button" value="{{ trans('words.send_request') }}" onclick="confirmOffer({{ $value->id }}, 2);"  class="btn btn-outline-primary">
																						</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	@endif
																	<!-- Modal 6-->
																	@if(($userArray->user_type == 1 || $userArray->user_type == 4) && $value->vet_id == 0)
																	<div class="modal" id="assignVetModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel">{{ trans('words.assign_pet_to_vet') }}</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">×</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<p style="display:none;text-align:center;" id="confirm_vet_offer_error_message_{{ $value->id }}"></p>
																					<div id="confirm_vet_offer_form_{{ $value->id }}">
																						<form method="post" action="">
																						<div class="card-details">
																							<label>{{ trans('words.vet_email') }} <span class="required">*</span></label>
																							<input type="text" name="email" id="vet_email_{{ $value->id }}" class="form-control">
																						</div>
																						<div class="card-details">
																							<input type="button" value="{{ trans('words.send_request') }}" onclick="confirmVetOffer({{ $value->id }});"  class="btn btn-outline-primary">
																						</div>
																						</form>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	@endif
																	
																	@endif
																@if($userArray->user_type == 2 || $userArray->user_type == 4)
																	<td>{{ $value->chip_id }}</td>
																	<td>{{ $value->pet_id }}</td>
																	<td>{{ $value->tag_id }}</td>
																	<td>{{ $value->tattoo_id }}</td>
																	@if($userArray->user_type == 2 || $userArray->user_type == 4)
																	<?php	$ownerData	= User::find($value->owner_id);	?>
																	<td>{{ $ownerData->firstname.' '.$ownerData->lastname }}</td>
																	@endif
																@endif
																@if($userArray->user_type == 1 || $userArray->user_type == 4)
																	<?php	$vetData	= User::find($value->vet_id);	
																			if($vetData) { ?>
																	<td>{{ $vetData->firstname.' '.$vetData->lastname }}</td>
																	<?php	} else { ?>
																	<td></td>
																	<?php	} ?>
																@endif
																	<td>
																		@if($value->date_of_death == '0000-00-00')
																		
																		<!-- Button trigger modal -->
																		<button type="button"  title="{{ trans('words.view_data') }}" onclick="location.href='{{ SITE_PATH }}/view-pet/{{ $value->id }}';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																																				
																		<button type="button"  onclick="location.href='{{ SITE_PATH }}/edit-pet/{{ $value->id }}'" title="{{ trans('words.edit_data') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		
																		@if($userArray->user_type != 2)
																		<button type="button"  data-toggle="modal" data-target="#removeModal{{ $value->id }}" title="{{ trans('words.remove_data') }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
																		@endif
																		
																		@if($value->lost_date != '0000-00-00')
																		<button type="button"  data-toggle="modal" data-target="#foundModal{{ $value->id }}" title="{{ trans('words.found') }}"><i class="fa fa-search" aria-hidden="true"></i></button>
																		@else
																		<button type="button"  data-toggle="modal" data-target="#searchModal{{ $value->id }}" title="{{ trans('words.lost') }}"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
																		@endif
																		
																		@if($userArray->user_type == 2)
																		<button type="button"  data-toggle="modal" data-target="#noteModal{{ $value->id }}" title="{{ trans('words.note_data') }}"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></button>
																		@if($value->vet_id == $value->owner_id)
																		<button type="button"  data-toggle="modal" data-target="#assignModal{{ $value->id }}" title="{{ trans('words.assign_owner') }}"><i class="fa fa-user" aria-hidden="true"></i></button>
																		@endif
																		@endif
																		
																		@if($userArray->user_type == 4 && $value->owner_id == $userArray->id)
																		<button type="button"  data-toggle="modal" data-target="#assignModal{{ $value->id }}" title="{{ trans('words.assign_owner') }}"><i class="fa fa-user" aria-hidden="true"></i></button>
																		@endif
																		
																		@if(($userArray->user_type == 1 || $userArray->user_type == 4) && $value->vet_id == 0)
																		<button type="button"  data-toggle="modal" data-target="#assignVetModal{{ $value->id }}" title="{{ trans('words.assign_vet') }}"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
																		@endif
																		
																		@endif
																	</td>
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td 
																	@if($userArray->user_type == 4)
																		colspan="12"
																	@elseif($userArray->user_type == 1)
																		colspan="5"
																	@elseif($userArray->user_type == 2)
																		colspan="11"
																	@endif
																	style="text-align:center;">{{ trans('words.no_pets_found') }}</td>
																</tr>
															@endif
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
@include('layouts.footer')