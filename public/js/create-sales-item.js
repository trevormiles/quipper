// Hide error messages, and show them below if there are errors
$('#no-name').hide();
$('#no-quantity').hide();
$('#no-price').hide();



$('#createSalesItemPrice').mask('000,000,000,000,000.00', {reverse: true});



// Validation when submit is clicked

$('.create-sales-item__submit').click(function() {
	
	// Hide any previous error messages
	$('.create-sales-item__errors__container').hide();
	$('.create-sales-item__errors').hide();
	
	// Get the values that we'll need
	var salesItemName = $('#createSalesItemName').val();
	var salesItemQuantity = $('#createSalesItemQuantity').val();
	var salesItemPrice = $('#createSalesItemPrice').val();
	
	if (salesItemName == "") {
		
		$('.create-sales-item__errors__container').show();
		$('#no-name').show();
		
	} else if (salesItemQuantity == "") {
		
		$('.create-sales-item__errors__container').show();
		$('#no-quantity').show();
		
	} else if (salesItemPrice == "") {
		
		$('.create-sales-item__errors__container').show();
		$('#no-price').show();
		
	} else {
		document.getElementById("createNewSalesItemForm").submit();
	}
});
