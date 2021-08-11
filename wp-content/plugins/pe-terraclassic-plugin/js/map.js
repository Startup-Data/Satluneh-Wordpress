/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

// Google Maps
window.pemaps = {};

function pe_init_map(mapID, options, latitude, longitude, tooltip) {
	var location = new google.maps.LatLng(latitude, longitude);
	var bounds = new google.maps.LatLngBounds();
	var map = new google.maps.Map(document.getElementById(mapID), options);
	var marker = new google.maps.Marker({
		position: location,
		map: map,
	});

	// add tootltip
	var infoWindow = new google.maps.InfoWindow({
		content: tooltip,
	});

	if (tooltip != 'disable') {
		infoWindow.open(mapID, marker);
		google.maps.event.addListener(marker, 'click', function () {
			infoWindow.open(mapID, marker);
		});
	}

	//create object
	window.pemaps[mapID] = {
		map: map,
		marker: marker,
		infoWindow: infoWindow,
		tooltip: tooltip,
	}

}
