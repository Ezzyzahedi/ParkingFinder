<?php
  require("connection.php");

  /**
   * mysql query to return a single of lot given the id
   */
  
  $stmt = null;
  $stmt = $pdo->prepare("SELECT * FROM lots WHERE id = :id;");
  $stmt->bindParam(':id', $_POST['id']);

  header("Content-type: application/json");

  if ($stmt->execute()) {
    $result = $stmt->fetchAll();
    echo json_encode($result);
  } 
?>