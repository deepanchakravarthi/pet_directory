<?php	use App\User;
		$userArray	= Auth::user();	?>
@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.users') }}</h2>
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
												<div class="col-md-2 col-sm-12">
												</div>
												<div class="col-md-8 col-sm-12">
													<div class="commentform">
														<div class="row">
															<div class="col-md-12 col-sm-12" >
																@if($userArray->user_type == 4)
																<input type="button" value="{{ trans('words.create_new_user') }}" onclick="location.href='{{ SITE_PATH }}/create-user';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																<input type="button" value="{{ trans('words.create_vet') }}" onclick="location.href='{{ SITE_PATH }}/create-vet';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																<input type="button" value="{{ trans('words.create_auth') }}" onclick="location.href='{{ SITE_PATH }}/create-authority';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																<input type="button" value="{{ trans('words.create_admin') }}" onclick="location.href='{{ SITE_PATH }}/create-admin';" class="btn btn-outline-primary width-100" style="margin-bottom:10px;margin-right:20px;"/>
																@endif
															</div>
														</div>
														@if($userArray->user_type != 4)
														<table class="mt-3 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																	<th>{{ trans('words.firstname') }}</th>
																	<th>{{ trans('words.lastname') }}</th>
																	<th>{{ trans('words.city') }}</th>
																	<th>{{ trans('words.zip') }}</th>
																	<th>{{ trans('words.actions') }}</th>
																</tr>
															</thead>
															<tbody>
															@if(count($users) > 0)
																<?php	$inc	= 0;	?>
																@foreach($users as $key => $value)
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row">{{ $inc+1 }}</th>
																	
																	<td>{{ $value->firstname }}</td>
																	<td>{{ $value->lastname }}</td>
																	<td>{{ $value->city }}</td>
																	<td>{{ $value->zip }}</td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="{{ trans('words.view_user') }}" onclick="location.href='{{ SITE_PATH }}/view-user/{{ $value->id }}';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		@if($userArray->user_type == 4)
																		<button type="button"  onclick="location.href='{{ SITE_PATH }}/edit-user/{{ $value->id }}'" title="{{ trans('words.edit_user') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		@endif
																	</td>
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td 
																	@if($userArray->user_type == 4)
																		colspan="7" 
																	@else
																		colspan="6" 
																	@endif
																	style="text-align:center;">{{ trans('words.no_user_found') }}</td>
																</tr>
															@endif
														  </tbody>
														</table>
														@else
														<h4>{{ trans('words.owner') }} {{ trans('words.list') }}</h4>
														<table class="mt-3 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable">
															<thead>
																<tr>
																	<th>#</th>
																	
																	<th>{{ trans('words.firstname') }}</th>
																	<th>{{ trans('words.lastname') }}</th>
																	<th>{{ trans('words.city') }}</th>
																	<th>{{ trans('words.zip') }}</th>
																	<th>{{ trans('words.actions') }}</th>
																</tr>
															</thead>
															<tbody>
															@if(count($users) > 0)
																<?php	$inc	= 0;	?>
																@foreach($users as $key => $value)
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row">{{ $inc+1 }}</th>
																	
																	<td>{{ $value->firstname }}</td>
																	<td>{{ $value->lastname }}</td>
																	<td>{{ $value->city }}</td>
																	<td>{{ $value->zip }}</td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="{{ trans('words.view_user') }}" onclick="location.href='{{ SITE_PATH }}/view-user/{{ $value->id }}';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		@if($userArray->user_type == 4)
																		<button type="button"  onclick="location.href='{{ SITE_PATH }}/edit-user/{{ $value->id }}'" title="{{ trans('words.edit_user') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		@endif
																	</td>
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td 
																	@if($userArray->user_type == 4)
																		colspan="7" 
																	@else
																		colspan="6" 
																	@endif
																	style="text-align:center;">{{ trans('words.no_user_found') }}</td>
																</tr>
															@endif
														  </tbody>
														</table>
														<h4 class="mt-5">{{ trans('words.veterinary') }} {{ trans('words.list') }}</h4>
														<table class="mt-5 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable2">
															<thead>
																<tr>
																	<th>#</th>
																	<th>{{ trans('words.firstname') }}</th>
																	<th>{{ trans('words.lastname') }}</th>
																	<th>{{ trans('words.city') }}</th>
																	<th>{{ trans('words.zip') }}</th>
																	<th>{{ trans('words.actions') }}</th>
																</tr>
															</thead>
															<tbody>
															@if(count($vet) > 0)
																<?php	$inc	= 0;	?>
																@foreach($vet as $key => $value)
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row">{{ $inc+1 }}</th>
																	
																	<td>{{ $value->firstname }}</td>
																	<td>{{ $value->lastname }}</td>
																	<td>{{ $value->city }}</td>
																	<td>{{ $value->zip }}</td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="{{ trans('words.view_user') }}" onclick="location.href='{{ SITE_PATH }}/view-user/{{ $value->id }}';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		@if($userArray->user_type == 4)
																		<button type="button"  onclick="location.href='{{ SITE_PATH }}/edit-vet/{{ $value->id }}'" title="{{ trans('words.edit_user') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		@endif
																	</td>
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td 
																	@if($userArray->user_type == 4)
																		colspan="7" 
																	@else
																		colspan="6" 
																	@endif
																	style="text-align:center;">{{ trans('words.no_user_found') }}</td>
																</tr>
															@endif
														  </tbody>
														</table>
														<h5 class="mt-5">{{ trans('words.authority') }} {{ trans('words.list') }}</h5>
														<table class="mt-5 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable3">
															<thead>
																<tr>
																	<th>#</th>
																	
																	<th>{{ trans('words.firstname') }}</th>
																	<th>{{ trans('words.lastname') }}</th>
																	<th>{{ trans('words.city') }}</th>
																	<th>{{ trans('words.zip') }}</th>
																	<th>{{ trans('words.actions') }}</th>
																</tr>
															</thead>
															<tbody>
															@if(count($authority) > 0)
																<?php	$inc	= 0;	?>
																@foreach($authority as $key => $value)
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row">{{ $inc+1 }}</th>
																	
																	<td>{{ $value->firstname }}</td>
																	<td>{{ $value->lastname }}</td>
																	<td>{{ $value->city }}</td>
																	<td>{{ $value->zip }}</td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="{{ trans('words.view_user') }}" onclick="location.href='{{ SITE_PATH }}/view-user/{{ $value->id }}';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		@if($userArray->user_type == 4)
																		<button type="button"  onclick="location.href='{{ SITE_PATH }}/edit-authority/{{ $value->id }}'" title="{{ trans('words.edit_user') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		@endif
																	</td>
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td 
																	@if($userArray->user_type == 4)
																		colspan="7" 
																	@else
																		colspan="6" 
																	@endif
																	style="text-align:center;">{{ trans('words.no_user_found') }}</td>
																</tr>
															@endif
														  </tbody>
														</table>
														<h4 class="mt-5">{{ trans('words.admin') }} {{ trans('words.list') }}</h4>
														<table class="mt-5 table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" id="datatable1">
															<thead>
																<tr>
																	<th>#</th>
																	<th>{{ trans('words.firstname') }}</th>
																	<th>{{ trans('words.lastname') }}</th>
																	<th>{{ trans('words.city') }}</th>
																	<th>{{ trans('words.zip') }}</th>
																	<th>{{ trans('words.actions') }}</th>
																</tr>
															</thead>
															<tbody>
															@if(count($admins) > 0)
																<?php	$inc	= 0;	?>
																@foreach($admins as $key => $value)
																<?php	$class	= ($inc%2!=0) ? '' : 'table-light';	?>
																<tr class="<?php echo $class;	?>">
																	<th scope="row">{{ $inc+1 }}</th>
																	
																	<td>{{ $value->firstname }}</td>
																	<td>{{ $value->lastname }}</td>
																	<td>{{ $value->city }}</td>
																	<td>{{ $value->zip }}</td>
																	<td>
																		<!-- Button trigger modal -->
																		<button type="button"  title="{{ trans('words.view_user') }}" onclick="location.href='{{ SITE_PATH }}/view-user/{{ $value->id }}';"><i class="fa fa-eye" aria-hidden="true"></i></button>
																		@if($userArray->user_type == 4)
																		<button type="button"  onclick="location.href='{{ SITE_PATH }}/edit-admin/{{ $value->id }}'" title="{{ trans('words.edit_user') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
																		@endif
																	</td>
																</tr>
																<?php	$inc++;	?>
															@endforeach
															@else
																<tr class="table-primary">
																	<td 
																	@if($userArray->user_type == 4)
																		colspan="7" 
																	@else
																		colspan="6" 
																	@endif
																	style="text-align:center;">{{ trans('words.no_user_found') }}</td>
																</tr>
															@endif
														  </tbody>
														</table>
														@endif
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