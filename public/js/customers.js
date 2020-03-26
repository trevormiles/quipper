// Live Search Rental Items table on create rentals page

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
	
	
	
	// Display "No customers match your search" if all tr's are displaying none
	
	var allPossibleItems = document.querySelectorAll('.customers__customer');
	var isThereAMatch = false;
	
	for (i = 0; i < allPossibleItems.length; i++) {
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