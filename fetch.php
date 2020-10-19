<?php
error_reporting(0);
require("common.php");
header('Content-Type: multipart/form-data'); 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
$query = "SELECT * FROM images";
$result = mysqli_query($con, $query);
if ($result == FALSE) {
$data = [ 'status' => "400",'response' => "Failed to fetch data from the database" ];
header('Content-Type: application/json');
echo json_encode($data);
}
else {
$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
$data = [ 'status' => "200",'response' => $rows ];
header('Content-Type: application/json');
echo json_encode($data);
}
?>