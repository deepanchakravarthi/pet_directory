<?php	use App\User;
		$currentPlan	= '';
		$currentPlanCost= '';
		$isStripe		= 0; ?>
@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.subscriptions') }}</h2>
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
												<!--<div class="col-md-2 col-sm-12">
												</div>-->
												@if(Auth::user()->user_type == 4)
													<!--<div class="col-md-2 col-sm-12">
													</div>-->
													<div class="col-md-12 col-sm-12">
												@else
												<div class="col-md-8 col-sm-12">
												@endif
													<div class="commentform">
														<table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																	<th>{{ trans('words.date') }}</th>
																	@if(Auth::user()->user_type == 4)
																	<th>{{ trans('words.user') }}</th>
																	<th>{{ trans('words.subscription_id') }}</th>
																	@endif
																	<th>{{ trans('words.description') }}</th>
																	<th>{{ trans('words.status') }}</th>
																	<th>{{ trans('words.lifetime') }}</th>
																	<th>{{ trans('words.cost') }}</th>
																	<th>{{ trans('words.method') }}</th>
																	<th>{{ trans('words.card_number') }}</th>
																	<th>{{ trans('words.mandate_url') }}</th>
																	@if(Auth::user()->user_type != 2)
																	<th>{{ trans('words.mandate_ref') }}</th>
																	@endif
																	@if(Auth::user()->user_type == 4)
																	<th>Action</th>
																	@endif
																</tr>
															</thead>
															<tbody>
															<?php	$inc	= 0;
																	$subscriptionCancel	= 0;	?>
															@if(count($subscriptions) > 0)
																@foreach($subscriptions as $key => $value)
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';
																		if($value->status == 1) {
																			$currentPlan	= $planArray[$value->plan_id];
																			//$currentPlanCost= ($value->plan_id == 1) ? SITE_PLAN_COST : trans('words.free');
																			$isStripe		= $value->is_stripe;
																			$subscriptionCancel	= $value->cancel_status;
																		}	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row">{{ $inc+1 }}</th>
																	<td>{{ date('m/d/Y', strtotime($value->created_at)) }}</td>
																	@if(Auth::user()->user_type == 4)
																	<td><a href="{{ SITE_PATH }}/view-user/{{ $value->vet_id }}" title="{{ trans('words.view_vet') }}">
																		<?php	$subUser	= User::find($value->vet_id);
																				echo $subUser->firstname.' '.$subUser->lastname;
																				if(in_array(Auth::user()->country, $euCountries)) {
																					$curr	= 'EUR';
																				} else {
																					$curr	= 'USD';
																				}
																				?></a></td>
																	<td>{{ $value->subscription_id }}</td>
																	@endif
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
																	@if($value->plan_id == 3)
																	<td>{{ $planArray[$value->plan_id] }} - {{ $value->voucher }}</td>
																	@else
																	<td>{{ $planArray[$value->plan_id] }}</td>
																	@endif
																	
															<?php	if($value->payment_status == 0) { ?>
																	<td>{{ trans('words.pending') }}</td>
																	<td></td>
															<?php	} else if($value->payment_status == 2) { ?>
																	<td>{{ trans('words.failure') }}</td>
																	<td></td>
															<?php	} else {	?>
																	<td>{{ trans('words.success') }}</td>
																	<td>{{ date('m-d-Y', strtotime($value->start_date)).' - '.date('m-d-Y', strtotime($value->end_date))}}
																	</td>
															<?php	}	?>
																	<td>
																	@if($value->plan_id == 1)
																	{{ SITE_PLAN_COST }} {{ $value->currency }}
																	@else
																	{{ trans('words.free') }}
																	@endif
																	</td>
																	<td><?php	if($value->method == 1) { echo trans('words.credit_card'); } else { echo trans('words.sepa_direct_debit'); } ?></td>
																	<td><?php	echo $value->last4; ?></td>
																	<td><?php	if($value->method == 2) { echo '<a target="_blank" href="'.$value->mandate_url.'">Link</a>'; } ?></td>
																	@if(Auth::user()->user_type != 2)
																	<td><?php	if($value->method == 2) { echo $value->mandate_reference; } ?></td>
																	@endif
																	@if(Auth::user()->user_type == 4)
																		<td>	
																		<?php	if($value->cancel_status == 0 && $value->status == 1 && $value->payment_status == 1) {	?>
																		<a href="{{ SITE_PATH }}/cancel-subscription/{{ $value->id }}">{{ trans('words.cancel') }} {{ trans('words.subscription') }}</a>
																		<?php	} else { 
																					echo trans('words.cancel'); 
																				}	?>
																		</td>
																	@endif
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td 
																	@if(Auth::user()->user_type == 4)
																		colspan="13"
																	@else
																		colspan="10"
																	@endif
																	style="text-align:center;">{{ trans('words.no_records_found') }}</td>
																</tr>
															@endif
														  </tbody>
														</table>
													</div>
												</div>
												@if(Auth::user()->user_type != 4)
												<div class="col-md-4 col-sm-12">
													<div class="row">
														<div class="col-md-4 col-sm-12" >
															
														</div>
														<?php	if($inc > 0 && $currentPlan != '') {	// Have records & valid subscription ?>
														<div class="col-md-12 col-sm-12" >
															{{ trans('words.current_plan') }}: <span style="color:#0069D9;font-weight:bold;">{{ $currentPlan }}</span><br>
															{{ trans('words.plan_cost') }}: <span style="color:#0069D9;font-weight:bold;">{{ $currentPlanCost }}</span>
														</div>
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-primary btn-fullwidth mt-3" onclick="location.href='{{ SITE_PATH }}/change-subscription';" value="{{ trans('words.change_subscription') }}">
														</div>
														@if($isStripe && $subscriptionCancel != 0)
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-primary btn-fullwidth mt-3" onclick="location.href='{{ SITE_PATH }}/change-payment-details';"  value="{{ trans('words.change_payment_details') }}">
														</div>
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-secondary btn-fullwidth mt-3" onclick="location.href='{{ SITE_PATH }}/cancel-subscription/{{ $value->id }}';"  value="{{ trans('words.cancel') }} {{ trans('words.subscription') }}">
														</div>
														@endif
														<?php	} else if($inc > 0 && $currentPlan == '' || $inc == 0) { //	Have records and no valid subscription	?>
														<div class="col-md-12 col-sm-12">
															<input type="button" class="btn btn-primary btn-fullwidth mt-3" onclick="location.href='{{ SITE_PATH }}/change-subscription';" value="{{ trans('words.change_subscription') }}">
														</div>
														<?php	} ?>
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