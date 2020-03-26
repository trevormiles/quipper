<?php

namespace App\Http\Controllers;

use App\MenuItem;
use App\OrganizationSetting;

use Illuminate\Http\Request;

class SettingsController extends Controller
{	
	
	public function edit()
	
	{
		
		$menuItems = \App\MenuItem::all();
		$organizationSettings = \App\OrganizationSetting::all();
		
		return view('settings.edit', compact('menuItems', 'organizationSettings'));
		
	}
	
	
	
	
	public function updateMenuItems()
	
	{
		
		$menuItems = \App\MenuItem::all();
		$menuItems[0]->selected = request('rentalsValue');
		$menuItems[1]->selected = request('bookingValue');
		$menuItems[2]->selected = request('salesValue');
		
		$menuItems[0]->update();
		$menuItems[1]->update();
		$menuItems[2]->update();
		
		return redirect('/settings?data=updatedTabs');
		
	}
	
	
	
	public function updateOrganizationName()
		
	{
		$organizationSettings = \App\OrganizationSetting::all();
		$organizationSettings[0]->organizationName = request('organizationName');
		
		$organizationSettings[0]->update();
		
		return redirect('/settings?data=updatedOrganizationName');
		
	}
	
}
