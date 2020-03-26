// Live search the customers on edit booking page

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




// Reservation Date Initialization

$('.edit-booking__dates__block__dates__datePicker').datepicker({
	autoPick: true,
	trigger: '.edit-booking__dates__block__content__trigger__dateTrigger'
});


// Set the date to booking's date, first getting the predetermined date
var thePredeterminedDate = $('#predeterminedDate').val();
var pdDateSplit = thePredeterminedDate.split("-");
var pdDateYear = pdDateSplit[0];
var pdDateMonth = pdDateSplit[1];
var pdDateDay = pdDateSplit[2];
var pdReassembledDate = pdDateMonth + "/" + pdDateDay + "/" + pdDateYear;
$('.edit-booking__dates__block__dates__datePicker').datepicker('setDate', pdReassembledDate);


// Set the name of the day according to the date

var datePickerDay = $('.edit-booking__dates__block__dates__datePicker').datepicker('getDayName');
$('.edit-booking__dates__block__dates__datePickerDay').text(datePickerDay);


// Update the name of the day on change

$('.edit-booking__dates__block__dates__datePicker').change(function() {
	var datePickerDay = $('.edit-booking__dates__block__dates__datePicker').datepicker('getDayName');
	$('.edit-booking__dates__block__dates__datePickerDay').text(datePickerDay);
});


// Display the full text date

var theDate = $('.edit-booking__dates__block__dates__datePicker').datepicker('getDate', true);
var theDateFormatted = new Date(theDate);
var month = theDateFormatted.toLocaleString('default', { month: 'long' });
var day = theDateFormatted.getDate();
var year = theDateFormatted.getFullYear();

$('.edit-booking__dates__block__dates__fullDateDisplayed').text(month + " " + day + ", " + year);


// Update the full text date on change

$('.edit-booking__dates__block__dates__datePicker').change(function() {
	var theDate = $('.edit-booking__dates__block__dates__datePicker').datepicker('getDate', true);
	var theDateFormatted = new Date(theDate);
	var month = theDateFormatted.toLocaleString('default', { month: 'long' });
	var day = theDateFormatted.getDate();
	var year = theDateFormatted.getFullYear();

	$('.edit-booking__dates__block__dates__fullDateDisplayed').text(month + " " + day + ", " + year);
});






// Initiate time picker

var predeterminedStartTime = $('#predeterminedStartTime').val();
var predeterminedEndTime = $('#predeterminedEndTime').val();

$('#timepicker-start').timepicker({
	timeFormat: 'h:mm p',
	interval: 60,
	defaultTime: predeterminedStartTime,
	dynamic: true,
	dropdown: true,
	scrollbar: true
});


$('#timepicker-end').timepicker({
	timeFormat: 'h:mm p',
	interval: 60,
	defaultTime: predeterminedEndTime,
	dynamic: true,
	dropdown: true,
	scrollbar: true
});










// Hide error messages, and show them below if there are errors
$('#customer-not-exist').hide();
$('#no-customer-selected').hide();
$('#both-customer-fields-have-inputs').hide();
$('#missing-fields-new-customer').hide();
$('#new-customer-name-already-exists').hide();
$('#start-date-too-large').hide();
$('#there-are-forbidden-characters').hide();
$('#customer-name-no-space').hide();
$('#customer-name-length').hide();
$('#non-valid-email').hide();
$('#phone-not-long-enough').hide();





// Make phone number input do what we want
$('#phoneNumber').mask('(000) 000-0000');





// Next Button Functionality

document.getElementById("nextButton").onclick = function() {
			
	// Hide any previous error messages
	$('.edit-booking__errors__container').hide();
	$('.edit-booking__errors').hide();

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
	
	
	// Set up the time validation that will be used in the if statement below
	var startTimeComparison = $('#timepicker-start').val();
	var startTimeComparison = moment(startTimeComparison, ["h:mm A"]).format("HH:mm:ss");
	var endTimeComparison = $('#timepicker-end').val();
	var endTimeComparison = moment(endTimeComparison, ["h:mm A"]).format("HH:mm:ss");
	

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

		$('.edit-booking__errors__container').show();
		$('#no-customer-selected').show();

	} else if (startTimeComparison > endTimeComparison) {
		
		$('.edit-booking__errors__container').show();
		$('#start-date-too-large').show();
		
	} else if ((newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") && existingName !== "") {

		$('.edit-booking__errors__container').show();
		$('#both-customer-fields-have-inputs').show();

	} else if (newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") {

		if (newCustomerName === "" || newCustomerEmail === "" || newCustomerPhoneNumber === "") {

			$('.edit-booking__errors__container').show();
			$('#missing-fields-new-customer').show();

		} else if (newCustomerAlreadyExists == true) {

			$('.edit-booking__errors__container').show();
			$('#new-customer-name-already-exists').show();

		} else if (customerNameContainsSpace == false) {

			$('.edit-booking__errors__container').show();
			$('#customer-name-no-space').show();

		} else if (newCustomerName.length < 4) {

			$('.edit-booking__errors__container').show();
			$('#customer-name-length').show();

		} else if (newCustomerNameContainsForbiddenCharacters == true) {

			$('.edit-booking__errors__container').show();
			$('#there-are-forbidden-characters').show();
		
		} else if (newCustomerPhoneNumber.length < 14) {
		
			$('.edit-booking__errors__container').show();
			$('#phone-not-long-enough').show();

		} else if (validEmailAddress == false) {

			$('.edit-booking__errors__container').show();
			$('#non-valid-email').show();

		} else {
			document.getElementById("newCustomerBooking").submit();
		}

	} else {

		if (isTheCustomerExisting == false) {

			$('.edit-booking__errors__container').show();
			$('#customer-not-exist').show();

		} else {
			
			document.getElementById("customer-input").required = true;

			var $selectedDate = document.getElementById("datePicker").value;
			var $selectedPerson = document.getElementById("customer-input").value;
			var $startTime = $('#timepicker-start').val();
			var $endTime = $('#timepicker-end').val();
			var $thisRentalID = document.getElementById("getThisRentalID").value;

			var $hrefLocation = "/booking-edit2?data=" + $thisRentalID + "-" + $selectedDate + "-" + $selectedPerson + "-" + $startTime + "-" + $endTime;

			document.getElementById("nextButton").setAttribute("href",$hrefLocation);
		}
	}

}


