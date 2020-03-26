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




// If there is data from create2
var dataFromCreate2 = $('#dataFromCreate2').val();
if (dataFromCreate2) {
	var dataFromCreate2Array = dataFromCreate2.split("-");
	var dataFromCreate2StartDate = dataFromCreate2Array[0];
	var dataFromCreate2EndDate = dataFromCreate2Array[1];
	var dataFromCreate2Customer = dataFromCreate2Array[2];
	
	$('#customer-input').val(dataFromCreate2Customer);
}




// Make phone number input do what we want
$('#phoneNumber').mask('(000) 000-0000');




// Reservation Start Date Initialization


$('.create-rental__dates__block__dates__startDatePicker').datepicker({
	autoPick: true,
	trigger: '.create-rental__dates__block__content__trigger__startDateTrigger'
});


if (dataFromCreate2) {
	$('.create-rental__dates__block__dates__startDatePicker').datepicker('setDate', dataFromCreate2StartDate);
}


// Set the name of the day according to the date

var startDatePickerDay = $('.create-rental__dates__block__dates__startDatePicker').datepicker('getDayName');
$('.create-rental__dates__block__dates__startDatePickerDay').text(startDatePickerDay);


// Update the name of the day on change

$('.create-rental__dates__block__dates__startDatePicker').change(function() {
	var startDatePickerDay = $('.create-rental__dates__block__dates__startDatePicker').datepicker('getDayName');
	$('.create-rental__dates__block__dates__startDatePickerDay').text(startDatePickerDay);
});


// Display the full text date

var theStartDate = $('.create-rental__dates__block__dates__startDatePicker').datepicker('getDate', true);
var theStartDateFormatted = new Date(theStartDate);
var month = theStartDateFormatted.toLocaleString('default', { month: 'long' });
var day = theStartDateFormatted.getDate();
var year = theStartDateFormatted.getFullYear();

$('.create-rental__dates__block__dates__fullStartDateDisplayed').text(month + " " + day + ", " + year);


// Update the full text date on change

$('.create-rental__dates__block__dates__startDatePicker').change(function() {
	var theStartDate = $('.create-rental__dates__block__dates__startDatePicker').datepicker('getDate', true);
	var theStartDateFormatted = new Date(theStartDate);
	var month = theStartDateFormatted.toLocaleString('default', { month: 'long' });
	var day = theStartDateFormatted.getDate();
	var year = theStartDateFormatted.getFullYear();

	$('.create-rental__dates__block__dates__fullStartDateDisplayed').text(month + " " + day + ", " + year);
});






// Reservation End Date Initialization

var dateToday = new Date();

$('.create-rental__dates__block__dates__endDatePicker').datepicker({
	date: dateToday.setDate(dateToday.getDate() + 1),
	autoPick: true,
	trigger: '.create-rental__dates__block__content__trigger__endDateTrigger'
});


if (dataFromCreate2) {
	$('.create-rental__dates__block__dates__endDatePicker').datepicker('setDate', dataFromCreate2EndDate);
}


// Set the name of the day according to the date

var endDatePickerDay = $('.create-rental__dates__block__dates__endDatePicker').datepicker('getDayName');
$('.create-rental__dates__block__dates__endDatePickerDay').text(endDatePickerDay);


// Update the name of the day on change

$('.create-rental__dates__block__dates__endDatePicker').change(function() {
	var endDatePickerDay = $('.create-rental__dates__block__dates__endDatePicker').datepicker('getDayName');
	$('.create-rental__dates__block__dates__endDatePickerDay').text(endDatePickerDay);
});


// Display the full text date

var theEndDate = $('.create-rental__dates__block__dates__endDatePicker').datepicker('getDate', true);
var theEndDateFormatted = new Date(theEndDate);
var endMonth = theEndDateFormatted.toLocaleString('default', { month: 'long' });
var endDay = theEndDateFormatted.getDate();
var endYear = theEndDateFormatted.getFullYear();

$('.create-rental__dates__block__dates__fullEndDateDisplayed').text(endMonth + " " + endDay + ", " + endYear);


// Update the full text date on change

$('.create-rental__dates__block__dates__endDatePicker').change(function() {
	var theEndDate = $('.create-rental__dates__block__dates__endDatePicker').datepicker('getDate', true);
	var theEndDateFormatted = new Date(theEndDate);
	var endMonth = theEndDateFormatted.toLocaleString('default', { month: 'long' });
	var endDay = theEndDateFormatted.getDate();
	var endYear = theEndDateFormatted.getFullYear();

	$('.create-rental__dates__block__dates__fullEndDateDisplayed').text(endMonth + " " + endDay + ", " + endYear);
});










// Hide error messages, and show them below if there are errors
$('#customer-not-exist').hide();
$('#no-customer-selected').hide();
$('#both-customer-fields-have-inputs').hide();
$('#missing-fields-new-customer').hide();
$('#new-customer-name-already-exists').hide();
$('#start-date-too-large').hide();
$('#there-are-forbidden-characters').hide();
$('#customer-name-length').hide();
$('#non-valid-email').hide();
$('#customer-name-no-space').hide();
$('#phone-not-long-enough').hide();









// Next Button Functionality

document.getElementById("nextButton").onclick = function() {
			
	// Hide any previous error messages
	$('.create-rental__errors__container').hide();
	$('.create-rental__errors').hide();

	// Get variables that will be used in the if statement below
	var newCustomerName = document.getElementById("newCustomerName").value;
	var existingName = document.getElementById("customer-input").value;

	// Set up the new customer validation variables that will be used in the if statement below
	var newCustomerEmail =  document.getElementById('email').value;
	var newCustomerPhoneNumber =  document.getElementById('phoneNumber').value;
	
	// Set up the variables to make sure there are no forbidden characters
	var newCustomerNameIncludesAtSign = newCustomerName.includes("@");
	var newCustomerNameIncludesColon = newCustomerName.includes(":");
	var newCustomerNameIncludesQuestionMark = newCustomerName.includes("?");
	var newCustomerNameIncludesDash = newCustomerName.includes("-");
	var newCustomerNameIncludesSlash = newCustomerName.includes("/");
	
	// Set up a variable and a loop to check if any of the above variables are true
	
	var newCustomerNameContainsForbiddenCharacters = false;
	
	if (newCustomerNameIncludesAtSign == true || newCustomerNameIncludesColon == true || newCustomerNameIncludesQuestionMark == true || newCustomerNameIncludesDash == true || newCustomerNameIncludesSlash == true) {
		newCustomerNameContainsForbiddenCharacters = true;
	}

	// Set up the existing customer and new customer validation which will be used in the if statement below
	var isTheCustomerExisting = false;
	var newCustomerAlreadyExists = false;
	var customerOptionNames = document.querySelectorAll('#customerOptions li');
	var customerOptionNamesArray = [];
	
	// Set up the date validation that will be used in the if statement below
	var startDateComparison = $('.create-rental__dates__block__dates__startDatePicker').datepicker('getDate', true);
	var startDateComparison = new Date(startDateComparison);
	
	var endDateComparison = $('.create-rental__dates__block__dates__endDatePicker').datepicker('getDate', true);
	var endDateComparison = new Date(endDateComparison);	
	

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


	// Decide what to do based off of the input given
	if (newCustomerName === "" && newCustomerEmail === "" && newCustomerPhoneNumber === "" && existingName === "") {

		$('.create-rental__errors__container').show();
		$('#no-customer-selected').show();

	} else if ((newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") && existingName !== "") {

		$('.create-rental__errors__container').show();
		$('#both-customer-fields-have-inputs').show();

	} else if (startDateComparison > endDateComparison) {
		
		$('.create-rental__errors__container').show();
		$('#start-date-too-large').show();
		
	} else if (newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") {

		if (newCustomerName === "" || newCustomerEmail === "" || newCustomerPhoneNumber === "") {

			$('.create-rental__errors__container').show();
			$('#missing-fields-new-customer').show();

		} else if (newCustomerAlreadyExists == true) {

			$('.create-rental__errors__container').show();
			$('#new-customer-name-already-exists').show();

		} else if (customerNameContainsSpace == false) {

			$('.create-rental__errors__container').show();
			$('#customer-name-no-space').show();

		} else if (newCustomerName.length < 4) {

			$('.create-rental__errors__container').show();
			$('#customer-name-length').show();

		} else if (newCustomerNameContainsForbiddenCharacters == true) {
		
			$('.create-rental__errors__container').show();
			$('#there-are-forbidden-characters').show();
		
		} else if (newCustomerPhoneNumber.length < 14) {
		
			$('.create-rental__errors__container').show();
			$('#phone-not-long-enough').show();

		} else if (validEmailAddress == false) {
		
			$('.create-rental__errors__container').show();
			$('#non-valid-email').show();
		
		} else {
			document.getElementById("newCustomerRentals").submit();
		}

	} else {

		if (isTheCustomerExisting == false) {

			$('.create-rental__errors__container').show();
			$('#customer-not-exist').show();

		} else {
			document.getElementById("customer-input").required = true;

			var $selectedStartDate = document.getElementById("startDatePicker").value;
			var $selectedEndDate = document.getElementById("endDatePicker").value;
			var $selectedPerson = document.getElementById("customer-input").value;

			var $hrefLocation = "/rentals-create2?data=" + $selectedStartDate + "-" + $selectedEndDate + "-" + $selectedPerson;

			document.getElementById("nextButton").setAttribute("href",$hrefLocation);
		}
	}

}


