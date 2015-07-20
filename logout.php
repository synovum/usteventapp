<?php
include "connect.php";
$reply=array();
$reply['status']=0;
if(isset($_REQUEST["user_id"])){
    $query=$pdo->prepare("UPDATE user SET device_id=:deviceid WHERE id=:id");
    $query->execute(array(
        ':deviceid' => '',
        ':id' => $_REQUEST['user_id'],
    ));
    $reply['status']=1;
}
//echo "<pre>";
//print_r($reply);
echo json_encode($reply);

