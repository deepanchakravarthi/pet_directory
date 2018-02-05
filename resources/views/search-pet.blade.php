<?php	use App\User; ?>
@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.search_result') }}</h2>
				</div>
			</div>
		</div>
	</section>
    <section class="booking-details center-block main-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				<?php	if(isset($petData) && isset($ownerData)) { ?>
                    <h2>{{ trans('words.id_found') }}</h2>
                    <h6>{{ trans('words.id_found_text') }}</h6>
					@if($petData->vet_id != 0)
					<div style="width:35%;float:right;margin-top:10px;color:#45c3d3;">
					<img src="{{ SITE_PATH }}/images/verified-pet.png" alt="{{ trans('words.verified_pet') }}" width="24">&nbsp;{{ trans('words.verified_pet') }}
					</div>
					@endif
				<?php	} else {	?>
					<h2 style="color:red;">{{ trans('words.id_not_found') }}</h2>
                    <h6>{{ trans('words.id_not_found_text') }}</h6>
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
									<h4>{{ trans('words.pet_data') }}</h4>
								</div>
								<table class="table">
									<tbody>
										<tr class="table-light">
											<th>{{ trans('words.name') }}</th>
											<td>{{ $petData->name }}</td>
										</tr>
										<tr class="table-light">
											<th>{{ trans('words.species') }}</th>
											<td>{{ $speciesArray[$petData->species] }}</td>
										</tr>
										@if((Auth::user()->user_type == 2 && $petData->permission == 1) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										@if($petData->color != '')
										<tr class="table-light">
											<th>{{ trans('words.color') }}</th>
											<td>{{ $petData->color }}</td>
										</tr>
										@endif
										@if($petData->strain != '')
										<tr class="table-light">
											<th>{{ trans('words.strain') }}</th>
											<td>{{ $petData->strain }}</td>
										</tr>
										@endif
										@endif
										@if($petData->gender != 0)
										<tr class="table-light">
											<th>{{ trans('words.gender') }}</th>
											<td>{{ $genderArray[$petData->gender] }}</td>
										</tr>
										@endif
										@if($petData->geld != 0)
										<tr class="table-light">
											<th>{{ trans('words.geld') }}</th>
											<td>{{ $geldArray[$petData->geld] }}</td>
										</tr>
										@endif
										@if((Auth::user()->user_type == 2 && $petData->permission == 1) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										@if($petData->country_of_birth != 0)
										<tr class="table-light">
											<th>{{ trans('words.country_of_birth') }}</th>
											<td>{{ $pet_countries[$petData->country_of_birth] }}</td>
										</tr>
										@endif
										@endif
										@if($petData->date_of_birth != '0000-00-00')
										<tr class="table-light">
											<th>{{ trans('words.dob') }}</th>
											<?php	$date	= date('m/d/Y', strtotime($petData->date_of_birth));	?>
											<td>{{ $date }}</td>
										</tr>
										@endif
										@if((Auth::user()->user_type == 2 && $petData->permission == 1) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										@if($petData->chip_id != '')
										<tr class="table-light">
											<th>{{ trans('words.chip_id') }}</th>
											<td>{{ $petData->chip_id }}</td>
										</tr>
										@endif
										@if($petData->pass_id != '')
										<tr class="table-light">
											<th>{{ trans('words.pass_id') }}</th>
											<td>{{ $petData->pass_id }}</td>
										</tr>
										@endif
										@if($petData->tattoo_id != '')
										<tr class="table-light">
											<th>{{ trans('words.tattoo_id') }}</th>
											<td>{{ $petData->tattoo_id }}</td>
										</tr>
										@endif
										@if($petData->tattoo_location != '')
										<tr class="table-light">
											<th>{{ trans('words.tattoo_location') }}</th>
											<td>{{ $petData->tattoo_location }}</td>
										</tr>
										@endif
										@if($petData->pet_id != '')
										<tr class="table-light">
											<th>{{ trans('words.pet_id') }}</th>
											<td>{{ $petData->pet_id }}</td>
										</tr>
										@endif
										@if($petData->characteristics != '')
										<tr class="table-light">
											<th>{{ trans('words.characteristics') }}</th>
											<td>{{ $petData->characteristics }}</td>
										</tr>
										@endif
										@endif
									</tbody>
								</table>
							</div>
							<div class="col-md-6">
								<div>
									<h4>{{ trans('words.owner_data') }}</h4>
								</div>
								<table class="table">
									<tbody>
										
										<!--<tr class="table-light">
											<th>{{ trans('words.name') }}</th>
											<td>{{ $salutationArray[$ownerData->salutation] }} {{ $ownerData->firstname }} {{ $ownerData->lastname }}</td>
										</tr>-->
										@if((Auth::user()->user_type == 2 && $ownerData->permission != 0) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										<tr class="table-light">
											<th>{{ trans('words.name') }}</th>
											<td>{{ $salutationArray[$ownerData->salutation] }} {{ $ownerData->firstname }} {{ $ownerData->lastname }}</td>
										</tr>
										@endif
										@if(Auth::user()->user_type == 2 && $ownerData->permission == 0)
										<tr class="table-light">
											<th>{{ trans('words.lastname') }}</th>
											<td>{{ $ownerData->lastname }}</td>
										</tr>
										@endif
										@if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										<tr class="table-light">
											<th>{{ trans('words.email') }}</th>
											<td>{{ $ownerData->email }}</td>
										</tr>
										@endif
										@if((Auth::user()->user_type == 2 && $ownerData->permission != 0) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										<tr class="table-light">
											<th>{{ trans('words.phone') }}</th>
											<td>{{ $ownerData->phone }}</td>
										</tr>
										@endif
										@if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										<tr class="table-light">
											<th>{{ trans('words.address') }}</th>
											<td>{{ $ownerData->address }}</td>
										</tr>
										@endif
										<tr class="table-light">
											<th>{{ trans('words.zip') }}</th>
											<td>{{ $ownerData->zip }}</td>
										</tr>
										@if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										<tr class="table-light">
											<th>{{ trans('words.city') }}</th>
											<td>{{ $ownerData->city }}</td>
										</tr>
										<tr class="table-light">
											<th>{{ trans('words.state') }}</th>
											<td>{{ $ownerData->state }}</td>
										</tr>
										@endif
										<tr class="table-light">
											<th>{{ trans('words.country') }}</th>
											<td>{{ $countries[$ownerData->country] }}</td>
										</tr>
										@if((Auth::user()->user_type == 2 && ($ownerData->permission == 2)) || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
										<tr class="table-light">
											<th>{{ trans('words.language') }}</th>
											<td>{{ $languages[$ownerData->language] }}</td>
										</tr>
										@if($ownerData->company != '')
										<tr class="table-light">
											<th>{{ trans('words.company') }}</th>
											<td>{{ $ownerData->company }}</td>
										</tr>
										@endif
										@endif
									</tbody>
								</table>
							</div>
							
							<div class="col-md-12 mt-5">
								<div>
									<h4>{{ trans('words.pet_notes') }}</h4>
									<h6>{{ trans('words.history') }}</h6>
								</div>
								<table class="table mt-2">
									<tbody>
										<tr>
											<th>{{ trans('words.date') }}</th>
											<th>{{ trans('words.author') }}</th>
											<th>{{ trans('words.message') }}</th>
										</tr>
										@if(count($notes) > 0)
											@foreach($notes as $key => $value)
											<tr class="table-light">
												<td><?php echo date('m-d-Y', strtotime($value->created_at)); ?></td>
												<?php	$vetData	= User::find($value->vet_id); ?>
												<td>{{ $salutationArray[$vetData->salutation].'. '.$vetData->firstname.' '.$vetData->lastname }}</td>
												<td><?php echo $value->notes ?></td>
											</tr>
											@endforeach
										@else
											<tr class="table-light">
												<td colspan="3">{{ trans('words.no_notes_found') }}</td>
											</tr>
										@endif
									</tbody>
								</table>
								{!! Form::open(array('url' => 'search-result-authority-response', 'class' => 'row')) !!}
								<div class="preference-radio mt-5">
									<div class="row">
									@if(count($errors->all()) > 0)
										<div class="col-md-12 col-sm-12">
										@foreach( $errors->all() as $message )
											<div class="alert alert-danger" role="alert">
												{{ $message }}
											</div>
										@endforeach
										</div>
									@endif
									@if(Session::has('message'))
										<div class="col-md-12 col-sm-12">
											<div class="alert alert-success" role="alert">
												{{ Session::get('message') }}
											</div>
										</div>
									@endif
									</div>
									<div class="row">
										<div class="col-lg-2"></div>
										<div class="col-md-12 col-lg-8">
											
											<input name="pet_id" type="hidden" id="pet_id" value="{{ $petData->id }}">
											<p>{{ trans('words.contact_form_text') }}</p>
											<div id="search_resut_form_authority" style="display:none;"></div>
											<div id="authority_form">
											<div class="card-details mt-2">
												{{ Form::textarea('your_message', old('your_message'), array('id' => 'your_message', 'class' => 'card-number', 'placeholder' => '"'.trans("words.your_message").'"', 'rows' => '5')) }}
											</div>
											
											<div class="terms-reminder">
												<label class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" id="confirm" value="1" name="confirm">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description">{{ trans('words.contact_form_confirm_text') }}</span>
												</label>
											</div>
											</div>
										</div>
									</div>
									
									<div class="row mt-2" id="authority_form2">
										<div class="col-md-4"></div>
										<div class="col-md-4">
											<button class="btn btn-block complete-booking" type="button" onclick="validateResultFormAuthority();">{{ trans('words.submit') }}</button>
										</div>
									</div>
								</div>
								{!! Form::close() !!}
							</div>
							<?php	} else {	?>
				<div class="col-md-2"></div>
                <div class="col-md-8 set-sm-fit mb-4">
					<!-- preferences Wrap -->
					<div class="preferences">
						<div class="row">
							<div class="col-md-12">
								<div>
									<h4>{{ trans('words.pet_data') }}</h4>
								</div>
								<table class="table">
									<tbody>
										<tr>
											<td>{{ trans('words.home_country') }}</td>
											<td>{{ $countries[$ownerData->country] }}</td>
										</tr>
										<tr>
											<td>{{ trans('words.home_city') }}</td>
											<td>{{ $ownerData->city }}</td>
										</tr>
										<tr>
											<td>{{ trans('words.home_zip') }}</td>
											<td>{{ $ownerData->zip }}</td>
										</tr>
									</tbody>
								</table>
							</div>
							<hr>
							<div class="col-md-12 mt-2">
								<div>
									<h4>{{ trans('words.call_owner') }}</h4>
								</div>
								<div>{{ trans('words.for_calling_owner') }} {{ $ownerData->phone }}</div>
							</div>
							<div class="col-md-12 mt-5">
								<div>
									<h4>{{ trans('words.send_message_to_ower') }}</h4>
								</div>
								<div style="display:none;" id="search_resut_form"></div>
								<div class="preference-radio mt-3" id="search-result-form-div">						
								{{ Form::open(array('url' => 'search-result-response', 'class' => 'form-wrap mt-5', 'onsubmit' => 'return validateResultForm();')) }}
									<span>{{ trans('words.all_fields_mandatory') }}</span>
									<input type="hidden" name="pet_id" id="pet_id" value="{{ $petData->id }}">
									<div class="row">
										<div class="col-md-6 mt-2">
											<div class="card-details">
												<input type="text" name="your_name" id="your_name" placeholder="{{ trans('words.your_name') }}" class="card-number">
											</div>
										</div>
										<div class="col-md-6 mt-2">
											<div class="card-details">
												<input type="email" name="your_email" id="your_email" placeholder="{{ trans('words.your_email') }}" class="card-number">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="card-details">
												<input type="text" placeholder="{{ trans('words.your_phone') }}" name="your_phone" id="your_phone" class="card-number">
											</div>
										</div>
										<div class="col-md-6">
											<div class="card-details">
												<input type="text" placeholder="{{ trans('words.location_of_pet_found') }}" name="location" id="location" class="card-number">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="card-details">
												<textarea placeholder="{{ trans('words.your_message') }}" class="card-number" name="your_message" id="your_message"></textarea>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-4"></div>
										<div class="col-md-4">
											<button class="btn btn-block complete-booking" type="button" onclick="validateResultForm();">{{ trans('words.submit') }}</button>
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
@include('layouts.footer')