<?php	use App\User;
		use App\Subscription;	?>
@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				@if(Auth::user()->user_type == 4 && Auth::user()->id != $user->id)
                    <h2>{{ trans('words.view_user') }}</h2>
				@else
					<h2>{{ trans('words.my_profile') }}</h2>
				@endif
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
												@if(Auth::user()->user_type != 4)
													<div class="col-md-3 col-sm-12">
													</div>
													<div class="col-md-6 col-sm-12">
												@endif
												@if(Auth::user()->user_type == 4)
													@if($user->user_type != 2)
														<div class="col-md-3 col-sm-12">
														</div>
														<div class="col-md-6 col-sm-12">
													@else
														<div class="col-md-6 col-sm-12">
													@endif
													
													<h5>{{ trans('words.profile_data') }}</h5>
												@endif
														<div class="commentform">
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
															@if(isset($offers) && count($offers) > 0)
																@foreach($offers as $key => $value)
															<div class="alert alert-primary" role="alert">
															<?php	$owner	= User::find($value->user_id); ?>
																@if($user->user_type == 2)
																<strong>{{ trans('words.received_request') }}</strong> {{ $owner->firstname.' '.$owner->lastname }} {{ trans('words.received_offer_message') }} <button class="btn btn-outline-primary" onclick="location.href='{{ SITE_PATH }}/pet/accept-offer/{{ $value->id }}';">{{ trans('words.accept_request') }}</button>
																@else
																<strong>{{ trans('words.received_offer') }}</strong> {{ $owner->firstname.' '.$owner->lastname }} {{ trans('words.received_request_message') }} <button class="btn btn-outline-primary" onclick="location.href='{{ SITE_PATH }}/pet/accept-offer/{{ $value->id }}';">{{ trans('words.accept_offer') }}</button>
																@endif
															</div>
																@endforeach
															@endif
															</div>
															<div class="row">
																<div class="col-md-12 col-sm-12 left-alignment mt-3">
																	<table class="table">
																		<tbody>
																			<tr class="table-light">
																				<th>{{ trans('words.name') }}</th>
																				<td>{{ $salutationArray[$user->salutation] }}. {{ $user->firstname }} {{ $user->lastname }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.user_type') }}</th>
																				@if($user->user_type == 4)
																				<td>{{ trans('words.admin') }}</td>
																				@else
																				<td>{{ $userTypes[$user->user_type] }}</td>
																				@endif
																			</tr>
																			@if($user->user_type == 2)
																			@if($user->company != '')
																			<tr class="table-light">
																				<th>{{ trans('words.company') }}</th>
																				<td>{{ $user->company }}</td>
																			</tr>
																			@endif
																			<tr class="table-light">
																				<th>{{ trans('words.register_number') }}</th>
																				<td>{{ $user->register_number }}</td>
																			</tr>
																			@endif
																			<tr class="table-light">
																				<th>{{ trans('words.email') }}</th>
																				<td>{{ $user->email }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.phone') }}</th>
																				<td>{{ $user->phone }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.address') }}</th>
																				<td>{{ $user->address }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.zip') }}</th>
																				<td>{{ $user->zip }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.city') }}</th>
																				<td>{{ $user->city }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.state') }}</th>
																				<td>{{ $user->state }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.country') }}</th>
																				<td>{{ $countries[$user->country] }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.language') }}</th>
																				<td>{{ $languages[$user->language] }}</td>
																			</tr>
																			@if($user->user_type == 1)
																			@if($user->company != '')
																			<tr class="table-light">
																				<th>{{ trans('words.company') }}</th>
																				<td>{{ $user->company }}</td>
																			</tr>
																			@endif
																			@endif
																			@if(Auth::user()->user_type == 1 || Auth::user()->user_type == 4)
																			<tr class="table-light">
																				<th>{{ trans('words.permission') }}</th>
																				<td>{{ $ownerPermissionArray[$user->permission] }}</td>
																			</tr>
																			@endif
																			@if($user->user_type == 3)
																			<tr class="table-light">
																				<th>{{ trans('words.authority_name') }}</th>
																				<td>{{ $user->authority_name }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.supervisor_name') }}</th>
																				<td>{{ $user->supervisor_name }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.supervisor_email') }}</th>
																				<td>{{ $user->supervisor_email }}</td>
																			</tr>
																			<tr class="table-light">
																				<th>{{ trans('words.supervisor_phone') }}</th>
																				<td>{{ $user->supervisor_phone }}</td>
																			</tr>
																			@endif
																			
																			@if(Auth::user()->user_type == 4 && Auth::user()->id != $user->id)
																			<tr class="table-light">
																				<th>{{ trans('words.status') }}</th>
																				<td><?php	echo ($user->status == 0) ? trans('words.active') : trans('words.inactive'); ?></td>
																			</tr>
																			@endif
																		</tbody>
																	</table>
																</div>
															</div>
															<div class="row mt-3">
																<div class="col-md-6 col-sm-6 center-alignment ">
																	@if(Auth::user()->user_type == 4 && Auth::user()->id != $user->id)
																		<?php	if($user->user_type == 1) {
																					$editUrl	= 'user';
																				} else if($user->user_type == 2) {
																					$editUrl	= 'vet';
																				} else if($user->user_type == 3) {
																					$editUrl	= 'authority';
																				} else if($user->user_type == 4) {
																					$editUrl	= 'admin';
																				} ?>
																		<input onclick='location.href="{{ SITE_PATH }}/edit-{{ $editUrl }}/{{ $user->id }}"'; type="button"  value="{{ trans('words.edit_profile') }}" class="btn btn-outline-primary btn-fullwidth width-100" />
																	@elseif(Auth::user()->id != $user->id)
																		<input onclick='location.href="{{ SITE_PATH }}/edit-user/{{ $user->id }}"'; type="button"  value="{{ trans('words.edit_profile') }}" class="btn btn-outline-primary btn-fullwidth width-100" />
																	@else
																		<input onclick='location.href="{{ SITE_PATH }}/edit-profile"'; type="button"  value="{{ trans('words.edit_profile') }}" class="btn btn-outline-primary btn-fullwidth width-100" />
																	@endif
																</div>
																<div class="col-md-6 col-sm-6 center-alignment ">
																	<input action="action" onclick="window.history.go(-1); return false;" type="button" value="{{ trans('words.back') }}"  class="btn btn-outline-secondary btn-fullwidth width-100"/>
																</div>
															</div>
															
														</div>
													</div>
													@if(Auth::user()->user_type == 4 && $user->user_type == 2)
													<div class="col-md-6 col-sm-12">
														<h5>{{ trans('words.subscription') }}</h5>
														<table class="table">
															<thead>
																<tr>
																	<th>#</th>
																	<th>{{ trans('words.date') }}</th>
																	<th>{{ trans('words.description') }}</th>
																	<th>{{ trans('words.lifetime') }}</th>
																	<th>{{ trans('words.price') }}</th>
																</tr>
															</thead>
															<tbody>
															<?php	$subscriptions	= Subscription::where('vet_id', '=', $user->id)->get();
																	$inc	= 0;	?>
															@if(count($subscriptions) > 0)
																@foreach($subscriptions as $key => $value)
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
																	<th scope="row">{{ $inc+1 }}</th>
																	<td>{{ date('m/d/Y', strtotime($value->created_at)) }}</td>
																	@if($value->plan_id == 3)
																	<td>{{ $planArray[$value->plan_id] }} - {{ $value->voucher }}</td>
																	@else
																	<td>{{ $planArray[$value->plan_id] }}</td>
																	@endif
																	<td>{{ date('m-d-Y', strtotime($value->start_date)).' - '.date('m-d-Y', strtotime($value->end_date))}}
																	</td>
																	<td>
																	@if($value->plan_id == 1)
																	{{ SITE_PLAN_COST }}
																	@else
																	{{ trans('words.free') }}
																	@endif
																	</td>
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td colspan="5" style="text-align:center;">{{ trans('words.no_records_found') }}</td>
																</tr>
															@endif
														  </tbody>
														</table>
														
														<!-- Subscription pack assignment -->
														<h5>{{ trans('words.assign_subscription') }}</h5>
														<div class="commentform">
															{!! Form::open(array('url' => 'assign-subscription', 'class' => 'row')) !!}
															<div class="mt-2">
															{{ Form::hidden('vet_id', $user->id) }}
															{{ trans('words.plan') }}: {{ Form::select('plan', $planArray, old('plan'), array('id' => 'plan', 'class' => 'form-control', 'onchange' => 'checkPlan();')) }}
															<div>
															<div class="mt-2" id="voucher_term_div" style="display:none;">
															{{ trans('words.voucher_term') }}: 
															<input type="text" id="voucher_term" name="voucher_term" class = 'form-control' style="display:none;" placeholder="3 months"> 
															</div>
															<div class="mt-2">
															<input type="submit" value="Subscribe" class="btn btn-primary">
															<div>
															<div class="mt-3">
															{{ trans('words.note_assign_subscription') }}
															</div>
															{!! Form::close() !!}
														</div>
													</div>
													@endif
												
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