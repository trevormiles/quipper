////////////////////////////////// Modal Checkout //////////////////////////////

$('#check-all-check-out-box').click(function () {
    $(".checkbox-check-out").prop('checked', $(this).prop('checked'));
});


$('#submit-check-out').click(function() {
	
	var itemsCheckOutArray = [];
	var checkOutItems = document.querySelectorAll(".show-rental__modal__item-container-check-out");
	
	for (i = 0; i < checkOutItems.length; i++) {
		
		var currentItem = checkOutItems[i];
		
		var itemTitle = currentItem.querySelector(".show-rental__modal__item__name").textContent;

		var itemQuantity = currentItem.querySelector(".show-rental__modal__item__quantity").textContent;

		var itemDays = currentItem.querySelector(".show-rental__modal__item__amount-of-days").textContent;

		var itemFirstRate = currentItem.querySelector(".show-rental__modal__item__first-day-rate").textContent;

		var itemSecondRate = currentItem.querySelector(".show-rental__modal__item__second-day-rate").textContent;

		var itemTotal = currentItem.querySelector(".show-rental__modal__item__total").textContent;

		if (currentItem.classList.contains('show-rental__modal__item-container-check-out__already-checked-out')) {
			var itemStatus = "Checked Out";
		} else if (currentItem.classList.contains('show-rental__modal__item-container-check-out__item-is-checked-in')) {
			var itemStatus = "Checked In";
		} else {
			if (currentItem.querySelector(".checkbox-check-out").checked) {
				var itemStatus = "Checked Out";
			} else {
				var itemStatus = "Reserved";
			}	
		}
		
		
		itemCheckedOutArray = [itemTitle, itemQuantity, itemDays, itemFirstRate, itemSecondRate, itemTotal, itemStatus];
		itemsCheckOutArray.push(itemCheckedOutArray);
		
	}

	var itemsCheckOutArrayStringified = JSON.stringify(itemsCheckOutArray);
	$('.show-rental__items-check-out').val(itemsCheckOutArrayStringified);
	
	
	
	
	var checkedInItems = [];
	var checkedOutItems = [];
	var reservedItems = [];
	
	for (i = 0; i < itemsCheckOutArray.length; i++) {
		if (itemsCheckOutArray[i][6] === "Checked In") {
			checkedInItems.push("Checked In Item");
		} else if (itemsCheckOutArray[i][6] === "Checked Out") {
			checkedOutItems.push("Checked Out Item");   
		} else if (itemsCheckOutArray[i][6] === "Reserved") {
			reservedItems.push("Reserved Item");   
		}
	}
	
	
	if (reservedItems.length == 0 && checkedOutItems.length == 0) {
		$('#checked-out-items-status').val("Checked In");
	} else if (checkedOutItems.length == 0 && checkedInItems.length == 0) {
		$('#checked-out-items-status').val("Reserved");
	} else if (checkedInItems.length == 0 && reservedItems.length == 0) {
		$('#checked-out-items-status').val("Checked Out");  
	} else if (reservedItems.length != 0 && checkedOutItems.length != 0 && checkedInItems.length == 0) {
		$('#checked-out-items-status').val("Partially Out");   
	} else if (reservedItems.length == 0 && checkedOutItems.length != 0 && checkedInItems.length != 0) {
		$('#checked-out-items-status').val("Partially In");   
	} else {
		$('#checked-out-items-status').val("Mixed");
	}
	
	
	
	
	
	$('#submitCheckOut').submit();
	
});









////////////////////////////////// Modal Checkin //////////////////////////////

$('#check-all-check-in-box').click(function () {
    $(".checkbox-check-in").prop('checked', $(this).prop('checked'));
});


$('#submit-check-in').click(function() {
	
	var itemsCheckInArray = [];
	var checkInItems = document.querySelectorAll(".show-rental__modal__item-container-check-in");
	
	for (i = 0; i < checkInItems.length; i++) {
		
		var currentItem = checkInItems[i];
		
		var itemTitle = currentItem.querySelector(".show-rental__modal__item__name").textContent;

		var itemQuantity = currentItem.querySelector(".show-rental__modal__item__quantity").textContent;

		var itemDays = currentItem.querySelector(".show-rental__modal__item__amount-of-days").textContent;

		var itemFirstRate = currentItem.querySelector(".show-rental__modal__item__first-day-rate").textContent;

		var itemSecondRate = currentItem.querySelector(".show-rental__modal__item__second-day-rate").textContent;

		var itemTotal = currentItem.querySelector(".show-rental__modal__item__total").textContent;

		if (currentItem.classList.contains('show-rental__modal__item-container-check-in__already-checked-in')) {
			var itemStatus = "Checked In";
		} else if (currentItem.classList.contains('show-rental__modal__item-container-check-in__not-yet-checked-out')) {
			var itemStatus = "Reserved";
		} else {
			if (currentItem.querySelector(".checkbox-check-in").checked) {
				var itemStatus = "Checked In";
			} else {
				var itemStatus = "Checked Out";
			}	
		}
		
		
		itemCheckedInArray = [itemTitle, itemQuantity, itemDays, itemFirstRate, itemSecondRate, itemTotal, itemStatus];
		itemsCheckInArray.push(itemCheckedInArray);
		
	}

	var itemsCheckInArrayStringified = JSON.stringify(itemsCheckInArray);
	$('.show-rental__items-check-in').val(itemsCheckInArrayStringified);
	
	
	var checkedInItems = [];
	var checkedOutItems = [];
	var reservedItems = [];
	
	for (i = 0; i < itemsCheckInArray.length; i++) {
		if (itemsCheckInArray[i][6] === "Checked In") {
			checkedInItems.push("Checked In Item");
		} else if (itemsCheckInArray[i][6] === "Checked Out") {
			checkedOutItems.push("Checked Out Item");   
		} else if (itemsCheckInArray[i][6] === "Reserved") {
			reservedItems.push("Reserved Item");   
		}
	}
	
	
	if (reservedItems.length == 0 && checkedOutItems.length == 0) {
		$('#check-in-status').val("inactive");
	} else {
		$('#check-in-status').val("active");
	}
	
	
	if (reservedItems.length == 0 && checkedOutItems.length == 0) {
		$('#checked-in-items-status').val("Checked In");
	} else if (checkedOutItems.length == 0 && checkedInItems.length == 0) {
		$('#checked-in-items-status').val("Reserved");
	} else if (checkedInItems.length == 0 && reservedItems.length == 0) {
		$('#checked-in-items-status').val("Checked Out");  
	} else if (reservedItems.length != 0 && checkedOutItems.length != 0 && checkedInItems.length == 0) {
		$('#checked-in-items-status').val("Partially Out");   
	} else if (reservedItems.length == 0 && checkedOutItems.length != 0 && checkedInItems.length != 0) {
		$('#checked-in-items-status').val("Partially In");   
	} else {
		$('#checked-in-items-status').val("Mixed");
	}
	
	
	$('#submitCheckIn').submit();
	
});











////////////////////////////////// Delete Rental //////////////////////////////

$('#submit-delete-rental').click(function () {
    $('#submitDeleteRental').submit();
});