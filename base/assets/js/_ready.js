/*
 * 	File:     ~/application/js/documentready.js
 *	Author:   Fred McDonald - mcdon048@rangers.uwp.edu
 *	Class:    CS424 - Networked Applications
 */ 

/*
 * 	DOM is ready - manipulate elements and assign events
 */ 
$(function() {
//	console.log("ready!");




/* 	----------
 * 	NAVIGATION
 * 	----------
 */ 

//	Set Navigation Bar reactions
  	$("ul#navigation li").hover(
		function() {$(this).css("color", "#00FF00"); },
		function() {$(this).css("color", "#000000");}
	);


	$("li#home").click(function() {
		window.location.href = document.location.origin + "/tezcatlipoca/index.php/home";
	});

	$("li#location").click(function() {
		window.location.href = document.location.origin + "/tezcatlipoca/index.php/location";
	});

	$("li#about").click(function() {
		window.location.href = document.location.origin + "/tezcatlipoca/index.php/about";
	});



//	Set sidebar (Data selection) reactions
  	$("ul#selectData li").hover(
		function() {
			$(this).css({"font-weight":900,"text-decoration":"underline"});
		},
		function() {
			$(this).css("text-decoration","none");
			setSelectionWeight();
		}
	);

	$("li.weatherSelect").click(function() {
		clearSelectionList();
		$(this).data("selected",true);
		setSelectionWeight();
		loadWeatherData($(this).attr('id'));
	});



/*
 * ---------------------
 * Initial DataSelection
 * ---------------------
 */
//	$("article#weatherData").data("selected","conditions");
//	$("article#weatherData").data("selected","conditions");
	$("li#condition").data("selected",true);
	setSelectionWeight();

/* 	---------
 * 	LOCATIONS
 * 	---------
 */ 

	// Get location by Geolocation API
	$("button#getLocation").click(function() {
		/*
		 * 	Using the GeoIP Database, get a JSON object with the current
		 * 	location, according to the IP address. (Not 100% accurate, but
		 *  easy enough to do.)
		 */ 
		$.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?').done (function(geo) {
			/*
			 * 	Got a result - now using the state and city field from the
			 * 	resulting JSON, display in fields on location page.
			 */
			 
			 $("input#newCity").val(geo.city);
			 $("input#newState").val(geo.state);
		 });
		 // TODO: location lookup failure
	});


	// Add new weather location to cookie
	$("button#addLocation").click(function() {
		/*
		 *	Locations are stored as an array of tuples:
		 * 		city, state
		 */ 
		var curCookie = readCookie('location');
		var newCookie = new Array();
			// newLoc -> tuple of city, state
		var newLoc = [$("input#newCity").val(), $("input#newState").val()];
		// 
		if (curCookie) {
			l = curCookie.length;
			for (i = 0; i < l; i++) {
				newCookie.push(curCookie[i]);
			}
		}
		newCookie.push(newLoc);
		createCookie('location',newCookie,365);
		
		window.location.href = document.location.origin + "/tezcatlipoca/index.php/location";
	});
});






function setSelectionWeight() {
	$("ul#selectData li").each(function(i, obj) {
		if ($(this).data("selected")) {
			$(this).css("font-weight",700);
		} else {
			$(this).css("font-weight",400);
		};
	});
}

function clearSelectionList() {
	$("ul#selectData li").each(function(i, obj) {
		$(this).removeData("selected");
	});
}

