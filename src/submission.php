<?php
require_once "resources/submissionhandler.php";
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
            <button id="openSearch" class="nav-button" aria-label="Open search page">Search</button>
          </form>
          <form action="/parking.php" class="nav-pill">
            <button id="openMap" class="nav-button" aria-label="Open general area map">Map</button>
          </form>
          <form action="/submission.php" class="nav-pill">
            <button id="openSubmit" class="nav-button active" aria-label="Open submission page">Submit</button>
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
            <!--parking area title-->
          <div class="card-bar">
            <h2>Submit a Parking Service</h2>
          </div>

          <form id="submission" action="submission.php" method="post" enctype="multipart/form-data">
          <fieldset style="border:none;">
          <!--name entry-->
          <div class="card-row">
            <span class="card-text">Name <span class="required">*</span></span>
            <input type="text" name="name" class="add-card-text-input" id="name" required
            placeholder="Enter name of parking service">
            <span></span>
          </div>
          <!--cost entry-->
          <div class="card-row">
            <span class="card-text">Name <span class="required">*</span></span>
            <input type="number" name="cost" class="add-card-text-input" id="name" required
            placeholder="Enter cost per hour">
            <span></span>
          </div>
          <!--description entry-->
          <div class="card-row">
            <span class="card-text">Description</span>
            <textarea name="description" class="card-text add-card-textarea" id="description"
            placeholder="Enter parking service description"></textarea>
            <span></span>
          </div>
          <div class="card-bar">&#160;</div>
          <div class="card-bar">
              <button id="successButton" class="success-green go-right" onclick="getLocation()">
                <i class="fas fa-map-pin"></i> Use Current Position
              </button>
          </div>
          <!--latitude entry-->
          <div class="card-row">
            <span class="card-text">Latitude <span class="required">*</span></span>
            <input name="lat" class="add-card-text-input" id="lat" required
            pattern="^$|^-?[0-9]+\.?[0-9]*$" placeholder="Enter your latitude">
            <span></span>
          </div>
          <!--longtitude entry-->
          <div class="card-row">
            <span class="card-text">Longitude <span class="required">*</span></span>
            <input name="lon" class="add-card-text-input" id="lon" required
            pattern="^$|^-?[0-9]+\.?[0-9]*$" placeholder="Enter your longitude">
            <span></span>
          </div>
          <!--upload photo entry-->
          <div class="card-row">
            <span class="card-text">Upload Photo</span>
            <div class="upload-btn-wrapper">
              <button class="success-green">Upload a photo</button>
              <input name="photo" type="file" accept="image/*" />
            </div>
            <span></span>
          </div>
        </div>

        <!--footer of dynamic area, used for navigation buttons-->
        <div id="cardFooter" class="card-footer">
          <span></span>
            <input type="submit" name="submit" value="Submit" onclick="validateSubmit()" id="successButton" class="success-green go-right">
          <span></span>
        </div>
        </fieldset>
        </form>
      </div>
    </div>
  </main>
  <footer>
      <!--footer-->
    <?php include 'const/footer.php';?>
  </footer>
  <script src="scripts/main.js"></script>
</body>

</html>