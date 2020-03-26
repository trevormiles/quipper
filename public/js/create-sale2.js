// Make arrows on the categories turn on click
$('.card-header').click(function() {
	$(this).toggleClass("down");
});




// Hide errors initially and then show them if triggered below
$('#quantity-is-zero').hide();
$('#item-already-in-cart').hide();
$('#no-items-have-been-added').hide();






// Create the list of items, make an array, convert the array to stringified JSON, add that string to the value of the Items form input

var itemsArray = [];
var itemArray = [];
var itemsSum = 0;


$('.itemsFormInput').hide();



// If you click on an add item button in the quick search

$('.addItemToList').click(function() {
	
	
	// Hide any previous error messages
	$('.create-sale__errors__container').hide();
	$('.create-sale__errors').hide();
	
	
	
	// First add li elements to the ul, making necessary variables first
	
	var itemTitle = $(this).closest('tr').find('.itemsListInputTitle').val();
	var itemQuantity = $(this).closest('tr').find('.itemsListInputQuantity').val();
	
	var itemPrice = $(this).closest('tr').find('.itemPrice').val();
	
	var itemTotal = itemPrice * itemQuantity;
	var itemTotalDecimal = itemTotal.toFixed(2);
	
	
	// See if this item has already been added to the cart, which will trigger in the if statement below
	var hasItemAlreadyBeenAdded = false;
	
	for (i = 0; i < itemsArray.length; i++) {
		if (itemsArray[i][0] === itemTitle) {
			hasItemAlreadyBeenAdded = true;
		}
	}
	
	
	
	if ( itemQuantity == 0 ) {
		
		$('.create-sale__errors__container').show();
		$('#quantity-is-zero').show();
		
	} else if (hasItemAlreadyBeenAdded == true) {
		
		$('.create-sale__errors__container').show();
		$('#item-already-in-cart').show();
		
	} else {
		
		$('.itemsList').append(
		'<li class="inputedItem create-sale__cart__item">'
			+ '<span class="create-sale__cart__item__name">' + itemTitle + '</span>'
			+ '<span class="create-sale__cart__item__price">' + '$' + itemPrice + '</span>'
			+ '<span class="create-sale__cart__item__quantity">' + itemQuantity + '</span>'
			+ '<span class="create-sale__cart__item__total">' + '$' + itemTotalDecimal + '</span>'
			+ '<span class="create-sale__cart__item__remove">' + '<i class="fas fa-times create-sale__cart__item__remove__x"></i>' + '</span>'
		+ '</li>' );
	
	
	
		// Reset the quantity input back to blank

		$('.itemsListInputQuantity').val('');


		// Now create the array and then convert it to JSON String

		itemArray = [itemTitle, itemQuantity, itemPrice, itemTotal];
		itemsArray.push(itemArray);

		var itemsArrayStringified = JSON.stringify(itemsArray);
		$('.itemsFormInput').val(itemsArrayStringified);



		// Add up the total for all the items
		itemsSum = Number(itemsSum) + Number(itemTotalDecimal);
		itemsSum = itemsSum.toFixed(2);



		// Update item total to the cart
		$('.create-sale__cart__total__number').text(itemsSum);

	}
	
});







// If you click on an add item button in the category area

$('.addItemToListByCategory').click(function() {
	
	
	// Hide any previous error messages
	$('.create-sale__errors__container').hide();
	$('.create-sale__errors').hide();
	
	
	
	// First add li elements to the ul, making necessary variables first
	
	var itemTitle = $(this).closest('span').find('.itemsListInputTitle').val();
	var itemQuantity = $(this).closest('span').find('.itemsListInputQuantity').val();
	
	var itemPrice = $(this).closest('span').find('.itemPrice').val();
	
	var itemTotal = itemPrice * itemQuantity;
	var itemTotalDecimal = itemTotal.toFixed(2);
	
	
	// See if this item has already been added to the cart, which will trigger in the if statement below
	var hasItemAlreadyBeenAdded = false;
	
	for (i = 0; i < itemsArray.length; i++) {
		if (itemsArray[i][0] === itemTitle) {
			hasItemAlreadyBeenAdded = true;
		}
	}
	
	
	
	if ( itemQuantity == 0 ) {
		
		$('.create-sale__errors__container').show();
		$('#quantity-is-zero').show();
		
	} else if (hasItemAlreadyBeenAdded == true) {
		
		$('.create-sale__errors__container').show();
		$('#item-already-in-cart').show();
		
	} else {
		
		$('.itemsList').append(
		'<li class="inputedItem create-sale__cart__item">'
			+ '<span class="create-sale__cart__item__name">' + itemTitle + '</span>'
			+ '<span class="create-sale__cart__item__price">' + '$' + itemPrice + '</span>'
			+ '<span class="create-sale__cart__item__quantity">' + itemQuantity + '</span>'
			+ '<span class="create-sale__cart__item__total">' + '$' + itemTotalDecimal + '</span>'
			+ '<span class="create-sale__cart__item__remove">' + '<i class="fas fa-times create-sale__cart__item__remove__x"></i>' + '</span>'
		+ '</li>' );
	
	
	
		// Reset the quantity input back to blank

		$('.itemsListInputQuantity').val('');


		// Now create the array and then convert it to JSON String

		itemArray = [itemTitle, itemQuantity, itemPrice, itemTotal];
		itemsArray.push(itemArray);

		var itemsArrayStringified = JSON.stringify(itemsArray);
		$('.itemsFormInput').val(itemsArrayStringified);



		// Add up the total for all the items
		itemsSum = Number(itemsSum) + Number(itemTotalDecimal);
		itemsSum = itemsSum.toFixed(2);



		// Update item total to the cart
		$('.create-sale__cart__total__number').text(itemsSum);

	}
	
});






// Make the x functionality work

$(document).on('click', '.create-sale__cart__item__remove__x', function() {
	
	// Get the name of the item to cancel
	var nameOfItemToCancel = $(this).closest('.create-sale__cart__item').find('.create-sale__cart__item__name').text();
	
	// Get the price total of the item to cancel and turn it into a number
	var totalOfItemToCancel = $(this).closest('.create-sale__cart__item').find('.create-sale__cart__item__total').text();
	totalOfItemToCancel = totalOfItemToCancel.replace('$', '');
	totalOfItemToCancel = Number(totalOfItemToCancel);
	totalOfItemToCancel = totalOfItemToCancel.toFixed(2);
	
	// Remove the item from the list
	$(this).closest('.create-sale__cart__item').remove();
	
	// Remove the item from the array
	for (var i = itemsArray.length -1; i >= 0; i--) {
		
		if (itemsArray[i][0] === nameOfItemToCancel) {
			itemsArray.splice(i, 1);
		}
	}
	
	// Update the input value with the updated array
	var itemsArrayStringified = JSON.stringify(itemsArray);
	$('.itemsFormInput').val(itemsArrayStringified);
	
	// Update the itemsSum total
	itemsSum = itemsSum - totalOfItemToCancel;
	itemsSum = itemsSum.toFixed(2);
	
	// Update itemsSum total to the cart
	$('.create-sale__cart__total__number').text(itemsSum);
	
});








// Submit the itemsSum value when the create reservation button is clicked, check whether or not items have been added to the cart, and submit the reservation.

$('.createNewSaleSubmit').click(function() {
	
	// Hide any previous error messages
	$('.create-sale__errors__container').hide();
	$('.create-sale__errors').hide();
	
	$('.itemsSum').val(itemsSum);
	
	if (itemsArray.length == 0) {
		
		$('.create-sale__errors__container').show();
		$('#no-items-have-been-added').show();
		
	} else {
		document.getElementById("submit-sale").submit();
	}
});




// Live Search Rental Items table on create rentals page

$('#myTable').hide();


function myFunction() {
	
  $('#myTable').show();
	
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
	
	if(document.getElementById("myInput").value === "") {
		$('#myTable').hide();
	}
	
	
	
	// Display "No sales items match your search" if all tr's are displaying none
	
	var allPossibleItems = document.querySelectorAll('.create-sale__quick-search__item-row');
	var isThereAMatch = false;
	
	for (i = 0; i < allPossibleItems.length; ++i) {
		var itemDisplayProperty = allPossibleItems[i].currentStyle ? allPossibleItems[i].currentStyle.display : getComputedStyle(allPossibleItems[i], null).display;
		
		if (itemDisplayProperty !== "none") {
			isThereAMatch = true;
		}
	}
	
	if (isThereAMatch == true) {
		document.getElementById("noMatchesItemsTable").style.display = "none";
	} else {
		document.getElementById("noMatchesItemsTable").style.display = "block";
	}
	
}
