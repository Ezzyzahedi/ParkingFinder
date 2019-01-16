<?php
session_start();

// Check if the user is already logged in, if no redirect
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  header("location: login.php");
  exit;
}

require 'vendor/aws-autoloader.php';
use Aws\S3\S3Client;
require_once "resources/connection.php";



$validated = true;

$fdir = null;
if ($validated && (file_exists($_FILES['photo']['tmp_name']) || is_uploaded_file($_FILES['photo']['tmp_name']))) {
  try {
      //below was created by following a tutorial
    // http://php.net/manual/en/features.file-upload.php
    if (!isset($_FILES['photo']['error']) ||
        is_array($_FILES['photo']['error'])
    ) { throw new RuntimeException('Invalid file parameters.'); }
    
    // is the file small enough
    if ($_FILES['photo']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // are the mime types valid
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['photo']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }
    
    // use a hash to get a unique name
    $hfname = sha1_file($_FILES['photo']['tmp_name']);
    // move the temp
    $fdir = '/tmp/' . $hfname . '.' . $ext;
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $fdir)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
  // file validation exception catch
  } catch (RuntimeException $e) {
      $validated = false;
      $error_msg = $e->getMessage();
  }
}


if (!empty($_POST)) {
  // is the lot name valid
  if (!(preg_match('/^\w+(\s|\w)*$/', $_POST["name"]))) {
    throw new RuntimeException("invalid lot name");
  }

  // is the lat/lon valid
  if (!(preg_match('/^(-)?[0-9]+(\.[0-9]+)?$/', $_POST["lat"])) &&  
  !(preg_match('/^(-)?[0-9]+(\.[0-9]+)?$/', $_POST["lon"]))) {
  $lat = floatval($_POST["lat"]);
  $lon = floatval($_POST["lat"]);
  }
  // prepared statement for no sql injection
  $stmt = $pdo->prepare("INSERT INTO lots (lotName, lat, lon, description, cost) 
  VALUES (:name, :lat, :lon, :description, :cost);");

  $stmt->bindParam(':name', $_POST['name']);
  $stmt->bindParam(':lat', $_POST['lat']);
  $stmt->bindParam(':lon', $_POST['lon']);
  $stmt->bindParam(':description', $_POST['description']);
  $stmt->bindParam(':cost', $_POST['cost']);
  $stmt->execute();

  // if there the $fdir is set, that means there was a file uploaded.
  if (!(is_null($fdir))) {
        
    /**
     * initialize S3Client
     * done insecurely for the purpose of the assignment
     */
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-2',
        'credentials' => [
          'key'    => 'omitted',
          'secret' => 'omitted',
      ],
    ]);
    
    /**
     * upload file hash and make it public
     */
    $result = $s3->putObject(array(
      'Bucket'     => "lot-bucket",
      'Key'        => $hfname,
      'SourceFile' => $fdir,
      'ACL'        => 'public-read',
    ));
    
    // get the last inserted id (what was just inserted)
    $last_id = $pdo->lastInsertId();
    // add url to the last insert
    $stmt = $pdo->prepare("UPDATE lots SET photo=:url WHERE id=:lot_id;");
    $stmt->bindParam(':lot_id', $last_id);
    $stmt->bindParam(':url', $result['ObjectURL']);
    $stmt->execute();
  }

  header("Location: index.php");
}
?>