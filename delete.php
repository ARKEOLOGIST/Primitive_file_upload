<?php
//error_reporting(0);
require("common.php");
header('Content-Type: multipart/form-data'); 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
$data;
$value;
$title = $_GET['id'];
$title = mysqli_real_escape_string($con, $title);
$query = "SELECT * FROM images WHERE id='" . $title . "'";
$result = mysqli_query($con, $query);
if ($result == FALSE) {
$data = [ 'status' => "400",'response' => "Invalid data sent" ];
header('Content-Type: application/json');
echo $data["response"];
}
else {
$rows = mysqli_fetch_assoc($result);
echo $rows["id"];
$value = substr($rows["link"],15);
if (unlink($value)) {
    $query = "DELETE FROM images WHERE id='" . $title . "'";
    $result = mysqli_query($con, $query);
    if ($result == FALSE) {
    $data = [ 'status' => "400",'response' => "Sorry, your item has not been deleted" ];
    header('Content-type: application/json');
    echo $data['response'];
    }
    else {
    $data = [ 'status' => "200",'response' => "Successfully deleted entry" ];
    header('Content-Type: application/json');
    echo $data['response'];
    }
} else {
    $data = [ 'status' => "400",'response' => "Sorry, your file has not been deleted" ];
    header('Content-Type: application/json');
    echo $data['response'];
}
}
?>