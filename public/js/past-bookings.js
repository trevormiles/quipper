$('.openModal').click(function () {
	// Set up where the form will be sent to
	var theClickedCartID = $(this).closest('.past-bookings__booking').find('.bookingID').val();
	var theFormURL = "/" + theClickedCartID + "/" + "past-booking-delete";
	$('#submitDeleteBooking').attr('action', theFormURL);
});


$('#submit-delete-booking').click(function () {
	$('#submitDeleteBooking').submit();
});

