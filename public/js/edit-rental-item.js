// Hide error messages, and show them below if there are errors
$('#no-name').hide();
$('#there-are-forbidden-characters').hide();
$('#no-quantity').hide();
$('#no-first-day-rate').hide();
$('#no-second-day-rate').hide();



$('#editRentalItemFirstDayRate').mask('000,000,000,000,000.00', {reverse: true});
$('#editRentalItemSecondDayRate').mask('000,000,000,000,000.00', {reverse: true});



// Validation when submit is clicked

$('.edit-rental-item__submit').click(function() {
	
	// Hide any previous error messages
	$('.edit-rental-item__errors__container').hide();
	$('.edit-rental-item__errors').hide();
	
	// Get the values that we'll need
	var rentalItemName = $('#editRentalItemName').val();
	var rentalItemQuantity = $('#editRentalItemQuantity').val();
	var rentalItemFirstDayRate = $('#editRentalItemFirstDayRate').val();
	var rentalItemSecondDayRate = $('#editRentalItemSecondDayRate').val();
	
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
		
		$('.edit-rental-item__errors__container').show();
		$('#no-name').show();
		
	} else if (rentalItemNameContainsForbiddenCharacters == true) {
		
		$('.edit-rental-item__errors__container').show();
		$('#there-are-forbidden-characters').show();
		
	}  else if (rentalItemQuantity == "") {
		
		$('.edit-rental-item__errors__container').show();
		$('#no-quantity').show();
		
	} else if (rentalItemFirstDayRate == "") {
		
		$('.edit-rental-item__errors__container').show();
		$('#no-first-day-rate').show();
		
	} else if (rentalItemSecondDayRate == "") {
		
		$('.edit-rental-item__errors__container').show();
		$('#no-second-day-rate').show();
		
	} else {
		document.getElementById("submitEditRentalItemForm").submit();
	}
});
