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

try{
    $email = $json['email'];
    $password = json['password'];
    $changePassword1 = json['changePassword1'];
    $changePassword2 = json['changePassword2'];
    $error = "none";
    $stat = "none";

    $checkingPasswordSql = "select * from user where email='$email';"
    $checkingPasswordResult = mysqli_query($conn, $checkingPasswordSql);
    $row = mysqli_fetch_assoc($checkingPasswordResult);
    $RecordPassword = $row["password"];

    if(!$password==$RecordPassword ){
        $stat = "success";
        echo "비번같은지 확인 완료!";

        if($changePassword1==$changePassword2){
            $updateSql = "update user set email='$email' where password='$changePassword';";
            mysqli_query($conn, $updateSql);
            
        }
    }else {
        throw new exception('비밀번호가 틀렸습니다. ', 401);
    }

}catch(exception $e) {
    $stat   = "error";
    $error = ['errorMsg'   => $e->getMessage(), 'errorCode' => $e->getCode()];
  }finally{
    $data =  json_encode(['result_code' => $stat, 'error'=>$error]);
    header('Content-type: application/json'); 
    echo $data;
  }

mysqli_close($conn);
?>