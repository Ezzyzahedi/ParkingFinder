<?php
session_start();

require_once "resources/connection.php";

if (!empty($_GET) && isset($_GET['id'])) {
  // select the specific lot
  $stmt = $pdo->prepare("SELECT * FROM lots WHERE id = :id");
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();

  $lot = $stmt->fetch();
  if (! $lot) {
    throw new PDOException("id does not exist");
  }

  // select all reviews for with the lot.
  $stmt = $pdo->prepare("SELECT * FROM reviews where lot_id = :id");
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();

  $reviews = $stmt->fetchAll();
} else {
  header("Location: index.php");
}
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
          <div class="nav-pill">
            <button onclick="window.location.href = 'index.php';" id="openSearch" class="nav-button " aria-label="Open search page">Search</button>
          </div>
          <div class="nav-pill">
            <button onclick="window.location.href = 'index.php';"  id="openMap" class="nav-button active" aria-label="Open general area map">Map</button>
          </div>
          <div  class="nav-pill">
            <button onclick="window.location.href = 'submission.php';"  id="openSubmit" class="nav-button" aria-label="Open submission page">Submit</button>
          </div>
          <?php
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            echo '
            <div class="nav-pill">
              <button onclick="window.location.href = \'/resources/logouthandler.php\';"  id="signOut" class="nav-button" aria-label="sign out">Sign out</button>
            </div>
            ';
          } else {
            echo '
            <div class="nav-pill">
              <button onclick="window.location.href = \'register.php\';"  id="openRegister" class="nav-button" aria-label="Open registration page">Sign Up</button>
            </div>
            ';
          }
          ?>
        </div>

        <!--content of webpage-->
        <div id="cardBody" class="card-body">
          <div class="card-bar">
              <!--parking area title-->
              <?php
              $tmp = htmlspecialchars(stripslashes(trim($lot['lotName'])));
              $tmp2 = htmlspecialchars(stripslashes(trim($lot['cost'])));
              echo "<h2 itemprop='itemreviewed'>$tmp - $tmp2$/h</h2>";
              ?>
          </div>
          <!--parking area loctions using google maps-->
          <div class="card-bar">
              <div id="map"></div>
          </div>
          <!--parking area loction using html5 picture with responsive resolution-->
          <!-- <div class="card-bar">
            <picture>
              <source class="card-photo" srcset="/assets/parking-example-static-sm.jpg, /assets/parking-example-static-sm.jpg 2x" media="(max-width: 768px)">
              <source class="card-photo" srcset="/assets/parking-example-static-lg.jpg, /assets/parking-example-static-sm.jpg 2x">
              <img class="card-photo" src="/assets/parking-example-static-sm.jpg, /assets/parking-example-static-lg.jpg 2x" alt="Default static map image">
            </picture>
          </div> -->
          <!--rating and description-->
          <div class="card-row">
            <div class="card-text">
            <?php
              $url = $lot['photo'];
              echo "<img src='$url' alt='image failed' style='width:100%'>";
            ?>
            </div>
            <div class="card-text">
              <?php
              if (isset($lot['description'])) {
                $tmp = htmlspecialchars(stripslashes(trim($lot['description'])));
                echo "Description: <h5 itemprop='summary' itemprop='description'>$tmp</h5>";
              }
              ?>
            </div>
          </div>
          <!--table of reviews stating author, rating, and review-->
          <div class="card-bar">
            <table>
              <thead>
                <th>Author</th>
                <th>Rating</th>
                <th>Review</th>
              </thead>
              <tbody id="tbody-reviews">
              <?php
              foreach($reviews as $row) {
                $name = $row['user'];
                $rating = $row['rating'];
                $review = htmlspecialchars(stripslashes(trim($row['review'])));

                echo "
                <tr>
                  <td itemprop='reviewer'>$name</td>
                  <td>$rating</td>
                  <td>$review</td>
                </tr>
                ";
              }
              ?>
              </tbody>
            </table>
          </div>
          <div class="card-bar">
            <?php
              if (isset($_SESSION['loggedin'])){
                $pid = ($_GET['id']);
                $uid = ($_SESSION['id']);
                $uname = ($_SESSION['username']);
                echo "<form id='review-section'>
                        <fieldset name='usr-reviews'>
                          <legend>Submit a Review</legend><br />
                          <div class='card-row'>
                          <span>Rating:</span>
                            <select name='rating' id='rating'required>
                              <option value=''>Choose</option>
                              <option value='1'>1</option>
                              <option value='2'>2</option>
                              <option value='3'>3</option>
                              <option value='4'>4</option>
                              <option value='5'>5</option>
                            </select>
                          </div>

                          <div class='card-row'>
                          <span>Review:</span>
                            <textarea name='comment' id='comment'></textarea>
                          </div>

                          <input type='hidden' id='pid' name='pid' value='$pid'/>
                          <input type='hidden' id='uid' name='uid' value='$uid'/>
                          <input type='hidden' id='uname' name='uname' value='$uname'/>
                          </br>
                          <div class='card-bar'>
                            <input type='submit' value='SUBMIT' class='success-green go-right'/>
                          </div>
                        </fieldset>
                      </form>";
              }
            ?>
          </div>
          <!--sample video using html5 video-->
          <!-- <div class="card-row">
            <div class="card-text">
              Sample Video:
            </div>
            <video width="320" controls>
              <source src="/assets/car-video.mp4" type="video/mp4">
              Your browser does not support HTML5 video.
            </video>
          </div> -->
        </div>

        <!--footer of dynamic area, used for navigation buttons-->
        <div id="cardFooter" class="card-footer">
          <form action="/results.php" class="success-green">
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
  <script src="scripts/main.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxTGyAHfi5AsiIlP7QQpjxxVdpX8CbCDk&libraries=geometry,places"></script>
  <script src="scripts/lot.js"></script>
</body>

</html>