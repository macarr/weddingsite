function init_map() {
	var var_location = new google.maps.LatLng(44.5512698,-79.6816347);

	var var_mapoptions = {
		center: var_location,
		zoom:14
	};

	var var_marker = new google.maps.Marker({
		position: var_location,
		map: var_map,
		title:"The Heights"
	});

	var var_map = new google.maps.Map(document.getElementById("map-container"),
		var_mapoptions);
	
	var_marker.setMap(var_map);

}