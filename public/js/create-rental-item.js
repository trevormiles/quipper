// Hide error messages, and show them below if there are errors
$('#no-name').hide();
$('#there-are-forbidden-characters').hide();
$('#no-quantity').hide();
$('#no-first-day-rate').hide();
$('#no-second-day-rate').hide();



$('#createRentalItemFirstDayRate').mask('000,000,000,000,000.00', {reverse: true});
$('#createRentalItemSecondDayRate').mask('000,000,000,000,000.00', {reverse: true});



// Validation when submit is clicked

$('.create-rental-item__submit').click(function() {
	
	// Hide any previous error messages
	$('.create-rental-item__errors__container').hide();
	$('.create-rental-item__errors').hide();
	
	// Get the values that we'll need
	var rentalItemName = $('#createRentalItemName').val();
	var rentalItemQuantity = $('#createRentalItemQuantity').val();
	var rentalItemFirstDayRate = $('#createRentalItemFirstDayRate').val();
	var rentalItemSecondDayRate = $('#createRentalItemSecondDayRate').val();
	
	////////////////// See if the item name contains any forbidden characters //////////////////////
	// First, save the true false statements to vars
	var rentalItemNameIncludesAtSign = rentalItemName.includes("@");
	var rentalItemNameIncludesColon = rentalItemName.includes(":");
	var rentalItemNameIncludesQuestionMark = rentalItemName.includes("?");
	
	// Set up a variable and a loop to check if any of the above variables are true
	var rentalItemNameContainsForbiddenCharacters = false;
	
	if (rentalItemNameIncludesAtSign == true || rentalItemNameIncludesColon == true || rentalItemNameIncludesQuestionMark == true) {
		rentalItemNameContainsForbiddenCharacters = true;
	}
	
	if (rentalItemName == "") {
		
		$('.create-rental-item__errors__container').show();
		$('#no-name').show();
		
	} else if (rentalItemNameContainsForbiddenCharacters == true) {
		
		$('.create-rental-item__errors__container').show();
		$('#there-are-forbidden-characters').show();
		
	}  else if (rentalItemQuantity == "") {
		
		$('.create-rental-item__errors__container').show();
		$('#no-quantity').show();
		
	} else if (rentalItemFirstDayRate == "") {
		
		$('.create-rental-item__errors__container').show();
		$('#no-first-day-rate').show();
		
	} else if (rentalItemSecondDayRate == "") {
		
		$('.create-rental-item__errors__container').show();
		$('#no-second-day-rate').show();
		
	} else {
		document.getElementById("createNewRentalItemForm").submit();
	}
});
