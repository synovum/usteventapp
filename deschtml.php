<?php
include "connect.php";

if(isset($_REQUEST['action']) && $_REQUEST['action']=="travelinfodesc"){
    $query=$pdo->prepare("SELECT tdesc FROM travel WHERE tid=:tid");
    $query->execute(array(
        ':tid' => $_REQUEST['tid'],
    ));
    $result=$query->fetch(PDO::FETCH_ASSOC);
    echo $result['tdesc'];
}