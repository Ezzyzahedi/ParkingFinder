<?php
  require("connection.php");

  /**
   * mysql query to add a review
   */

  $rating = intval($_POST['rating']);

  // prepared statement, no sql injection
  $stmt = $pdo->prepare("INSERT INTO reviews (lot_id, user_id, user, rating, review) VALUES (:pid, :uid, :uname, :rating, :review);");
  $stmt->bindParam(':uid', $_POST['uid']);
  $stmt->bindParam(':pid', $_POST['pid']);
  $stmt->bindParam(':uname', $_POST['uname']);
  $stmt->bindParam(':rating', $_POST['rating']);
  $stmt->bindParam(':review', $_POST['comment']);

  // returns for ajax
  if ($stmt->execute()) {
      echo "success";
      exit();
  }
  else {
      echo "failed to add review";
  } 
?>