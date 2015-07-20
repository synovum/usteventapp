<?php
include "connect.php";
$reply=array();
if(isset($_REQUEST['user_id'])){
    $id=$_REQUEST['user_id'];

    $query=$pdo->prepare("SELECT ag.agenda_id,ag.agenda_name,
                        DATE_FORMAT(ag.agenda_from, '%l.%i %p') agenda_from,
                        DATE_FORMAT(ag.agenda_to, '%l.%i %p') agenda_to,
                        DATE_FORMAT(ag.agenda_from, '%M %d') agenda_date,
                        ag.agenda_place,au.user_agenda_id
                        FROM agenda ag LEFT JOIN agenda_user au ON ag.agenda_id=au.agenda_user_id
                        WHERE au.user_agenda_id=:id OR au.user_agenda_id IS NULL");
    $query->execute(array(
        ':id' => $id,
    ));
    $reply=$query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($reply);
}