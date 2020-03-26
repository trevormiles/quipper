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
	var dataFromCreate2Date = dataFromCreate2Array[0];
	var dataFromCreate2Customer = dataFromCreate2Array[1];
	var dataFromCreate2StartTime = dataFromCreate2Array[2];
	var dataFromCreate2EndTime = dataFromCreate2Array[3];
	
	$('#customer-input').val(dataFromCreate2Customer);
}





// Make phone number input do what we want
$('#phoneNumber').mask('(000) 000-0000');





// Reservation Date Initialization


$('.create-booking__dates__block__dates__datePicker').datepicker({
	autoPick: true,
	trigger: '.create-booking__dates__block__content__trigger__dateTrigger'
});


if (dataFromCreate2) {
	$('.create-booking__dates__block__dates__datePicker').datepicker('setDate', dataFromCreate2Date);
}


// Set the name of the day according to the date

var datePickerDay = $('.create-booking__dates__block__dates__datePicker').datepicker('getDayName');
$('.create-booking__dates__block__dates__datePickerDay').text(datePickerDay);


// Update the name of the day on change

$('.create-booking__dates__block__dates__datePicker').change(function() {
	var datePickerDay = $('.create-booking__dates__block__dates__datePicker').datepicker('getDayName');
	$('.create-booking__dates__block__dates__datePickerDay').text(datePickerDay);
});


// Display the full text date

var theDate = $('.create-booking__dates__block__dates__datePicker').datepicker('getDate', true);
var theDateFormatted = new Date(theDate);
var month = theDateFormatted.toLocaleString('default', { month: 'long' });
var day = theDateFormatted.getDate();
var year = theDateFormatted.getFullYear();

$('.create-booking__dates__block__dates__fullDateDisplayed').text(month + " " + day + ", " + year);


// Update the full text date on change

$('.create-booking__dates__block__dates__datePicker').change(function() {
	var theDate = $('.create-booking__dates__block__dates__datePicker').datepicker('getDate', true);
	var theDateFormatted = new Date(theDate);
	var month = theDateFormatted.toLocaleString('default', { month: 'long' });
	var day = theDateFormatted.getDate();
	var year = theDateFormatted.getFullYear();

	$('.create-booking__dates__block__dates__fullDateDisplayed').text(month + " " + day + ", " + year);
});






// Initiate time picker

if (dataFromCreate2) {
	$('#timepicker-start').timepicker({
		timeFormat: 'h:mm p',
		interval: 60,
		defaultTime: dataFromCreate2StartTime,
		dynamic: true,
		dropdown: true,
    	scrollbar: true
	});


	$('#timepicker-end').timepicker({
		timeFormat: 'h:mm p',
		interval: 60,
		defaultTime: dataFromCreate2EndTime,
		dynamic: true,
		dropdown: true,
		scrollbar: true
	});
} else {
	
	$('#timepicker-start').timepicker({
		timeFormat: 'h:mm p',
		interval: 60,
		defaultTime: '8',
		dynamic: true,
		dropdown: true,
		scrollbar: true
	});


	$('#timepicker-end').timepicker({
		timeFormat: 'h:mm p',
		interval: 60,
		defaultTime: '9',
		dynamic: true,
		dropdown: true,
		scrollbar: true
	});
	
}










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
	$('.create-booking__errors__container').hide();
	$('.create-booking__errors').hide();

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
	var theSelectedDate = document.getElementById("datePicker").value;
	
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

		$('.create-booking__errors__container').show();
		$('#no-customer-selected').show();

	} else if ((newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") && existingName !== "") {

		$('.create-booking__errors__container').show();
		$('#both-customer-fields-have-inputs').show();

	} else if (startTimeComparison > endTimeComparison) {
		
		$('.create-booking__errors__container').show();
		$('#start-date-too-large').show();
		
	} else if (newCustomerName !== "" || newCustomerEmail !== "" || newCustomerPhoneNumber !== "") {

		if (newCustomerName === "" || newCustomerEmail === "" || newCustomerPhoneNumber === "") {

			$('.create-booking__errors__container').show();
			$('#missing-fields-new-customer').show();

		} else if (newCustomerAlreadyExists == true) {

			$('.create-booking__errors__container').show();
			$('#new-customer-name-already-exists').show();

		} else if (customerNameContainsSpace == false) {

			$('.create-booking__errors__container').show();
			$('#customer-name-no-space').show();

		} else if (newCustomerName.length < 4) {

			$('.create-booking__errors__container').show();
			$('#customer-name-length').show();

		} else if (newCustomerNameContainsForbiddenCharacters == true) {
		
			$('.create-booking__errors__container').show();
			$('#there-are-forbidden-characters').show();
		
		} else if (newCustomerPhoneNumber.length < 14) {
		
			$('.create-booking__errors__container').show();
			$('#phone-not-long-enough').show();

		} else if (validEmailAddress == false) {
		
			$('.create-booking__errors__container').show();
			$('#non-valid-email').show();
		
		} else {
			document.getElementById("newCustomerBooking").submit();
		}

	} else {

		if (isTheCustomerExisting == false) {

			$('.create-booking__errors__container').show();
			$('#customer-not-exist').show();

		} else {
			document.getElementById("customer-input").required = true;
			
			var $selectedDate = document.getElementById("datePicker").value;
			var $selectedPerson = document.getElementById("customer-input").value;
			var $startTime = $('#timepicker-start').val();
			var $endTime = $('#timepicker-end').val();

			var $hrefLocation = "/booking-create2?data=" + $selectedDate + "-" + $selectedPerson + "-" + $startTime + "-" + $endTime;

			document.getElementById("nextButton").setAttribute("href",$hrefLocation);
		}
	}

}


