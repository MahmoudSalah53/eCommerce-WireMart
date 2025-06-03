<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>@yield('admin_page_title')</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

	<link href="{{asset('admin_asset/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	@livewireStyles
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{route('admin')}}">
					<span class="align-middle">@lang('messages.adminDash')</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						@lang('messages.main')
					</li>

					<li class="sidebar-item {{request()->routeIs('admin') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('admin')}}">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">@lang('messages.dashboard')</span>
						</a>
					</li>

					<li class="sidebar-header">
						@lang('messages.category')
					</li>

					<li class="sidebar-item {{request()->routeIs('category.create') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('category.create')}}">
							<i class="align-middle" data-feather="plus"></i> <span class="align-middle">@lang('messages.create')</span>
						</a>
					</li>

					<li class="sidebar-item {{request()->routeIs('category.manage') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('category.manage')}}">
							<i class="align-middle" data-feather="list"></i> <span class="align-middle">@lang('messages.manage')</span>
						</a>
					</li>

					<li class="sidebar-header">
						@lang('messages.subCategory')
					</li>

					<li class="sidebar-item {{request()->routeIs('subcategory.create') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('subcategory.create')}}">
							<i class="align-middle" data-feather="plus"></i> <span class="align-middle">@lang('messages.create')</span>
						</a>
					</li>

					<li class="sidebar-item {{request()->routeIs('subcategory.manage') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('subcategory.manage')}}">
							<i class="align-middle" data-feather="list"></i> <span class="align-middle">@lang('messages.manage')</span>
						</a>
					</li>

					<li class="sidebar-header">
						@lang('messages.management')
					</li>

					<li class="sidebar-item {{request()->routeIs('product.manage') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('product.manage')}}">
							<i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">@lang('messages.manageProducts')</span>
						</a>
					</li>

					<li class="sidebar-item {{request()->routeIs('user.manage') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('user.manage')}}">
							<i class="align-middle" data-feather="users"></i> <span class="align-middle">@lang('messages.manageUsers')</span>
						</a>
					</li>

					<li class="sidebar-header">
						@lang('messages.history')
					</li>

					<li class="sidebar-item {{request()->routeIs('admin.order.history') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('admin.order.history')}}">
							<i class="align-middle" data-feather="list"></i> <span class="align-middle">@lang('messages.orders')</span>
						</a>
					</li>

					<li class="sidebar-item {{request()->routeIs('admin.settings') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('admin.settings')}}">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">@lang('messages.settings')</span>
						</a>
					</li>

				</ul>

				
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<a href="{{ url('/') }}" class="btn btn-primary btn-sm ms-3">
					@lang('messages.homePage')
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
								<img
									src="{{ $user->images->first() ? asset('storage/' . $user->images->first()->img_path) : asset('assets/img/default-avatar.png') }}"
									class="rounded-circle me-2"
									style="width: 40px; height: 40px; object-fit: cover;"
									alt="{{ $user->name }}" />
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="{{route('admin.profile')}}"><i class="align-middle me-1" data-feather="user"></i>@lang('messages.profile')</a>
								<div class="dropdown-divider"></div>
								<form action="{{route('logout')}}" method="POST">
									@csrf
									<input type="submit" value="@lang('messages.logout')" class="dropdown-item">
								</form>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">
					@yield('admin_layout')

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="#">@lang('messages.support')</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="#">@lang('messages.helpCenter')</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="#">@lang('messages.privacy')</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="#">@lang('messages.term')</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="{{asset('admin_asset/js/app.js')}}"></script>
	@livewireScripts
</body>

</html>