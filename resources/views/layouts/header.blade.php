<!-- Stored in resources/views/layouts/header.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ SITE_NAME }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ SITE_PATH }}/css/bootstrap.min.css?v=2">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ SITE_PATH }}/css/font-awesome.min.css?v=2">
    <!-- Simple Line Font -->
    <link rel="stylesheet" href="{{ SITE_PATH }}/css/pe-icon-7-stroke.css?v=2">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css">
	
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ SITE_PATH }}/css/style.css?v=3">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="{{ SITE_PATH }}/css/jquery.timepicker.css" />
</head>

<body>
    <!--============================= HEADER =============================-->
    <div class="container">
		<div class="dropdown" style="margin-right:20px;text-align:right;">
			<button class="btn dropdown-toggle" style="background:transparent;font-size:13px;padding:0;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			{{ trans('words.header_language') }}
			</button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="{{ SITE_PATH }}/index/en">{{ trans('words.header_english') }}</a>
				<a class="dropdown-item" href="{{ SITE_PATH }}/index/fr">{{ trans('words.header_french') }}</a>
				<a class="dropdown-item" href="{{ SITE_PATH }}/index/de">{{ trans('words.header_german') }}</a>
				<a class="dropdown-item" href="{{ SITE_PATH }}/index/it">{{ trans('words.header_italian') }}</a>
			  </div>
		</div>
	</div>
	<header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="{{ SITE_PATH }}"><img src="{{ SITE_PATH }}/images/petlogo.png" alt="{{ SITE_NAME }}"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                            <ul class="navbar-nav">

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ SITE_PATH }}">{{ trans('words.header_search') }}</a>
                                </li>
                                <li class="nav-item 
									@if(strpos($_SERVER['REQUEST_URI'], 'aboutus') !== false)
										active
									@endif
									">
                                    <a class="nav-link" href="{{ SITE_PATH }}/aboutus">{{ trans('words.header_aboutus') }}</a>
                                </li>
								<li class="nav-item 
									@if(strpos($_SERVER['REQUEST_URI'], 'contact') !== false)
										active
									@endif
									">
                                    <a class="nav-link" href="{{ SITE_PATH }}/contact">{{ trans('words.header_contact') }}</a>
                                </li>
								<li class="nav-item 
									@if(strpos($_SERVER['REQUEST_URI'], 'imprint') !== false)
										active
									@endif
									">
                                    <a class="nav-link" href="{{ SITE_PATH }}/imprint">{{ trans('words.header_imprint') }}</a>
                                </li>
								@if (Auth::check())
								<li class="nav-item">
									<div class="dropdown">
										<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											{{ trans('words.header_myaccount') }}
										  </button>
										  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="{{ SITE_PATH }}/my-profile">{{ trans('words.header_myprofile') }}</a>
											<?php	$user	= Auth::user();
													if($user->user_type == 1) { ?>
											<a class="dropdown-item" href="{{ SITE_PATH }}/my-pets">{{ trans('words.header_mypets') }}</a>
											<?php	}
													if($user->user_type == 2) { ?>
											<a class="dropdown-item" href="{{ SITE_PATH }}/users">{{ trans('words.header_customers') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/my-pets">{{ trans('words.header_pets') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/subscription">{{ trans('words.header_subscription') }}</a>
											<?php	}
													if($user->user_type == 4) { ?>
											<a class="dropdown-item" href="{{ SITE_PATH }}/users">{{ trans('words.header_users') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/my-pets">{{ trans('words.header_pets') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/subscription">{{ trans('words.header_subscriptions') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/payments">{{ trans('words.header_payments') }}</a>
											
											<?php	}	?>
											<a class="dropdown-item" href="{{ SITE_PATH }}/logout">{{ trans('words.header_logout') }}</a>
										  </div>
									</div>
								</li>
								@else
								<li class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
									<a href="{{ SITE_PATH }}/login" class="btn btn-info" style="padding:9px 18px;margin-right:5px;">{{ trans('words.header_login') }}</a>
								</li>
								<li>
									<a href="{{ SITE_PATH }}/login" class="btn btn-info d-block d-sm-block d-md-block d-lg-none d-xl-none" style="padding:9px 18px;float:left;">{{ trans('words.header_login') }}</a>
									<a href="{{ SITE_PATH }}/where-are-you" class="btn btn-info" style="padding:9px 18px;">{{ trans('words.header_register') }}</a>
								</li>
								@endif
								<li class="nav-item" style="display:none;">
									<div class="dropdown">
										<button class="btn dropdown-toggle" style="background:transparent" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ trans('words.header_language') }}
										  </button>
										  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="{{ SITE_PATH }}/index/en">{{ trans('words.header_english') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/index/fr">{{ trans('words.header_french') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/index/de">{{ trans('words.header_german') }}</a>
											<a class="dropdown-item" href="{{ SITE_PATH }}/index/it">{{ trans('words.header_italian') }}</a>
										  </div>
									</div>
								</li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!--//END HEADER -->