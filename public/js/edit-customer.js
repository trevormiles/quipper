// Hide error messages, and show them below if there are errors
$('#no-name').hide();
$('#new-customer-name-already-exists').hide();
$('#customer-name-no-space').hide();
$('#customer-name-length').hide();
$('#there-are-forbidden-characters').hide();
$('#no-phone').hide();
$('#non-valid-email').hide();
$('#no-email').hide();
$('#phone-not-long-enough').hide();



// Make phone number input do what we want
$('#editCustomerPhone').mask('(000) 000-0000');

// Grab what the current customer name is before clicking on submit edit
var oldCustomerName = $('#editCustomerName').val();



// Validation when submit is clicked

$('.edit-customer__submit').click(function() {
	
	// Hide any previous error messages
	$('.edit-customer__errors__container').hide();
	$('.edit-customer__errors').hide();
	
	// Get the values that we'll need
	var customerName = $('#editCustomerName').val();
	var customerPhone = $('#editCustomerPhone').val();
	var customerEmail = $('#editCustomerEmail').val();
	
	////////////////// See if the item name contains any forbidden characters //////////////////////
	// First, save the true false statements to vars
	var customerNameIncludesAtSign = customerName.includes("@");
	var customerNameIncludesColon = customerName.includes(":");
	var customerNameIncludesQuestionMark = customerName.includes("?");
	var customerNameIncludesDash = customerName.includes("-");
	var customerNameIncludesSlash = customerName.includes("/");
	
	// Set up a variable and a loop to check if any of the above variables are true
	var customerNameContainsForbiddenCharacters = false;
	
	
	// Check if name already exists
	var newCustomerAlreadyExists = false;
	var customerOptionNames = document.querySelectorAll('#customerOptions li');
	var customerOptionNamesArray = [];	

	for (i = 0; i < customerOptionNames.length; ++i) {
		if (customerOptionNames[i].innerText !== oldCustomerName) {
			var newCustomerOption = customerOptionNames[i].innerText;
			customerOptionNamesArray.push(newCustomerOption);	
		}
	}

	for (i = 0; i < customerOptionNamesArray.length; ++i) {
		if (customerOptionNamesArray[i] === customerName) {
			var newCustomerAlreadyExists = true;
		}
	}
	
	
	// Set up the email validation, making sure there is an @ symbol
	var validEmailAddress = false;
	if (customerEmail.includes("@")) {
		validEmailAddress = true;
	}
	
	// Check if name contains a space
	var customerNameContainsSpace = false;
	if (customerName.match(/\s/g)) {
		customerNameContainsSpace = true;
	}
	
	
	
	if (customerNameIncludesAtSign == true || customerNameIncludesColon == true || customerNameIncludesQuestionMark == true || customerNameIncludesDash == true || customerNameIncludesSlash == true) {
		customerNameContainsForbiddenCharacters = true;
	}
	
	if (customerName == "") {
		
		$('.edit-customer__errors__container').show();
		$('#no-name').show();
		
	} else if (newCustomerAlreadyExists == true) {

		$('.edit-customer__errors__container').show();
		$('#new-customer-name-already-exists').show();

	} else if (customerNameContainsSpace == false) {

		$('.edit-customer__errors__container').show();
		$('#customer-name-no-space').show();

	} else if (customerName.length < 4) {

		$('.edit-customer__errors__container').show();
		$('#customer-name-length').show();

	} else if (customerNameContainsForbiddenCharacters == true) {
		
		$('.edit-customer__errors__container').show();
		$('#there-are-forbidden-characters').show();
		
	}  else if (customerPhone == "") {
		
		$('.edit-customer__errors__container').show();
		$('#no-phone').show();
		
	} else if (customerPhone.length < 14) {
		
		$('.edit-customer__errors__container').show();
		$('#phone-not-long-enough').show();
		
	} else if (customerEmail == "") {
		
		$('.edit-customer__errors__container').show();
		$('#no-email').show();
		
	} else if (validEmailAddress == false) {
		
		$('.edit-customer__errors__container').show();
		$('#non-valid-email').show();
		
	} else {
		document.getElementById("editCustomerForm").submit();
	}
});
