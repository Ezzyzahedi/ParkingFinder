/**
 * Initialize a search results map with some hardcoded samples, set a
 * sample centre and some hardcoded markers, the addMarkers function
 * described below will probably be used in the future when the database
 * is online to added individual samples
 * @return null
 */
function initMap() {
    /**
     * create the map with the properties previously defined
     * @type {google.maps.Map}
     */
    return new google.maps.Map(document.getElementById('map'), {
        center: { lat: 43.2609, lng: -79.9192 }, // mcmaster university
        zoom: 15
    });

}

// returns an html div for info window on a map
function formatContent(id, name, desc, cost) {
    return '<div><h3><a href="parking.php?id=' + id + '">' +
        name + '</a></h3><p>' +
        desc + '</p><p>' +
        cost + '$/h</p></div>';

}

// returns a table entry.
function formatRow(id, name, lat, lon, cost) {
    return '<tr><td><a href="parking.php?id=' + id + '">' + 
        name + '</a></td><td>' + 
        lat + '</td><td>' +
        lon + '</td><td>' +
        cost + '$/h</td></tr>';
}
/**
 * add a marker to a map object with certain matching parameters with a dictionary,
 * so far only a minimal amount of paramenters are needed, the link to the
 * individual object is embedded inside the content
 * @param {google.maps.Map} map    the map which inherits the marker
 * @param {Object} params a parameters dictionary
 */
function addMarker(map, params) {
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(params.position),
        title: params.title,
        label: params.label,
        map: map
    });
    console.log(params.content);
    var info = new google.maps.InfoWindow({
          content: params.content
    });



    /**
     * Add a listener to the marker so the decription with the embedded link
     * pops up when you click it
     * @return {null}
     */
    marker.addListener('click', function() {
        info.open(map, marker);
    });
    return marker;
}

/**
 * ajax call for the displaying a map we fetch all the markers 
 * that were sent by the GET request from search.php by converting
 * it to a POST request.
 */
$(document).ready( function() {
    $.ajax({
        type: "POST",
        url: "resources/searchhandler.php",
        data: window.location.href.split("?")[1],
        success: function(json_data) {
            var url = new URL(window.location.href);
            var maxPrice = url.searchParams.get("maxPrice");
            var minPrice = url.searchParams.get("minPrice");
            var userLat = url.searchParams.get("lat");
            var userLon = url.searchParams.get("lon");
            var userLatLon = new google.maps.LatLng(parseFloat(userLat), parseFloat(userLon));
            var dist = url.searchParams.get("dist");
            console.table(json_data);

            // initialize the map
            var map = initMap();
            var bounds = new google.maps.LatLngBounds();

            var markers = json_data;

            // add every marker to the map with an info window
            for (var i = 0; i < markers.length; i++) {
                var markerLatLon = new google.maps.LatLng(parseFloat(markers[i]['lat']), parseFloat(markers[i]['lon']));

                //check for price and distance restraints
                if ((maxPrice == "" || markers[i]['cost'] <= maxPrice) &&
                    (minPrice == "" || markers[i]['cost'] >= minPrice) &&
                    ((userLat == "" || userLon == "" || dist == "") || 
                        google.maps.geometry.spherical.computeDistanceBetween(userLatLon, markerLatLon) <= parseInt(dist) * 1000)
                        ) {
                    var desc;
                    // if the description is null, return an empty string
                    if (markers[i]['description'] != null)
                        var desc =  markers[i]['description'];
                    else
                        var desc = "";

                    // content is formatted by the function
                    var params = {
                        position:  {lat: parseFloat(markers[i]['lat']), lng: parseFloat(markers[i]['lon'])},
                        title: markers[i]['lotName'],
                        content: formatContent(markers[i]['id'], markers[i]['lotName'], desc, markers[i]['cost'])
                    };
                    var marker = addMarker(map, params);

                    $('#tbody-lots').append(formatRow(markers[i]['id'], markers[i]['lotName'], markers[i]['lat'], markers[i]['lon'], markers[i]['cost']));
                }
            }
        },
        error: function(jq, status, error) {
            console.log(jq);
            console.log(status);
            console.log(error);
        }
    });
});