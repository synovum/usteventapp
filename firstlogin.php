<?php
include "connect.php";
$reply=array();
$reply['status']=0;
if(isset($_REQUEST["username"]) && isset($_REQUEST["password"])){
    $query=$pdo->prepare("SELECT id,type,user_group,firstname,lastname,designation,location,user_image_stat,user_image,user_used,user_event FROM user WHERE username=:username AND password=:password");
    $query->execute(array(
            ':username' => $_REQUEST['username'],
            ':password' => $_REQUEST['password'],
    ));
    $res=$query->fetchAll(PDO::FETCH_ASSOC);
    $num=count($res);
    if($num==1){
        $query=$pdo->prepare("UPDATE user SET last_login=:last_login WHERE id=:id");
        $query->execute(array(
            ':last_login' => date("Y-m-d H:i:s"),
            ':id' => $res[0]['id'],
        ));

        $deviceid=$_REQUEST['deviceid'];
        if($deviceid==""){
            $deviceid=$res[0]['id']."_".time();
        }

        $query=$pdo->prepare("UPDATE user SET device_id=:deviceid WHERE id=:id");
        $query->execute(array(
            ':deviceid' => $deviceid,
            ':id' => $res[0]['id'],
        ));
        $res[0]['deviceid']=$deviceid;


        if($res[0]['user_image_stat']==0){
            $res[0]['user_image']=strtoupper(substr($res[0]['firstname'],0,1).substr($res[0]['lastname'],0,1));
        }
        if($res[0]['user_used']==0){
            $query=$pdo->prepare("UPDATE user SET user_used=:user_used WHERE id=:id");
            $query->execute(array(
                ':user_used' => 1,
                ':id' => $res[0]['id'],
            ));
        }
        if($res[0]['user_event']==0){
            $res[0]['event_active']=0;
            $res[0]['event_welcome']="No Active Events";
        }
        else{
            $query=$pdo->prepare("SELECT event_id,event_welcome,event_active FROM event WHERE event_id=:event_id");
            $query->execute(array(
                ':event_id' => $res[0]['user_event'],
            ));
            $result=$query->fetch(PDO::FETCH_ASSOC);
            $res[0]['event_active']=$result['event_active'];
            if($result['event_active']==0){
                $res[0]['event_welcome']="No Active Events";
            }
            else{
                $res[0]['event_welcome']=$result['event_welcome'];
            }
        }


        $reply['status']=1;
        $reply['user']=$res[0];
    }
}
//echo "<pre>";
//print_r($reply);
echo json_encode($reply);

