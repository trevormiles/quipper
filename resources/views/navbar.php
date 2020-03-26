<div class="navbar">
	
	<div class="navbar__left">
		<div class="navbar__logo">
			<a href="/">
				<img src="/svg/quipper.svg" class="navbar__logo__image">
			</a>
		</div>
	
		<div class="navbar__navigation">
			<ul class="nav">
				
			  <li id="nav-link-rentals" class="nav-item">
				<a class="nav-link" href="/">Rentals</a>
			  </li>
				
			  <li id="nav-link-booking" class="nav-item">
				<a class="nav-link" href="/booking">Booking</a>
			  </li>
				
			  <li id="nav-link-sales" class="nav-item">
				<a class="nav-link" href="/sales">Sales</a>
			  </li>
				
			  <li id="nav-link-checkout" class="nav-item">
				<a class="nav-link navbar__navigation__checkout" href="/carts">Carts</a>
			  </li>
				
			</ul>
		</div>
	</div>
	
	<div class="navbar__menu-toggler">
		<div class="navbar__menu-toggler__container" onclick="openNav()">
			<img src="/svg/organization-logo.svg" class="navbar__menu-toggler__icon">
		</div>
	</div>
	
</div>

<div id="navbar__side-menu" class="navbar__side-menu">
	
	<div class="navbar__side-menu__container">
		<a href="javascript:void(0)" class="navbar__side-menu__closebtn" onclick="closeNav()">&times;</a>

		<h3 class="navbar__side-menu__title">SUU Outdoors</h3>
		
		<div class="navbar__side-menu__links">
			<a href="/">Main Dashboard</a>
			
			<div data-toggle="collapse" data-target="#settings" role="button" aria-expanded="false" aria-controls="settings toggle" class="navbar__side-menu__dropdown-link">
				<p class="navbar__side-menu__dropdown-link__title">Settings</p>
				<i class="fas fa-chevron-down"></i>
			
			</div>
			
			<div class="collapse navbar__side-menu__sub-link-container" id="settings">
				<a href="/" class="navbar__side-menu__sub-link">Customization</a>
			</div>
			
			<div data-toggle="collapse" data-target="#inventory" role="button" aria-expanded="false" aria-controls="inventory toggle" class="navbar__side-menu__dropdown-link">
				<p class="navbar__side-menu__dropdown-link__title">Inventory</p>
				<i class="fas fa-chevron-down"></i>
			
			</div>
			
			<div class="collapse navbar__side-menu__sub-link-container" id="inventory">
				<a href="/rental-items" class="navbar__side-menu__sub-link">Rental Inventory</a>
				<a href="/" class="navbar__side-menu__sub-link">Booking Inventory</a>
				<a href="/" class="navbar__side-menu__sub-link">Sales Inventory</a>
				<a href="/" class="navbar__side-menu__sub-link">Damaged Items</a>
			</div>
			
			<a href="/customers">Customers</a>
			<a href="/">Accounting</a>
		</div>

		<a class="navbar__side-menu__logout" href="#">Logout &rarr;</a>
	</div>
</div>