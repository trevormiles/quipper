<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'Quipper')</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" rel="stylesheet"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
	<link rel="stylesheet" type="text/css" href="/css/app.css">
	<link rel="stylesheet" type="text/css" href="/css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="/css/awesomplete.css">
	<link rel="icon" href="/img/quipper-favicon-fitted.png" type="image/x-icon"/>
</head>
<body>

	
	<div id="page-container">
	
		<div class="navbar">

			<div class="navbar__left">
				<div class="navbar__logo">
					<a href="/">
						<img src="/svg/quipper-white.svg" class="navbar__logo__image">
					</a>
				</div>

				<div class="navbar__navigation">
					<ul class="nav">

						<?php 
							$rentalsVariable = DB::table('menu_items')->where('name', '=', 'Rentals')->get();
							$rentalsVariable = json_decode(json_encode($rentalsVariable), true);
							$rentalsVariable = $rentalsVariable[0]["selected"];

							$bookingVariable = DB::table('menu_items')->where('name', '=', 'Booking')->get();
							$bookingVariable = json_decode(json_encode($bookingVariable), true);
							$bookingVariable = $bookingVariable[0]["selected"];

							$salesVariable = DB::table('menu_items')->where('name', '=', 'Sales')->get();
							$salesVariable = json_decode(json_encode($salesVariable), true);
							$salesVariable = $salesVariable[0]["selected"];
						?>

						<?php if ($rentalsVariable == "true") : ?>
							@if(View::hasSection('main-nav-1-title'))
								<li id="nav-link-rentals" class="nav-item">
									<a class="@yield('main-nav-active-1') nav-link" href="@yield('main-nav-1-location')">@yield('main-nav-1-title')</a>
								</li>
							@endif
						<?php endif; ?>
						
						<?php if ($bookingVariable == "true") : ?>
							@if(View::hasSection('main-nav-2-title'))
								<li id="nav-link-booking" class="nav-item">
									<a class="@yield('main-nav-active-2') nav-link" href="@yield('main-nav-2-location')">@yield('main-nav-2-title')</a>
								</li>
							@endif
						<?php endif; ?>
						
						<?php if ($salesVariable == "true") : ?>
							@if(View::hasSection('main-nav-3-title'))
								<li id="nav-link-sales" class="nav-item">
									<a class="@yield('main-nav-active-3') nav-link" href="@yield('main-nav-3-location')">@yield('main-nav-3-title')</a>
								</li>
							@endif
						<?php endif; ?>

						<li id="nav-link-checkout" class="nav-item checkout">
							<a class="@yield('main-nav-active-4') nav-link navbar__navigation__checkout" href="@yield('main-nav-4-location')">@yield('main-nav-4-title')</a>
							@yield('carts-counter')
						</li>
						
						@if(View::hasSection('back-end-link-title'))
							<li id="nav-link-back-to-dashboard" class="nav-item back-end-link">
								<a class="nav-link" href="@yield('back-end-link-location')">@yield('back-end-link-icon') @yield('back-end-link-title')</a>
							</li>
						@endif

					</ul>
				</div>
			</div>

			<div class="navbar__menu-toggler">
				<div class="navbar__menu-toggler__container" onclick="openNav()">
					<img src="/svg/hamburger-menu-icon-smaller.svg" class="navbar__menu-toggler__icon">
				</div>
			</div>

		</div>

		<div id="navbar__side-menu" class="navbar__side-menu">

			<div class="navbar__side-menu__container">
				<a href="javascript:void(0)" class="navbar__side-menu__closebtn" onclick="closeNav()"><img src="/svg/menu-x.svg" class="navbar__side-menu__closebtn__icon"></a>

				<h3 class="navbar__side-menu__title"><?php
					
					$organizationSettings = DB::table('organization_settings')->get();
					$organizationName = $organizationSettings[0]->organizationName;
					echo $organizationName;
					
				?></h3>

				<div class="navbar__side-menu__links">

					<a href="/settings">Settings</a>

					<div data-toggle="collapse" data-target="#inventory" role="button" aria-expanded="false" aria-controls="inventory toggle" class="navbar__side-menu__dropdown-link">
						<p class="navbar__side-menu__dropdown-link__title">Inventory</p>
						<i class="fas fa-chevron-down"></i>

					</div>

					<div class="collapse navbar__side-menu__sub-link-container" id="inventory">
						<a href="/rental-items" class="navbar__side-menu__sub-link">Rental Inventory</a>
						<a href="/booking-items" class="navbar__side-menu__sub-link">Booking Inventory</a>
						<a href="/sales-items" class="navbar__side-menu__sub-link">Sales Inventory</a>
						<!-- Damaged Goods
						<a href="/" class="navbar__side-menu__sub-link">Damaged Items</a>
						-->
					</div>

					<a href="/customers">Customers</a>
					<a href="/accounting">Accounting</a>
				</div>

				<a class="navbar__side-menu__logout" href="#">Logout &rarr;</a>
			</div>
		</div>









		<div class="sub-navbar @yield('sub-navbar-color')">
			<div class="sub-navbar__container">

				<a class="@yield('link-1-active-class') sub-navbar__link" href="@yield('link-1-location')">@yield('link-1-icon') @yield('link-1-title')</a> 

				<a class="@yield('link-2-active-class') sub-navbar__link" href="@yield('link-2-location')">@yield('link-2-icon') @yield('link-2-title')</a> 

				<a class="@yield('link-3-active-class') sub-navbar__link" href="@yield('link-3-location')">@yield('link-3-icon') @yield('link-3-title')</a>
				
				<a class="@yield('link-4-active-class') sub-navbar__link" href="@yield('link-4-location')">@yield('link-4-icon') @yield('link-4-title')</a>

			</div>
		</div>





		<div class="action-panel__title-area">
			<div>@yield('back-arrow')</div>
			<h3 class="action-panel__title">@yield('panel-title')</h3>
		</div>


		<div class="action-panel">
			@yield('content')
		</div>
		
		<div class="action-panel-footer-spacer"></div>
		
		
		<div class="footer">
		
			<div class="footer__links-container">

				<a href="" class="footer__link">Resources</a>
				<a href="" class="footer__link">Support</a>
				<p class="footer__copyright">Copyright 2019 | Quipper</p>
				<a href="" class="footer__link">Terms &amp; Conditions</a>
				<a href="" class="footer__link">Privacy Policy</a>

			</div>
		
		</div>
		
	
	</div>
	
	
	
	
	<?php if (isset($_GET['cart'])) : ?>
	
		<?php
			$retreivedCustomer = $_GET['cart'];
		?>
	
		<div class="carts__success">
			<div class="carts__success__box">
				<h1 class="carts__success__title"><i class="fas fa-check carts__success__check"></i>Payment collected for <span class="carts__success__name"><?php echo $retreivedCustomer; ?></span>.</h1>
			</div>
		</div>
	
	<?php endif; ?>
	
	
	
	
	<div class="side-menu-overlay"></div>
	
	<div class="mobile-prevention">
		<div class="mobile-prevention__logo__container">
			<img src="/svg/quipper-white.svg" class="mobile-prevention__logo">
		</div>
		<h3>Mobile and tablet versions of Quipper will be coming soon.</h3>
		<h5>In the meantime, Quipper is only a desktop application.</h5>
	</div>
	

	<script
  	src="https://code.jquery.com/jquery-3.4.1.js"
  	integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  	crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
	<script type="text/javascript" src="/js/datepicker.js"></script>
	
	<script type="text/javascript" src="/js/awesomplete.js"></script>
	
	<script type="text/javascript" src="/js/jquery.mask.js"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
	
	<script type="text/javascript" src="/js/custom.js"></script>
	
	@yield('script')
	
	
</body>
</html>
