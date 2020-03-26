@extends('layout')


@section('title', 'Quipper | Settings')


@section('back-end-link-icon')
	<i class="fas fa-arrow-left"></i>
@endsection
@section('back-end-link-title', 'Go Back to Main Dashboard')
@section('back-end-link-location', '/rentals')


@section('sub-navbar-color', 'sub-navbar__red')


@section('link-1-title', 'All Settings')
@section('link-1-location', '/settings')
@section('link-1-active-class', 'sub-nav-active')


@section('panel-title', 'Settings')

@section('content')
	
	<div class="settings">
		
		
		<h3 class="settings__title">Organization Name</h3>
		
		<div class="settings__box-container">
			<form method="POST" action="/update-organization-name">

				@method('PATCH')
				{{ csrf_field() }}
				
				<input class="settings__organization-name-input form-control" name="organizationName" type="text" value="<?php echo $organizationSettings[0]["organizationName"]; ?>">	
				
				<div class="settings__submit__container">
					<button type="submit" class="settings__submit">Submit changes</button>
				</div>

			</form>
		</div>
		
		<?php if (isset($_GET['data'])) : ?>
			<?php $retreivedData = $_GET['data']; ?>
			<?php if ($retreivedData == "updatedOrganizationName") : ?>
				<div class="alert alert-success settings__alert" role="alert">
  					Organization Name successfully updated!
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		
		
		
		
		
		<h3 class="settings__title">Main Navigation Tabs</h3>
		
		<div class="settings__box-container">
			<form method="POST" action="/update-main-navigation" id="updateTabs">

				@method('PATCH')
				{{ csrf_field() }}
				
				<input type="hidden" name="rentalsValue" id="rentalsValue">
				<input type="hidden" name="bookingValue" id="bookingValue">
				<input type="hidden" name="salesValue" id="salesValue">
				
				<div class="settings__header">
					<h6 class="settings__header__title settings__header__item">Tab Name</h6>
					<h6 class="settings__header__active settings__header__item">Active</h6>
				</div>
				
				<div class="settings__container">
					
					<div class="settings__setting__container">
						<h4 class="settings__setting__title">Rentals</h4>

						<label class="switch">
							<input class="checkbox-check-out" id="rentalsCheckBox" type="checkbox" <?php if ($menuItems[0]["selected"] == "true") { echo "checked"; } ?>>
							<span class="slider round"></span>
						</label>
					</div>
					
					<div class="settings__setting__container">
						<h4 class="settings__setting__title">Booking</h4>

						<label class="switch">
							<input class="checkbox-check-out" id="bookingCheckBox" type="checkbox" <?php if ($menuItems[1]["selected"] == "true") { echo "checked"; } ?>>
							<span class="slider round"></span>
						</label>
					</div>
					
					<div class="settings__setting__container">
						<h4 class="settings__setting__title">Sales</h4>

						<label class="switch">
							<input class="checkbox-check-out" id="salesCheckBox" type="checkbox" <?php if ($menuItems[2]["selected"] == "true") { echo "checked"; } ?>>
							<span class="slider round"></span>
						</label>
					</div>
					
				</div>
				
				<div class="settings__submit__container">
					<a class="settings__submit" id="rentalTabsSubmit">Submit changes</a>
				</div>

			</form>
		</div>
		
		<?php if (isset($_GET['data'])) : ?>
			<?php $retreivedData = $_GET['data']; ?>
			<?php if ($retreivedData == "updatedTabs") : ?>
				<div class="alert alert-success settings__alert" role="alert">
  					Main Navigation Tabs successfully updated!
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
	</div>


	@section('script')
		<script type="text/javascript" src="/js/settings.js"></script>
	@endsection


@endsection
