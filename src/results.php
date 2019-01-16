<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'const/head.php';?>

<body class="enviornment">
  <header>
      <!--header must be inside enviornment-->
  </header>
  <main>
    <div id="environment" class="environment">
      <!--header with html5 logo adjusting resolution-->
      <?php include 'const/title.php';?>
      <!--dynamic area of app-->
      <div id="card" class="card">
        <!--nav bar presenting search, map (placeholder), submit, and register/login-->
        <div id="navBar" class="nav-bar">
          <form action="/index.php" class="nav-pill">
            <button id="openSearch" class="nav-button active" aria-label="Open search page">Search</button>
          </form>
          <form action="/parking.php" class="nav-pill">
            <button id="openMap" class="nav-button" aria-label="Open general area map">Map</button>
          </form>
          <form action="/submission.php" class="nav-pill">
            <button id="openSubmit" class="nav-button" aria-label="Open submission page">Submit</button>
          </form>
          <?php
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            echo '
            <form action="/resources/logouthandler.php" class="nav-pill">
              <button id="signOut" class="nav-button" aria-label="sign out">Sign out</button>
            </form>
            ';
          } else {
            echo '
            <form action="/register.php" class="nav-pill">
              <button id="openRegister" class="nav-button" aria-label="Open registration page">Sign Up</button>
            </form>
            ';
          }
          ?>
        </div>

        <!--content of webpage-->
        <div id="cardBody" class="card-body">
          <div class="card-bar">
              <!--parking area title-->
            <h2>Your Search Results</h2>
          </div>
          <!--parking area loctions using google maps-->
          <div class="card-bar">
              <div id="map"></div>
          </div>
          <!--table of location, distance, price, and avg rating-->
          <div class="card-bar">

            <table>
              <thead>
                <th>Lot Name</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Price</th>
              </thead>
              <tbody id="tbody-lots">
              </tbody>
            </table>
          </div>
        </div>

        <!--footer of dynamic area, used for navigation buttons-->
        <div id="cardFooter" class="card-footer">
          <form action="/index.php" class="success-green">
            <button id="successButton" class="success-green"><i class="fa fa-caret-left"></i> Back</button>
          </form>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
  </main>
  <footer>
      <!--footer-->
    <?php include 'const/footer.php';?>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxTGyAHfi5AsiIlP7QQpjxxVdpX8CbCDk&libraries=geometry,places"></script>
  <script src="scripts/results.js"></script>
</body>

</html>