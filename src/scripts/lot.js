$(document).ready( function() {
    $.ajax({
        type: "POST",
        url: "resources/lothandler.php",
        data: window.location.href.split("?")[1],
        success: function(json_data) {
            var markers = json_data;
            if (markers.length < 1) {

            }
            var myLatLng = {lat: parseFloat(markers[0]['lat']), lng: parseFloat(markers[0]['lon'])};
            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: markers[0]['name']
              });
        },
        error: function(jq, status, error) {
            console.log(jq);
            console.log(status);
            console.log(error);
        }
    });
});

/**
 * BONUS TASK
 * using ajax to create a review and load it without reloading the page
 */
$(document).submit( function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "resources/reviewhandler.php",
        data: $("#review-section").serialize(),
        //dataType: 'application/json',
        success: function(response) {
            console.log("ajax post successful");
            if (response === "success") {
                var name = $("#uname").val();
                $("#tbody-reviews").append(
                    "<tr>" +
                    "<td itemprop='reviewer'>" + name + "</td>" +
                    "<td>" + $("#rating").val() + "</td>" +
                    "<td>" + $("#comment").val() + "</td>" +
                    "</tr>"
                    );
            }
            else {
                var error = document.getElementById('error');
                error.innerHTML = response;
            }
        },
        error: function(jq, status, error) {
            console.log(jq);
            console.log(status);
            console.log(error);
        }
    });
});