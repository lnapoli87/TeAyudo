$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a.list-group-item").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
    $("div.bhoechie-tab-content>center>div.list-group>div.input-group>a.list-group-item").click(function(e) {
        e.preventDefault();
        $("div.bhoechie-tab-content>center>div.list-group>div.input-group>a.list-group-item").each(function(){
        	$(this).removeClass("active");
        });
        $(this).addClass("active");
        var index = $(this).index();
    });
    $("#newCycleBtn").click(function(e){
    	e.preventDefault();
    	window.location="./create";
    });
    
    $("#seeAll").click(function(e){
    	e.preventDefault();
    	window.location="./all";
    });
});

    var mapOptions = {
      center: new google.maps.LatLng(-34.921260242018384, -57.954490184783936),
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);
    
