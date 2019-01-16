<?php include 'resources/registerhandler.php';?>

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
            <button id="openSubmit" class="nav-button" aria-label="Open submission page">Submit</button>
          </form>
          <form action="/register.php" class="nav-pill">
            <button id="openRegister" class="nav-button active" aria-label="Open registration page">Sign Up</button>
          </form>
        </div>

        <!--content of webpage-->
        <div id="cardBody" class="card-body">
          <div class="card-bar">
              <!--parking area title-->
            <h2>Create an Account</h2>
            
            
          </div>
          <div class="card-row">
            Already have an account?
            <button onclick="window.location.href='login.php';" id="successButton" class="success-green">
              <i class="fas fa-user"></i> Sign in
            </button>
          </div>
          <br>

          <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <fieldset style="border:none;">
          <!--username entry-->
          <div class="card-row">
            <span class="card-text">Username <span class="required">*</span></span>
            <input type="text" name="username" id="username" class="add-card-text-input" required
            placeholder="Enter your username" value="<?php echo $username; ?>">
            <span></span>
          </div>
          <!--password entry-->
          <div class="card-row">
            <span class="card-text">Password <span class="required">*</span></span>
            <input type="password" name="password" id="password" class="add-card-text-input" required
            placeholder="Enter your password" value="<?php echo $password; ?>">
            <span></span>
          </div>
          <!--email entry-->
          <div class="card-row">
            <span class="card-text">Email <span class="required">*</span></span>
            <input type="email" name="email" id="email" class="add-card-text-input" required
            placeholder="email@example.com">
            <span></span>
          </div>
          <!--birthday entry-->
          <div class="card-row">
            <span class="card-text">Birthday <span class="required">*</span></span>
            <input type="date" name="birthday" id="birthday" class="add-card-text-input" required>
            <span></span>
          </div>
        </div>

        <!--footer of dynamic area, used for navigation buttons-->
        <div id="cardFooter" class="card-footer">
          <span></span>
          <input type="submit" name="submit" value="Sign up"  onclick="validateRegister()" id="successButton" class="success-green go-right">
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