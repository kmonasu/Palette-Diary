<?php
//to solve cors issue
header("Access-Control-Allow-Origin: ");

 //db connect
$host = "localhost";
$s_username = "db";
$s_password = "dbpassword";
$dbname = "palette_diary";
$conn = mysqli_connect($host, $s_username, $s_password, $dbname);

$json = json_decode(file_get_contents('php://input'), TRUE);

$email = $json['email'];
$themeCode = $json['theme_code'];

$sql = "update user set theme_code='$themeCode' where email='$email';";
$result = mysqli_query($conn, $sql); 

$row = mysqli_fetch_assoc($result); 
$RecordBackPic = $row["background_pic"]; 

$data =  json_encode(['theme_code' => $themeCode, 'background_pic'=>$RecordBackPic]);
header('Content-type: application/json'); 

mysqli_close($conn);
?>