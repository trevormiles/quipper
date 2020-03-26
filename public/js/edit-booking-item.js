// Hide error messages, and show them below if there are errors
$('#no-name').hide();
$('#there-are-forbidden-characters').hide();
$('#no-first-hour-rate').hide();
$('#no-additional-hour-rate').hide();



$('#editBookingItemFirstHourRate').mask('000,000,000,000,000.00', {reverse: true});
$('#editBookingItemAdditionalHourRate').mask('000,000,000,000,000.00', {reverse: true});



// Validation when submit is clicked

$('.edit-booking-item__submit').click(function() {
	
	// Hide any previous error messages
	$('.edit-booking-item__errors__container').hide();
	$('.edit-booking-item__errors').hide();
	
	// Get the values that we'll need
	var bookingItemName = $('#editBookingItemName').val();
	var bookingItemFirstHourRate = $('#editBookingItemFirstHourRate').val();
	var bookingItemAdditionalHourRate = $('#editBookingItemAdditionalHourRate').val();
	
	////////////////// See if the item name contains any forbidden characters //////////////////////
	// First, save the true false statements to vars
	var bookingItemNameIncludesAtSign = bookingItemName.includes("@");
	var bookingItemNameIncludesColon = bookingItemName.includes(":");
	var bookingItemNameIncludesQuestionMark = bookingItemName.includes("?");
	
	// Set up a variable and a loop to check if any of the above variables are true
	var bookingItemNameContainsForbiddenCharacters = false;
	
	if (bookingItemNameIncludesAtSign == true || bookingItemNameIncludesColon == true || bookingItemNameIncludesQuestionMark == true) {
		bookingItemNameContainsForbiddenCharacters = true;
	}
	
	if (bookingItemName == "") {
		
		$('.edit-booking-item__errors__container').show();
		$('#no-name').show();
		
	} else if (bookingItemNameContainsForbiddenCharacters == true) {
		
		$('.edit-booking-item__errors__container').show();
		$('#there-are-forbidden-characters').show();
		
	} else if (bookingItemFirstHourRate == "") {
		
		$('.edit-booking-item__errors__container').show();
		$('#no-first-hour-rate').show();
		
	} else if (bookingItemAdditionalHourRate == "") {
		
		$('.edit-booking-item__errors__container').show();
		$('#no-additional-hour-rate').show();
		
	} else {
		document.getElementById("submitEditBookingItemForm").submit();
	}
});
