<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Dashboard | JSOFT Themes | JSOFT-Admin</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
		<meta name="author" content="JSOFT.net">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}" />
		<link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/datepicker3.css') }}" />

		<!-- Specific Page Vendor CSS -->
        @yield('vendorstyle')

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ asset('css/octopus/theme.css') }}" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="{{ asset('css/octopus/skins/default.css') }}" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ asset('css/octopus/theme-custom.css') }}">
		
		<!-- Page specific CSS -->
		@yield('pagestyle')

		<!-- Head Libs -->
		<script src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="{{ asset('images/octopus/logo.png') }}" height="35" alt="JSOFT Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="{{ asset('images/octopus/!logged-user.jpg') }}" alt="Joseph Doe" class="img-circle" data-lock-picture="{{ asset('images/octopus/!logged-user.jpg') }}" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
								<span class="name">{{ Auth::user()->name }}</span>
								<span class="role">{{ implode(', ', Auth::user()->roles->pluck('name')->toArray()) }}</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
								{!! Form::open(['id' => 'logoutForm', 'method' => 'POST', 'route' => 'logout']) !!}
									<a id="logoutBtn" role="menuitem" tabindex="-1" href="#"><i class="fa fa-power-off"></i> Logout</a>
								{!! Form::close() !!}
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="{{ route('dashboard') }}">
											<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
                                    </li>
                                    @role('Superuser')
									<li class="nav-parent">
										<a>
											<i class="fa fa-users" aria-hidden="true"></i>
											<span>User Management</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="{{ route('users.index') }}">
													 Manage Users
												</a>
											</li>
											<li>
												<a href="{{ route('roles.index') }}">
													 Manage Roles
												</a>
											</li>
										</ul>
                                    </li>
                                    @endrole
									<li class="nav-parent">
										<a>
											<i class="fa fa-dropbox" aria-hidden="true"></i>
											<span>Importasi</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="{{ route('impor.index') }}">
													 Daftar Impor
												</a>
											</li>
										</ul>
									</li>
									@can('covid-list')
									<li class="nav-parent">
										<a>
											<i class="fa fa-file-text" aria-hidden="true"></i>
											<span>Dokumen</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="{{ route('covid.index') }}">
													 Aju Covid Baru
												</a>
											</li>
											<li>
												<a href="{{ route('covid.all') }}">
													 Semua Aju Covid
												</a>
											</li>
										</ul>
									</li>
									@endcan
								</ul>
							</nav>
						</div>
				
					</div>
				
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
                        <h2>Dashboard</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								@yield('breadcrumbs')
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
                    @yield('content')
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
								<ul>
									<li>
										<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="{{ asset('images/octopus/!sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="{{ asset('images/octopus/!sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="{{ asset('images/octopus/!sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="{{ asset('images/octopus/!sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
			
						</div>
					</div>
				</div>
			</aside>
		</section>

		<!-- Vendor -->
		<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
		<script src="{{ asset('vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
		<script src="{{ asset('vendor/bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('vendor/nanoscroller/nanoscroller.js') }}"></script>
		<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
		<script src="{{ asset('vendor/magnific-popup/magnific-popup.js') }}"></script>
		<script src="{{ asset('vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
		
		<!-- Specific Page Vendor -->
		@yield('vendorscript')

		<!-- Theme Base, Components and Settings -->
		<script src="{{ asset('js/octopus/theme.js') }}"></script>
		
		<!-- Theme Custom -->
		<script src="{{ asset('js/octopus/theme.custom.js') }}"></script>
		
		<!-- Theme Initialization Files -->
		<script src="{{ asset('js/octopus/theme.init.js') }}"></script>
		
		<!-- Page specific -->
		<script>
			$('#logoutBtn').on('click', function(e) {
				e.preventDefault();
				$('#logoutForm').submit();
			});
		</script>
		@yield('pagescript')

	</body>
</html>