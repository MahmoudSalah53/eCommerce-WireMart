<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="Vendor">
	<meta name="keywords" content="Vendor, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>@yield('seller_page_title')</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

	<link href="{{asset('admin_asset/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	@livewireStyles
</head>

<style>
	.modal-overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 1000;

		opacity: 0;
		pointer-events: none;
		transition: opacity 0.3s ease;
	}

	.modal-overlay.show {
		opacity: 1;
		pointer-events: auto;
	}

	.modal-content {
		background-color: white;
		padding: 2rem;
		border-radius: 10px;
		text-align: center;
		min-width: 250px;
		position: relative;
		transform: scale(0.95);
		transition: transform 0.3s ease;
	}



	.modal-overlay.show .modal-content {
		transform: scale(1);
	}

	.delete-btn {
		background-color: #e3342f;
		color: white;
		padding: 0.5rem 1rem;
		border: none;
		border-radius: 5px;
		margin-right: 10px;
	}

	.close-btn {
		position: absolute;
		top: 10px;
		right: 15px;
		background: none;
		border: none;
		font-size: 1.5rem;
		color: #555;
		cursor: pointer;
	}

	.close-btn:hover {
		color: #000;
	}
</style>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{route('vendor')}}">
					<span class="align-middle">@lang('messages.sellerDash')</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						@lang('messages.main')
					</li>

					<li class="sidebar-item {{request()->routeIs('vendor') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('vendor')}}">
							<i class="align-middle" data-feather="list"></i> <span class="align-middle">@lang('messages.dashboard')</span>
						</a>
					</li>

					<li class="sidebar-item {{request()->routeIs('vendor.order.history') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('vendor.order.history')}}">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">@lang('messages.orderHistory')</span>
						</a>
					</li>

					<li class="sidebar-header">
						@lang('messages.store')
					</li>

					<li class="sidebar-item {{request()->routeIs('vendor.store') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('vendor.store')}}">
							<i class="align-middle" data-feather="plus"></i> <span class="align-middle">@lang('messages.create')</span>
						</a>
					</li>

					<li class="sidebar-item {{request()->routeIs('vendor.store.manage') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('vendor.store.manage')}}">
							<i class="align-middle" data-feather="list"></i> <span class="align-middle">@lang('messages.manage')</span>
						</a>
					</li>

					<li class="sidebar-header">
						@lang('messages.product')
					</li>

					<li class="sidebar-item {{request()->routeIs('vendor.product') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('vendor.product')}}">
							<i class="align-middle" data-feather="plus"></i> <span class="align-middle">@lang('messages.create')</span>
						</a>
					</li>

					<li class="sidebar-item {{request()->routeIs('vendor.product.manage') ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('vendor.product.manage')}}">
							<i class="align-middle" data-feather="list"></i> <span class="align-middle">@lang('messages.manage')</span>
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
								<a class="dropdown-item" href="{{route('vendor.profile')}}"><i class="align-middle me-1" data-feather="user"></i>@lang('messages.profile')</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i>@lang('messages.helpCenter')</a>
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
					@yield('seller_layout')

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