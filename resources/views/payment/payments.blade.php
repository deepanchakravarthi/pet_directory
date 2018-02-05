<?php	use App\User;
		$currentPlan	= '';
		$currentPlanCost= '';
		$isStripe		= 0; ?>
@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.payments') }}</h2>
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
														<table class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>																	
																	<th>{{ trans('words.veterinary') }}</th>
																	<th>{{ trans('words.status') }}</th>
																	<th>{{ trans('words.charge_id') }}</th>
																	<th>{{ trans('words.customer_id') }}</th>
																	<th>{{ trans('words.subscription_id') }}</th>
																	<th>{{ trans('words.amount') }}</th>
																	<th>{{ trans('words.date') }}</th>
																	
																</tr>
															</thead>
															<tbody>
															<?php	$inc	= 0;	?>
															@if(count($payments) > 0)
																@foreach($payments as $key => $value)
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
																	<th scope="row">{{ $inc+1 }}</th>
																	<td>{{ $vetname }}</td>
																	<td>
																	{{	$status }}
																	</td>
																	<td>{{ $value->charge_id }}</td>
																	<td>{{ $value->customer_id }}</td>
																	<td>{{ $value->subscription_id }}</td>
																	<td>{{ $value->amount }}</td>
																	<td>{{ date('m/d/Y', strtotime($value->created_at)) }}</td>
																	
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td colspan="8" style="text-align:center;">{{ trans('words.no_records_found') }}</td>
																</tr>
															@endif
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
@include('layouts.footer')