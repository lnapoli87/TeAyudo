var mapOptions = {
      center: new google.maps.LatLng(-34.921260242018384, -57.954490184783936),
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);
    var markers = [];

var input = (document.getElementById('searchBoxInput'));
map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
var searchBox = (new google.maps.places.SearchBox(input));

google.maps.event.addListener(searchBox, 'places_changed', function() {
	var places = searchBox.getPlaces();

	if (places.length == 0) {
		return;
	}
	for (var i = 0, marker; marker = markers[i]; i++) {
		marker.setMap(null);
	}

	// For each place, get the icon, place name, and location.
	markers = [];
	var bounds = new google.maps.LatLngBounds();
	for (var i = 0, place; place = places[i]; i++) {
		var image = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)
		};

		// Create a marker for each place.
		var marker = new google.maps.Marker({
			map: map,
			icon: image,
			title: place.name,
			position: place.geometry.location
		});

		markers.push(marker);

		bounds.extend(place.geometry.location);
	}

	map.fitBounds(bounds);
});
google.maps.event.addListener(map, 'bounds_changed', function() {
	var bounds = map.getBounds();
	searchBox.setBounds(bounds);
});

var marker = new google.maps.Marker({
  });


google.maps.event.addListener(map, 'click', function(scope) {
	marker.setPosition(scope.latLng);
	marker.setMap(map);
	$("#hiddenLatLng").val(scope.latLng.toString());
  });

var parseLatLngString = function parseLatLngString(coordsString){
	var splitedCoords = coordsString.split(", ");
	var lat = splitedCoords[0].replace("(","");
	var lng = splitedCoords[1].replace(")","");
	var latLngObj = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
	return latLngObj;
};