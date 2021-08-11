// Google Map
function PEinitializeContactMap() {

	var location = new google.maps.LatLng(parseFloat(pe_cm_vars.lati), parseFloat(pe_cm_vars.longi));

	var options = {
		center: location,
		zoom: parseInt(pe_cm_vars.zoom),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
	};
	var map = new google.maps.Map(document.getElementById('map_canvas'), options);

	var marker = new google.maps.Marker({
		position: location,
		map: map,
	});

	var address = pe_cm_vars.address;
	var tooltip = pe_cm_vars.tooltip;

	var infoWindow = new google.maps.InfoWindow({
		content: address,
	});

	if (tooltip == 'true') {
		infoWindow.open(map, marker);
	}
	google.maps.event.addListener(marker, 'click', function () {
		infoWindow.open(map, marker);
	});

}
google.maps.event.addDomListener(window, 'load', PEinitializeContactMap);
