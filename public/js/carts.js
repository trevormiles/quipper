// Fade out the success modal on load if there is one

$(document).ready(function() {
   window.setTimeout("fadeMyDiv();", 750); //call fade in 3 seconds
 }
)

function fadeMyDiv() {
   $(".carts__success").fadeOut('slow');
}




///////////////// Update the total fields when you input a discount //////////////////
$(".discount__input").keyup(function() {
	
	// Get the itemsSum amount and keep this one constant
	var theTotalItemFeeNotChanging = $(this).closest('.cart-item').find('.total-fee__not-changing').val();
	var theTotalItemFeeNotChanging = theTotalItemFeeNotChanging.replace("$", "");
	
	// Get the itemsSum and change this one to reflect our discounts
	var theTotalItemFee = $(this).closest('.cart-item').find('.total-fee').text();
	var theTotalItemFee = theTotalItemFee.replace("$", "");
	
	// Get the discount amount as its being typed
	var theDiscountAmount = $(this).val();
	theDiscountAmount = theDiscountAmount / 100;
	
	// Calculate how much off the discount gets you
	var amountOffWithDiscount = theTotalItemFeeNotChanging * theDiscountAmount;
	amountOffWithDiscount = amountOffWithDiscount.toFixed(2);
	
	// Minus the amount off with the discount by the total
	var theNewItemTotalWithDiscount = theTotalItemFeeNotChanging - amountOffWithDiscount;
	theNewItemTotalWithDiscount = theNewItemTotalWithDiscount.toFixed(2);
	theNewItemTotalWithDiscount = "$" + theNewItemTotalWithDiscount;
	
	$(this).closest('.cart-item').find('.total-fee').text(theNewItemTotalWithDiscount);
	
	
	
	// Make the total based off of what checkboxes are selected
	var total = 0.00;
	var allLocalCheckboxes = $(this).closest('.carts__cart__body').find('.checkbox-check-out');

	allLocalCheckboxes.each(function() {
		if ($(this).is(':checked')) {
			var thisItemsFee = $(this).closest('.cart-item').find('.total-fee').text();
			var thisItemsFeeNoDollarSign = thisItemsFee.replace("$", "");
			var thisItemsfeeParsed = parseFloat(thisItemsFeeNoDollarSign);

			total = total + thisItemsfeeParsed;
		}
	});

	$(this).closest('.carts__cart__body').find('.carts__bottom__total__number').text("$" + total.toFixed(2));
	
});





// Make the check all functionality work
$('.check-all-check-out-box').click(function () {
	$(this).closest('.carts__cart__body').find('.checkbox-check-out').prop('checked', $(this).prop('checked'));
	
	// Make the total based off of what checkboxes are selected
	var total = 0.00;
	var allLocalCheckboxes = $(this).closest('.carts__cart__body').find('.checkbox-check-out');

	allLocalCheckboxes.each(function() {
		if ($(this).is(':checked')) {
			var thisItemsFee = $(this).closest('.cart-item').find('.total-fee').text();
			var thisItemsFeeNoDollarSign = thisItemsFee.replace("$", "");
			var thisItemsfeeParsed = parseFloat(thisItemsFeeNoDollarSign);

			total = total + thisItemsfeeParsed;
		}
	});

	$(this).closest('.carts__cart__body').find('.carts__bottom__total__number').text("$" + total.toFixed(2));
});






// Make the check all show up if there are more than one

var allCheckAllBoxes = $('.carts__bottom__right');

allCheckAllBoxes.each(function() {
	var localCartContainers = $(this).closest('.carts__cart__body').find('.cart__container');
	if (localCartContainers.length < 2) {
		$(this).hide();
		var thisBottomLeft = $(this).closest('.carts__cart__body').find('.carts__bottom__left');
		thisBottomLeft.css("margin-top", "-5px");
	}
});






$('.checkbox-check-out').click(function () {
	// Make the total based off of what checkboxes are selected
	var total = 0.00;
	var allLocalCheckboxes = $(this).closest('.carts__cart__body').find('.checkbox-check-out');

	allLocalCheckboxes.each(function() {
		if ($(this).is(':checked')) {
			var thisItemsFee = $(this).closest('.cart-item').find('.total-fee').text();
			var thisItemsFeeNoDollarSign = thisItemsFee.replace("$", "");
			var thisItemsfeeParsed = parseFloat(thisItemsFeeNoDollarSign);

			total = total + thisItemsfeeParsed;
		}
	});

	$(this).closest('.carts__cart__body').find('.carts__bottom__total__number').text("$" + total.toFixed(2));
	
});




$('.carts__bottom__submit').click(function () {
	
	// Hide error messages
	$('.carts__no-checked').hide();
	
	var customer = $(this).closest('.cart-form').find('.carts__cart__header__title').text();
	var itemsCheckedToSubmitArray = [customer];
	var allCartCheckboxes = $(this).closest('.carts__cart').find('.checkbox-check-out');
	
	allCartCheckboxes.each(function() {
		if ($(this).is(':checked')) {
			var cartIDs = $(this).closest('.cart-item').find('.cart-item-ids').val();
			itemsCheckedToSubmitArray.push(cartIDs);
		}
	});
	
	var itemsCheckedToSubmitInput = $(this).closest('.cart-form').find('.checkedItemsArray').val(itemsCheckedToSubmitArray);
	var cartForm = $(this).closest('.cart-form');
	
	var amountOfCheckedItems = itemsCheckedToSubmitArray.length;
	
	if (amountOfCheckedItems < 2) {
		
		$(this).closest('.cart-form').find('.carts__no-checked').show();
		
	} else {
		
		cartForm.submit();	
		
	}
	
});




$('.openModal').click(function () {
	// Set up where the form will be sent to
	var theClickedCartID = $(this).closest('.cart-item').find('.cart-item-ids').val();
	var theFormURL = "/" + theClickedCartID + "/" + "cart-delete";
	$('#submitDeleteCart').attr('action', theFormURL);
	
	// Make the text in the modal say "Rentals" or "bookings", unless it's a sales item, then don't show that text
	var theCartItemType = $(this).closest('.cart__container').find('.carts__category__title').text();
	
	$('.carts__modal__delete-sub-title').show();
	
	if (theCartItemType == "Sales") {
		$('.carts__modal__delete-sub-title').hide();
	} else {
		$('.carts__modal__type').text(theCartItemType);
	}
});


$('#submit-delete-cart').click(function () {
	$('#submitDeleteCart').submit();
});

