// var that holds map element
var map;

// vars for reges types (decimal may be empty)
var decimalRegex = /^$|^-?[0-9]+\.?[0-9]*$/;
var dateRegex = /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/;
var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

// try getting input elements by ID (null if not found)
var lat = document.getElementById('lat');
var lon = document.getElementById('lon');
var minPrice = document.getElementById('minPrice');
var maxPrice = document.getElementById('maxPrice');
var parkingName = document.getElementById('name');
var username = document.getElementById('username');
var password = document.getElementById('password');
var email = document.getElementById('email');
var birthday = document.getElementById('birthday');

// when lat is on page
if (lat !== null)
// add an event listener checking the regex
    lat.addEventListener("input", function (event) {
        if (decimalRegex.test(lat.value)) {
            lat.className = "add-card-text-input";
        } else {
            lat.className = "add-card-text-input invalid";
        }
    }, false);

// when lon is on page
if (lon !== null)
// add an event listener checking the regex
    lon.addEventListener("input", function (event) {
        if (decimalRegex.test(lon.value)) {
            lon.className = "add-card-text-input";
        } else {
            // adds invalid class to highlight red
            lon.className = "add-card-text-input invalid";
        }
    }, false);

// when minPrice is on page
if (minPrice !== null)
// add an event listener checking the regex
    minPrice.addEventListener("input", function (event) {
        if (decimalRegex.test(minPrice.value)) {
            minPrice.className = "add-card-text-input";
        } else {
            // adds invalid class to highlight red
            minPrice.className = "add-card-text-input invalid";
        }
    }, false);

// when maxPrice is on page
if (maxPrice !== null)
// add an event listener checking the regex
    maxPrice.addEventListener("input", function (event) {
        if (decimalRegex.test(maxPrice.value)) {
            maxPrice.className = "add-card-text-input";
        } else {
            // adds invalid class to highlight red
            maxPrice.className = "add-card-text-input invalid";
        }
    }, false);

// when email is on page
if (email !== null)
// add an event listener checking the regex
    email.addEventListener("input", function (event) {
        if (emailRegex.test(email.value)) {
            email.className = "add-card-text-input";
        } else {
            // adds invalid class to highlight red
            email.className = "add-card-text-input invalid";
        }
    }, false);

// when birthday is on page
if (birthday !== null)
// add an event listener checking the regex
    birthday.addEventListener("input", function (event) {
        if (dateRegex.test(birthday.value)) {
            birthday.className = "add-card-text-input";
        } else {
            // adds invalid class to highlight red
            birthday.className = "add-card-text-input invalid";
        }
    }, false);

// validate the input fields when registering
function validateRegister() {
    var alertStr = "";
    // regex checks and empty value checks on required inputs
    if (username !== null && username.value.length === 0)
        alertStr += "Username is a required input\n";
    if (password !== null && password.value.length === 0)
        alertStr += "Password is a required input\n";
    if (email !== null && email.value.length === 0)
        alertStr += "Email is a required input\n";
    else if (email !== null && !emailRegex.test(email.value))
        alertStr += "Email is an invalid format\n";
    if (birthday !== null && birthday.value.length === 0)
        alertStr += "Birthday is a required input\n";
    else if (birthday !== null && !dateRegex.test(birthday.value))
        alertStr += "Birthday is an invalid date\n";

    // any errors send an alert
    if (alertStr !== "")
        alert(alertStr);
    else
        window.location.href = "/index.php";
}

// validate the input fields when submitting
function validateSubmit() {
    var alertStr = "";
    // regex checks and empty value checks on required inputs
    if (parkingName !== null && parkingName.value.length === 0)
        alertStr += "Name is a required input\n";
    if (lat !== null && lat.value.length === 0)
        alertStr += "Latitude is a required input\n";
    else if (lat !== null && !decimalRegex.test(lat.value))
        alertStr += "Latitude is an invalid number\n";
    if (lon !== null && lon.value.length === 0)
        alertStr += "Longitude is a required input\n";
    else if (lon !== null && !decimalRegex.test(lon.value))
        alertStr += "Longitude is an invalid number\n";

    // any errors send an alert
    if (alertStr !== "")
        alert(alertStr);
    else
        window.location.href = "/index.php";
}

// validate the input fields when searching
function validateSearch() {
    var alertStr = "";
    // regex checks and empty value checks on required inputs
    if (lat !== null && lat.value.length === 0)
        alertStr += "Latitude is a required input\n";
    else if (lat !== null && !decimalRegex.test(lat.value))
        alertStr += "Latitude is an invalid number\n";
    if (lon !== null && lon.value.length === 0)
        alertStr += "Longitude is a required input\n";
    else if (lon !== null && !decimalRegex.test(lon.value))
        alertStr += "Longitude is an invalid number\n";
    if (minPrice !== null && !decimalRegex.test(minPrice.value))
        alertStr += "Min Price is an invalid number\n";
    if (maxPrice !== null && !decimalRegex.test(maxPrice.value))
        alertStr += "Max Price is an invalid number\n";

    // any errors send an alert
    if (alertStr !== "")
        alert(alertStr);
    else
        window.location.href = "/results.php";
}

// initialize the map with the search results
function initSearchMap() {
    // create the new map using the map element
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 43.2609, lng: -79.9192 }, // mcmaster university
        zoom: 15
    });

    // info window that opens when markers are clicked
    var infowindow = new google.maps.InfoWindow();

    // hardcoded marker, will not be hard coded in future
    var marker1 = new google.maps.Marker({
        position: { lat: 43.2609, lng: -79.9192 },
        map: map,
        title: '1280 Main St'
    });
    // hardcoded listener on previous marker, will not be hard coded in future
    marker1.addListener('click', function () {
        infowindow.setContent('<div><strong> 1280 Main St</strong><br>' +
            'Distance: 1km<br>5$/h</div>' +
            '<form class="card-icon" action="/parking.php">' +
            '<button class="table-button"><i class="far fa-check-square last-td"> Open</i></button></form>');
        infowindow.open(map, marker1); // open info
    });

    // last two markers are hard coded the same way
    var marker2 = new google.maps.Marker({
        position: { lat: 43.2590, lng: -79.9100 },
        map: map,
        title: '1280 Main St'
    });
    marker2.addListener('click', function () {
        infowindow.setContent('<div><strong> 1280 Main St</strong><br>' +
            'Distance: 1km<br>5$/h</div>' +
            '<form class="card-icon" action="/parking.php">' +
            '<button class="table-button"><i class="far fa-check-square last-td"> Open</i></button></form>');
        infowindow.open(map, marker2);
    });

    var marker3 = new google.maps.Marker({
        position: { lat: 43.2630, lng: -79.9157 },
        map: map,
        title: '1280 Main St'
    });
    marker3.addListener('click', function () {
        infowindow.setContent('<div><strong> 1280 Main St</strong><br>' +
            'Distance: 1km<br>5$/h</div>' +
            '<form class="card-icon" action="/parking.php">' +
            '<button class="table-button"><i class="far fa-check-square last-td"> Open</i></button></form>');
        infowindow.open(map, marker3);
    });
}

// initialise the map with the chosen result
function initResultMap() {
    // create the new map using the map element
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 43.2609, lng: -79.9192 }, // mcmaster university
        zoom: 15
    });

    // info window that opens when markers are clicked
    var infowindow = new google.maps.InfoWindow();

    // hardcoded marker, will not be hard coded in future
    var marker1 = new google.maps.Marker({
        position: { lat: 43.2609, lng: -79.9192 },
        map: map,
        title: '1280 Main St'
    });
    // hardcoded listener on previous marker, will not be hard coded in future
    marker1.addListener('click', function () {
        infowindow.setContent('<div><strong> 1280 Main St</strong><br>' +
            'Distance: 1km<br>5$/h</div>' +
            '<form class="card-icon" action="/parking.php">');
        infowindow.open(map, marker1);
    });
}

// uses html5 api to get current location data and send to showPosition function
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

// change values of elements to represent given position, set elements to valid
function showPosition(position) {
    lat.value = position.coords.latitude;
    lat.className = "add-card-text-input";
    lon.value = position.coords.longitude;
    lon.className = "add-card-text-input";
}