<?php
error_reporting(0);
require("common.php");
header('Content-Type: multipart/form-data'); 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
$title = $_POST['title'];
$title = mysqli_real_escape_string($con, $title);

$description = $_POST['description'];
$description = mysqli_real_escape_string($con, $description);


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$error = "\0";
$data;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $error .= "File is not an image.";
    $uploadOk = 0;
  }
}

clearstatcache();
if (file_exists($target_file)) {
  $error .= "Sorry, file already exists.";
  $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
  $error .=  "Sorry, only JPG, JPEG, & PNG files are allowed.";
  $uploadOk = 0;
}

if ($uploadOk == 0) {
  $error .= "Sorry, your file was not uploaded.";
  $data = [ 'status' => "400",'response' => $error ];
  header('Content-type: application/json');
  echo json_encode($data); 
} else {
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $source = "http://backend/" . $target_file;
    $query = "INSERT INTO images(title,description,link)VALUES('" . $title . "','" . $description . "','" . $source . "')";
    $error = mysqli_query($con, $query) or die(mysqli_error($con));
    $error .= "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
    $data = [ 'status' => "200",'response' => $error ];
    header('Content-type: application/json');
    echo json_encode($data);
  } else {
    $error .= "Sorry, there was an error uploading your file.";
    $data = [ 'status' => "500",'response' => $error ];
    header('Content-type: application/json');
    echo json_encode($data);
  }
}
?>