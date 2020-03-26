// Side Menu Navigation Functionality

$(".navbar__side-menu__dropdown-link").click(function () {
	$(this).toggleClass("down");
});

$('.navbar__menu-toggler').click(function() {
	$('.side-menu-overlay').fadeIn(400);
});

$('.navbar__side-menu__closebtn').click(function() {
	$('.side-menu-overlay').fadeOut(400);
});

$('.side-menu-overlay').click(function() {
	$('.side-menu-overlay').fadeOut(400);
});

$('.side-menu-overlay').click(closeNav);


function openNav() {
	document.getElementById("navbar__side-menu").style.width = "350px";
}

function closeNav() {
	document.getElementById("navbar__side-menu").style.width = "0";
}
