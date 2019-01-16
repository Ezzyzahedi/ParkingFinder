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
            <form action="resources/logouthandler.php" class="nav-pill">
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
            <h2>Search for Parking</h2>
          </div>        
        
        <form id="login" action="results.php" method="get">
        <fieldset style="border:none;">
          <div class="card-bar">
              <button id="successButton" class="success-green go-right" onclick="getLocation()">
                <i class="fas fa-map-pin"></i> Use Current Position
              </button>
          </div>
          <!--latitude entry-->
          <div class="card-row">
            <span class="card-text">Latitude <span class="required">*</span></span>
            <input type="text" name="lat" id="lat" required class="add-card-text-input" required 
              pattern="^$|^-?[0-9]+\.?[0-9]*$" placeholder="Enter your latitude here">
            <span></span>
          </div>
          <!--longtitude entry-->
          <div class="card-row">
            <span class="card-text">Longitude <span class="required">*</span></span>
            <input type="text" name="lon" id="lon" class="add-card-text-input" required
              pattern="^$|^-?[0-9]+\.?[0-9]*$" placeholder="Enter your longitude here">
            <span></span>
          </div>
          <!--distance entry-->
          <div class="card-row">
            <span class="card-text">Distance (km)</span>
            <input type="number" name="dist" id="dist" class="add-card-text-input"
              placeholder="Enter distance away here">
            <span></span>
          </div>
          <!--price entry-->
          <div class="card-row">
            <span class="card-text">Price</span>
            <div class="split">
              <input type="number" name="minPrice" id="minPrice" class="add-card-text-input"
              pattern="^$|^-?[0-9]+\.?[0-9]*$" placeholder="min">
              <input type="text" name="maxPrice" id="maxPrice" class="add-card-text-input"
              pattern="^$|^-?[0-9]+\.?[0-9]*$" placeholder="max">
            </div>
            <span></span>
          </div>
          <!--name entry-->
          <div class="card-row">
            <span class="card-text">Name <span></span></span>
            <input type="text" name="lotName" id="lotName" class="add-card-text-input"
              placeholder="Enter name here">
            <span></span>
          </div>
          <!--rating entry-->
          <div class="card-row">
            <span class="card-text">Rating</span>
            <!-- <div class="card-rating">
              <input type="radio" id="r1" name="rg1">
              <label for="r1"><i class="fas fa-star"></i></label>
              <input type="radio" id="r2" name="rg1">
              <label for="r2"><i class="fas fa-star"></i></label>
              <input type="radio" id="r3" name="rg1">
              <label for="r3"><i class="fas fa-star"></i></label>
              <input type="radio" id="r4" name="rg1">
              <label for="r4"><i class="fas fa-star"></i></label>
              <input type="radio" id="r5" name="rg1">
              <label for="r5"><i class="fas fa-star"></i></label>
            </div> -->
            <select name="rating">
              <option></option>
              <option value=1>1</option>
              <option value=2>2</option>
              <option value=3>3</option>
              <option value=4>4</option>
              <option value=5>5</option>
            </select>
            <span></span>
          </div>
        </div>

        <!--footer of dynamic area, used for navigation buttons-->
        <div id="cardFooter" class="card-footer">
          <span></span>
          <input type="submit" name="submit" value="Search" onclick="validateSearch()" id="successButton" class="success-green go-right">
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