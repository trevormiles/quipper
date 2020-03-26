// Live search the customers on create new rental page

document.addEventListener("DOMContentLoaded", function() {
	var input = document.getElementById("customer-input");
	new Awesomplete(input, {list: "#customer-options-list", minChars: 1});
});

function searchingCustomerNames() {

	var allPossibleCustomerNames = document.querySelectorAll('#awesomplete_list_1 li');

	if (allPossibleCustomerNames.length > 0) {
		document.getElementById("noMatchesCustomerNames").style.display = "none";
	} else if ($('#customer-input').val() == '') {
		document.getElementById("noMatchesCustomerNames").style.display = "none";
	} else {
		document.getElementById("noMatchesCustomerNames").style.display = "block";
	}	
}








// Reservation Start Date Initialization

$('.edit-rental__dates__block__dates__startDatePicker').datepicker({
	trigger: '.edit-rental__dates__block__content__trigger__startDateTrigger'
});


// Set the date to rental's start date, first getting the predetermined start date
var thePredeterminedStartDate = $('#getPredeterminedStartDate').val();
var pdStartDateSplit = thePredeterminedStartDate.split("-");
var pdStartDateYear = pdStartDateSplit[0];
var pdStartDateMonth = pdStartDateSplit[1];
var pdStartDateDay = pdStartDateSplit[2];
var pdReassembledStartDate = pdStartDateMonth + "/" + pdStartDateDay + "/" + pdStartDateYear;
$('.edit-rental__dates__block__dates__startDatePicker').datepicker('setDate', pdReassembledStartDate);


// Set the name of the day according to the date

var startDatePickerDay = $('.edit-rental__dates__block__dates__startDatePicker').datepicker('getDayName');
$('.edit-rental__dates__block__dates__startDatePickerDay').text(startDatePickerDay);


// Update the name of the day on change

$('.edit-rental__dates__block__dates__startDatePicker').change(function() {
	var startDatePickerDay = $('.edit-rental__dates__block__dates__startDatePicker').datepicker('getDayName');
	$('.edit-rental__dates__block__dates__startDatePickerDay').text(startDatePickerDay);
});


// Display the full text date

var theStartDate = $('.edit-rental__dates__block__dates__startDatePicker').datepicker('getDate', true);
var theStartDateFormatted = new Date(theStartDate);
var month = theStartDateFormatted.toLocaleString('default', { month: 'long' });
var day = theStartDateFormatted.getDate();
var year = theStartDateFormatted.getFullYear();

$('.edit-rental__dates__block__dates__fullStartDateDisplayed').text(month + " " + day + ", " + year);


// Update the full text date on change

$('.edit-rental__dates__block__dates__startDatePicker').change(function() {
	var theStartDate = $('.edit-rental__dates__block__dates__startDatePicker').datepicker('getDate', true);
	var theStartDateFormatted = new Date(theStartDate);
	var month = theStartDateFormatted.toLocaleString('default', { month: 'long' });
	var day = theStartDateFormatted.getDate();
	var year = theStartDateFormatted.getFullYear();

	$('.edit-rental__dates__block__dates__fullStartDateDisplayed').text(month + " " + day + ", " + year);
});






// Reservation End Date Initialization

$('.edit-rental__dates__block__dates__endDatePicker').datepicker({
	trigger: '.edit-rental__dates__block__content__trigger__endDateTrigger'
});



// Set the date to rental's start date, first getting the predetermined start date
var thePredeterminedEndDate = $('#getPredeterminedEndDate').val();
var pdEndDateSplit = thePredeterminedEndDate.split("-");
var pdEndDateYear = pdEndDateSplit[0];
var pdEndDateMonth = pdEndDateSplit[1];
var pdEndDateDay = pdEndDateSplit[2];
var pdReassembledEndDate = pdEndDateMonth + "/" + pdEndDateDay + "/" + pdEndDateYear;
$('.edit-rental__dates__block__dates__endDatePicker').datepicker('setDate', pdReassembledEndDate);



// Set the name of the day according to the date

var endDatePickerDay = $('.edit-rental__dates__block__dates__endDatePicker').datepicker('getDayName');
$('.edit-rental__dates__block__dates__endDatePickerDay').text(endDatePickerDay);


// Update the name of the day on change

$('.edit-rental__dates__block__dates__endDatePicker').change(function() {
	var endDatePickerDay = $('.edit-rental__dates__block__dates__endDatePicker').datepicker('getDayName');
	$('.edit-rental__dates__block__dates__endDatePickerDay').text(endDatePickerDay);
});


// Display the full text date

var theEndDate = $('.edit-rental__dates__block__dates__endDatePicker').datepicker('getDate', true);
var theEndDateFormatted = new Date(theEndDate);
var endMonth = theEndDateFormatted.toLocaleString('default', { month: 'long' });
var endDay = theEndDateFormatted.getDate();
var endYear = theEndDateFormatted.getFullYear();

$('.edit-rental__dates__block__dates__fullEndDateDisplayed').text(endMonth + " " + endDay + ", " + endYear);


// Update the full text date on change

$('.edit-rental__dates__block__dates__endDatePicker').change(function() {
	var theEndDate = $('.edit-rental__dates__block__dates__endDatePicker').datepicker('getDate', true);
	var theEndDateFormatted = new Date(theEndDate);
	var endMonth = theEndDateFormatted.toLocaleString('default', { month: 'long' });
	var endDay = theEndDateFormatted.getDate();
	var endYear = theEndDateFormatted.getFullYear();

	$('.edit-rental__dates__block__dates__fullEndDateDisplayed').text(endMonth + " " + endDay + ", " + endYear);
});


// Hide error messages, and show them below if there are errors
$('#customer-not-exist').hide();
$('#no-customer-selected').hide();
$('#both-customer-fields-have-inputs').hide();
$('#missing-fields-new-customer').hide();
$('#new-customer-name-already-exists').hide();
$('#start-date-too-large').hide();
$('#new-dates-dont-work').hide();
$('#customer-name-no-space').hide();
$('#customer-name-length').hide();
$('#non-valid-email').hide();
$('#there-are-forbidden-characters').hide();
$('#phone-not-long-enough').hide();






// Get the item availability list that we'll use when the next button is clicked below

var itemsAvailabilityList = $('#itemsAvailabilityList').val();

// Split it up into an array
var itemsAvailabilityListArray = itemsAvailabilityList.split("?");




// Make phone number input do what we want
$('#phoneNumber').mask('(000) 000-0000');




// Next Button Functionality

document.getElementById("nextButton").onclick = function() {
			
	// Hide any previous error messages
	$('.edit-rental__errors__container').hide();
	$('.edit-rental__errors').hide();

	// Get variables that will be used in the if statement below
	var newCustomerName = document.getElementById("newCustomerName").value;
	var existingName = document.getElementById("customer-input").value;
	var thisRentalID = document.getElementById("getThisRentalID").value;

	// Set up the new customer validation variables that will be used in the if statement below
	var newCustomerEmail =  document.getElementById('email').value;
	var newCustomerPhoneNumber =  document.getElementById('phoneNumber').value;
	
	// Set up the date validation that will be used in the if statement below
	var startDateComparison = $('.edit-rental__dates__block__dates__startDatePicker').datepicker('getDate', true);
	var endDateComparison = $('.edit-rental__dates__block__dates__endDatePicker').datepicker('getDate', true);
	
	
	////////////////// See if the item name contains any forbidden characters //////////////////////
	// First, save the true false statements to vars
	var customerNameIncludesAtSign = newCustomerName.includes("@");
	var customerNameIncludesColon = newCustomerName.includes(":");
	var customerNameIncludesQuestionMark = newCustomerName.includes("?");
	var customerNameIncludesDash = newCustomerName.includes("-");
	var customerNameIncludesSlash = newCustomerName.includes("/");
	
	// Set up a variable and a loop to check if any of the above variables are true
	var customerNameContainsForbiddenCharacters = false;
	
	if (customerNameIncludesAtSign == true || customerNameIncludesColon == true || customerNameIncludesQuestionMark == true || customerNameIncludesDash == true || customerNameIncludesSlash == true) {
		customerNameContainsForbiddenCharacters = true;
	}
	
	// Set up the existing customer and new customer validation which will be used in the if statement below
	var isTheCustomerExisting = false;
	var newCustomerAlreadyExists = false;
	var customerOptionNames = document.querySelectorAll('#customerOptions li');
	var customerOptionNamesArray = [];
		
	// See if inputed customer is existing
	for (i = 0; i < customerOptionNames.length; ++i) {
		var newCustomerOption = customerOptionNames[i].innerText;
		customerOptionNamesArray.push(newCustomerOption);
	}

	for (i = 0; i < customerOptionNamesArray.length; ++i) {
		if (customerOptionNamesArray[i] === existingName) {
			isTheCustomerExisting = true;
		}
	}
	
	for (i = 0; i < customerOptionNamesArray.length; ++i) {
		if (customerOptionNamesArray[i] === newCustomerName) {
			var newCustomerAlreadyExists = true;
		}
	}
	
	
	
	// Set up the email validation, making sure there is an @ symbol
	var validEmailAddress = false;
	if (newCustomerEmail.includes("@")) {
		validEmailAddress = true;
	}
	
	// Check if name contains a space
	var customerNameContainsSpace = false;
	if (newCustomerName.match(/\s/g)) {
		customerNameContainsSpace = true;
	}
	
	
	
	
	
	
	
	/////// Run through the item availability list and throw an error if an item isn't available depending on the dates selected ///////////
	
	///////////// First get the selected dates ////////////////////////
	
	// The Start Date
	var selectedStartDate = $('.edit-rental__dates__block__dates__startDatePicker').datepicker('getDate', true);
	var selectedStartDateArray = selectedStartDate.split("/");
	var selectedStartDateMonth = selectedStartDateArray[0];
	var selectedStartDateDay = selectedStartDateArray[1];
	var selectedStartDateYear = selectedStartDateArray[2];
	selectedStartDate = selectedStartDateYear + "-" + selectedStartDateMonth + "-" + selectedStartDateDay;
	
	// The End Date
	var selectedEndDate = $('.edit-rental__dates__block__dates__endDatePicker').datepicker('getDate', true);
	var selectedEndDateArray = selectedEndDate.split("/");
	var selectedEndDateMonth = selectedEndDateArray[0];
	var selectedEndDateDay = selectedEndDateArray[1];
	var selectedEndDateYear = selectedEndDateArray[2];
	selectedEndDate = selectedEndDateYear + "-" + selectedEndDateMonth + "-" + selectedEndDateDay;

	
	for (j = 0; j < itemsAvailabilityListArray.length; j++) {
		
		// Split up the array to be able to seperate the information from the instances
		var itemList = itemsAvailabilityListArray[j].split(":");
		
		// Seperate the information from the instances
		var itemInformation = itemList[0];
		
		// Split up the information into an array
		var itemInformationArray = itemInformation.split("!");
		
		// Now save those array items into their own variables
		var itemTitle = itemInformationArray[0];
		var itemReservedQuantity = itemInformationArray[1];
		var itemInventoryQuantity = itemInformationArray[2];
		
		// Calculate the difference between the reserved quantity and the inventory quantity
		var itemDifferenceQuantity = itemInventoryQuantity - itemReservedQuantity;
		
		// Remove the information from the itemSplit array so that we only have the instances in the itemSplit
		itemList.shift();
		
		// Loop through each item instance and if the dates interact with our new selected dates, minus the quantity of the instance from the total rental inventory
		for (k = 0; k < itemList.length; k++) {

			var itemListSplit = itemList[k].split("@");
			var instanceReservedAmount = itemListSplit[0];
			
			var instanceStartDate = itemListSplit[1];
			
			var instanceEndDate = itemListSplit[2];
			
			
			if ((instanceStartDate <= selectedEndDate) && (instanceEndDate >= selectedStartDate)) {
				itemDifferenceQuantity = itemDifferenceQuantity - instanceReservedAmount;
			}
			
			
		}
		
		if (itemDifferenceQuantity < 0) {
			$('#new-dates-dont-work').text("There are not enough " + itemTitle + " available to be able to change to the new selected dates.");
		}
		
	}
	
	
	
	
	
	


	// Decide what to do based off of the input given
	if (newCustomerName === "" && newCustomerEmail === "" && newCustomerPhoneNumber === "" && existingName === "") {

		$('.edit-rental__errors__container').show();
		$('#no-customer-selected').show();

	} else if ((newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") && existingName !== "") {

		$('.edit-rental__errors__container').show();
		$('#both-customer-fields-have-inputs').show();

	} else if (startDateComparison > endDateComparison) {
		
		$('.edit-rental__errors__container').show();
		$('#start-date-too-large').show();
		
	} else if (newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") {

		if (newCustomerName === "" || newCustomerEmail === "" || newCustomerPhoneNumber === "") {

			$('.edit-rental__errors__container').show();
			$('#missing-fields-new-customer').show();

		} else if (newCustomerAlreadyExists == true) {

			$('.edit-rental__errors__container').show();
			$('#new-customer-name-already-exists').show();

		} else if (customerNameContainsSpace == false) {

			$('.edit-rental__errors__container').show();
			$('#customer-name-no-space').show();

		} else if (newCustomerName.length < 4) {

			$('.edit-rental__errors__container').show();
			$('#customer-name-length').show();

		} else if (customerNameContainsForbiddenCharacters == true) {

			$('.edit-rental__errors__container').show();
			$('#there-are-forbidden-characters').show();
		
		} else if (newCustomerPhoneNumber.length < 14) {
		
			$('.edit-rental__errors__container').show();
			$('#phone-not-long-enough').show();

		} else if (validEmailAddress == false) {

			$('.edit-rental__errors__container').show();
			$('#non-valid-email').show();

		} else {
			document.getElementById("newCustomerRentals").submit();
		}

	} else if (itemDifferenceQuantity < 0) {
		
		$('.edit-rental__errors__container').show();
		$('#new-dates-dont-work').show();
		
	} else {

		if (isTheCustomerExisting == false) {

			$('.edit-rental__errors__container').show();
			$('#customer-not-exist').show();

		} else {
			document.getElementById("customer-input").required = true;

			var $selectedStartDate = document.getElementById("startDatePicker").value;
			var $selectedEndDate = document.getElementById("endDatePicker").value;
			var $selectedPerson = document.getElementById("customer-input").value;

			var $hrefLocation = "/rentals-edit2?data=" + thisRentalID + "-" + $selectedStartDate + "-" + $selectedEndDate + "-" + $selectedPerson;

			document.getElementById("nextButton").setAttribute("href",$hrefLocation);
		}
	}

}


