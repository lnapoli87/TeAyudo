var mapOptions = {
      center: new google.maps.LatLng(-34.921260242018384, -57.954490184783936),
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);
    
    if (cycleCoords != null && cycleCoords != ""){
    	var coordsArray = cycleCoords.split(",");
    	var lat = coordsArray[0].replace("(","");
    	var lng = coordsArray[1].replace(")","");
    	var latlng = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
    	var cycleMarker = new google.maps.Marker({
    		map: map,
    		position: latlng
    	  });
    	map.setCenter(latlng);
    	map.setZoom(17);
    }