// Hide error messages, and show them below if there are errors
$('#no-name').hide();
$('#no-quantity').hide();
$('#no-price').hide();



$('#editSalesItemPrice').mask('000,000,000,000,000.00', {reverse: true});



// Validation when submit is clicked

$('.edit-sales-item__submit').click(function() {
	
	// Hide any previous error messages
	$('.edit-sales-item__errors__container').hide();
	$('.edit-sales-item__errors').hide();
	
	// Get the values that we'll need
	var salesItemName = $('#editSalesItemName').val();
	var salesItemQuantity = $('#editSalesItemQuantity').val();
	var salesItemPrice = $('#editSalesItemPrice').val();
	
	
	if (salesItemName == "") {
		
		$('.edit-sales-item__errors__container').show();
		$('#no-name').show();
		
	} else if (salesItemQuantity == "") {
		
		$('.edit-sales-item__errors__container').show();
		$('#no-quantity').show();
		
	} else if (salesItemPrice == "") {
		
		$('.edit-sales-item__errors__container').show();
		$('#no-price').show();
		
	} else {
		document.getElementById("submitEditSalesItemForm").submit();
	}
});
