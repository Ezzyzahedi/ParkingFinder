<?php
  require("connection.php");

  /**
   * mysql queries to return a list of lots given parameters from index.php
   */
  
  $stmt = null;
  
  /**
   * find lots that have a rating equal or less than the desired rating by an innerjoin 
   * with the reviews table
   */
  if (!(empty($_POST["rating"]))) {
    $rating = $_POST["rating"];

    $stmt = $pdo->prepare("SELECT DISTINCT lots.id, lotName, lat, lon, description, cost
                           FROM lots INNER JOIN reviews 
                           ON lots.id = reviews.lot_id WHERE rating = :rating;");
    $stmt->bindParam(':rating', $rating);
  }
  /**
   * if there was no rating given, 
   * simple search quesry to find substring is part of any tuples
   */
  elseif (!(empty($_POST["lotName"]))) {
    $name = "%" . $_POST["lotName"] . "%";

    $stmt = $pdo->prepare("SELECT * FROM lots where lotName like :search");
    $stmt->bindParam(':search', $name);
  }
  /**
   * otherwise all lots will be found
   */
  else { 
    $stmt = $pdo->query("SELECT * FROM lots;");
  }

  header("Content-type: application/json");

  /**
   * encode the returned data to json
   */
  if ($stmt->execute()) {
    $result = $stmt->fetchAll();
    echo json_encode($result);
  }


?>