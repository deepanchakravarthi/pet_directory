@include('layouts.header')
    <section class="howit-work main-block center-block" id="howitworks" style="background:#f9f9f9">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('words.where_are_you') }}</h2>
                    <h6>{{ trans('words.where_are_you_text') }}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="howit-wrap">
                        <a href="{{ SITE_PATH }}/register?user_type=owner">
							<i class="fa fa-user-circle-o fa-4" style="color:#45C3D3;font-size: 7em;"></i>
						</a>
						<h4 onclick="location.href='{{ SITE_PATH }}/register?user_type=owner';">{{ trans('words.pet_owner') }}</h4>
						
                        <p>{{ trans('words.pet_owner_text') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="howit-wrap">
                        <a href="{{ SITE_PATH }}/register?user_type=vet">
							<i class="fa fa-medkit fa-4" style="color:#45C3D3;font-size: 7em;"></i>	
						</a>
						<h4 onclick="location.href='{{ SITE_PATH }}/register?user_type=vet';">{{ trans('words.veterinary') }}</h4>
						
                        <p>{{ trans('words.veterinary_text') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="howit-wrap">
						<a href="{{ SITE_PATH }}/register?user_type=authority">
							<i class="fa fa-university fa-4" style="color:#45C3D3;font-size: 7em;"></i>
						</a>
						<h4 onclick="location.href='{{ SITE_PATH }}/register?user_type=authority';">{{ trans('words.authority_dept') }}</h4>
						
                        <p>{{ trans('words.authority_dept_text') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//END HOW IT WORK -->
@include('layouts.footer')