/*
 * 	File:     ~/application/js/functions.js
 *	Author:   Fred McDonald - mcdon048@rangers.uwp.edu
 *	Class:    CS424 - Networked Applications
 */ 

// Get location by Geolocation API
function get_geolocation() {
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
}

function getWeatherData(location, whatData) {
		/*
		 * Paramenters:
		 *   location - state + / + city
		 * 	 whatData - what data to retreive from Wunderground
		 *  
		 * 	Using the parameters, create URI to access
		 *  Wunderground API and (hopefully) get a JSON object
		 *  of valid Wunderground locations
		 */ 
		 
		/*
		 * Valid input for whatData parameters
		 * 		conditions
		 */
		 
		var urlBase = 'http://api.wunderground.com/api/abc8c7cfc1f0b4d6/geolookup/';
//		conditions/q/'+geo.state+'/'+geo.city+'.json';
		var url = urlBase + whatData + "/q/" + location + ".json";

		$.getJSON(url).done (function(loc) {
			// Display results
         });
         // TODO: Wunderground API failure
}



/*
 *	Add new weather location to the local cookie
 * 		locations are stored as an array of tuples:
 * 			city, state
 */ 
function addNewLocation() {
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
}


/*
 * 	Cookie manipulation courtesy of http://www.quirksmode.org/js/cookies.html
 */ 
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}
