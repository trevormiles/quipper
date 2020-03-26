//////// Determine if checkboxes are checked for navigation tabs /////////

$('#rentalTabsSubmit').click(function(){
	
	// Get the checkboxes
	var rentalsCheckBox = document.getElementById("rentalsCheckBox").checked;
	var bookingCheckBox = document.getElementById("bookingCheckBox").checked;
	var salesCheckBox = document.getElementById("salesCheckBox").checked;

	// Get the inputs
	var rentalsValue = $('#rentalsValue');
	var bookingValue = $('#bookingValue');
	var salesValue = $('#salesValue');

	// Run an if loop for each checkbox
	if(rentalsCheckBox == true){
		rentalsValue.val("true");
	} else {
		rentalsValue.val("false");
	}

	if(bookingCheckBox == true){
		bookingValue.val("true");
	} else {
		bookingValue.val("false");
	}

	if(salesCheckBox == true){
		salesValue.val("true");
	} else {
		salesValue.val("false");
	}
	
	
	$('#updateTabs').submit();
	
});
