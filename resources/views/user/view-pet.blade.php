<?php	use App\User;	?>
@include('layouts.header')
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.view_pet') }}</h2>
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
												@if($pet->vet_id != 0)
												<div style="float:right;margin-bottom:10px;color:#45c3d3;">
												<img src="{{ SITE_PATH }}/images/verified-pet.png" alt="{{ trans('words.verified_pet') }}" width="24">&nbsp;{{ trans('words.verified_pet') }}
												</div>
												@endif
												<table class="table">
													<tbody>
														<tr class="table-light">
															<th>{{ trans('words.name') }}</th>
															<td>{{ $pet->name }}</td>
														</tr>
														<tr class="table-light">
															<th>{{ trans('words.species') }}</th>
															<td>{{ $speciesArray[$pet->species] }}</td>
														</tr>
														@if($pet->color != '')
														<tr class="table-light">
															<th>{{ trans('words.color') }}</th>
															<td>{{ $pet->color }}</td>
														</tr>
														@endif
														@if($pet->strain != '')
														<tr class="table-light">
															<th>{{ trans('words.strain') }}</th>
															<td>{{ $pet->strain }}</td>
														</tr>
														@endif
														@if($pet->gender != 0)
														<tr class="table-light">
															<th>{{ trans('words.gender') }}</th>
															<td>{{ $genderArray[$pet->gender] }}</td>
														</tr>
														@endif
														@if($pet->geld != 0)
														<tr class="table-light">
															<th>{{ trans('words.geld') }}</th>
															<td>{{ $geldArray[$pet->geld] }}</td>
														</tr>
														@endif
														@if($pet->country_of_birth != 0)
														<tr class="table-light">
															<th>{{ trans('words.country_of_birth') }}</th>
															<td>{{ $pet_countries[$pet->country_of_birth] }}</td>
														</tr>
														@endif
														@if($pet->date_of_birth != '0000-00-00')
														<tr class="table-light">
															<th>{{ trans('words.date_of_birth') }}</th>
															<?php	$date	= date('m/d/Y', strtotime($pet->date_of_birth));	?>
															<td>{{ $date }}</td>
														</tr>
														@endif
														@if($pet->chip_id != '')
														<tr class="table-light">
															<th>{{ trans('words.chip_id') }}</th>
															<td>{{ $pet->chip_id }}</td>
														</tr>
														@endif
														@if($pet->pass_id != '')
														<tr class="table-light">
															<th>{{ trans('words.pass_id') }}</th>
															<td>{{ $pet->pass_id }}</td>
														</tr>
														@endif
														@if($pet->tattoo_id != '')
														<tr class="table-light">
															<th>{{ trans('words.tattoo_id') }}</th>
															<td>{{ $pet->tattoo_id }}</td>
														</tr>
														@endif
														@if($pet->tattoo_location != '')
														<tr class="table-light">
															<th>{{ trans('words.tattoo_location') }}</th>
															<td>{{ $pet->tattoo_location }}</td>
														</tr>
														@endif
														@if($pet->pet_id != '')
														<tr class="table-light">
															<th>{{ trans('words.pet_id') }}</th>
															<td>{{ $pet->pet_id }}</td>
														</tr>
														@endif
														@if($pet->characteristics != '')
														<tr class="table-light">
															<th>{{ trans('words.characteristics') }}</th>
															<td>{{ $pet->characteristics }}</td>
														</tr>
														@endif
													</tbody>
												</table>
												<h5>{{ trans('words.notes_history') }}</h5>
												<table class="table">
													<tbody>
														<tr class="table-light">
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
												<div class="commentform">
													<div class="row ">
														<div class="col-md-6 col-sm-12 center-alignment mt-3">
															<input type="button" onclick="location.href='{{ SITE_PATH }}/edit-pet/{{ $pet->id }}';" value="{{ trans('words.edit_data') }}" class="btn btn-outline-primary btn-fullwidth width-100" />
														</div>
														<div class="col-md-6 col-sm-12 center-alignment mt-3">
															<input type="button" onclick="location.href='{{ SITE_PATH }}/my-pets';" value="{{ trans('words.back_to_mypets') }}" class="btn btn-outline-secondary btn-fullwidth width-100" />
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
@include('layouts.footer')