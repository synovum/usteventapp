<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
date_default_timezone_set ('Asia/Calcutta');
try{
//    $hostname="182.50.133.172";
//    $dbname="synovumEvents";
//    $username="synovumEvents";
//    $password="Synovum#3";

    $hostname="localhost";
    $dbname="ustevent";
    $username="root";
    $password="";

    $pdo= new PDO("mysql:host=$hostname; dbname=$dbname" , "$username", "$password");
} catch (PDOException $e) {
    $result['connection']=0;
    echo json_encode($result);
}
?>