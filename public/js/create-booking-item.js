// Hide error messages, and show them below if there are errors
$('#no-name').hide();
$('#there-are-forbidden-characters').hide();
$('#no-first-hour-rate').hide();
$('#no-additional-hour-rate').hide();



$('#createBookingItemFirstHourRate').mask('000,000,000,000,000.00', {reverse: true});
$('#createBookingItemAdditionalHourRate').mask('000,000,000,000,000.00', {reverse: true});




// Validation when submit is clicked

$('.create-booking-item__submit').click(function() {
	
	// Hide any previous error messages
	$('.create-booking-item__errors__container').hide();
	$('.create-booking-item__errors').hide();
	
	// Get the values that we'll need
	var bookingItemName = $('#createBookingItemName').val();
	var bookingItemFirstHourRate = $('#createBookingItemFirstHourRate').val();
	var bookingItemAdditionalHourRate = $('#createBookingItemAdditionalHourRate').val();
	
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
		
		$('.create-booking-item__errors__container').show();
		$('#no-name').show();
		
	} else if (bookingItemNameContainsForbiddenCharacters == true) {
		
		$('.create-booking-item__errors__container').show();
		$('#there-are-forbidden-characters').show();
		
	} else if (bookingItemFirstHourRate == "") {
		
		$('.create-booking-item__errors__container').show();
		$('#no-first-hour-rate').show();
		
	} else if (bookingItemAdditionalHourRate == "") {
		
		$('.create-booking-item__errors__container').show();
		$('#no-additional-hour-rate').show();
		
	} else {
		document.getElementById("createNewBookingItemForm").submit();
	}
});
