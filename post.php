<?php
include "connect.php";
$reply=array();
$reply['status']="fail";

//Get All agendas and status of current user attending it or not
if(isset($_REQUEST['action']) && $_REQUEST['action']=="agenda"){
    $result=array();
    $result=getAllAgendas($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['agenda']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//Get single agenda and speakers of the aganda
if(isset($_REQUEST['action']) && $_REQUEST['action']=="singleagenda"){
    $result=array();
    $result=getSingleAgenda($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply=array_merge($reply, $result);
        $result2=getAgendaSpeakers($pdo);
        $reply['speaker']=$result2;
    }
    else{
        $reply['status']="fail";
    }
}

//Get agendas corresponding activities (not used)
if(isset($_REQUEST['action']) && $_REQUEST['action']=="getagendaactivity_old"){
    $result=array();
    $result=getAllAgendaActivity($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['activity']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//Get agendas corresponding activities
if(isset($_REQUEST['action']) && $_REQUEST['action']=="getagendaactivity"){
    if($_REQUEST['stat']==1) {
        $result = array();
        $result=getAllAgendaActivity2($pdo);

        if ($result != null) {
            $reply['status'] = "success";
            $reply['activity'] = $result;
        } else if ($result == null) {
            $reply['status'] = "empty";
        } else {
            $reply['status'] = "fail";
        }
    }
    else{
        $reply['status'] = "invalid";
    }
}

//Get the speaker list
if(isset($_REQUEST['action']) && $_REQUEST['action']=="speakerlist"){
    $result=array();
    $result=getSpeakerlist($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['speaker']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//Add attending agenda
if(isset($_REQUEST['action']) && $_REQUEST['action']=="addattendagenda"){
    $success=addAttendingAgenda($pdo);
    if($success=="allok"){
        $reply['status']="success";
    }
    else{
        $reply['status']="fail";
    }
}

//Get details about a speaker
if(isset($_REQUEST['action']) && $_REQUEST['action']=="speakerdetails"){
    $result=array();
    $result=getSpeakerDetails($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply=array_merge($reply, $result);
        $result2=getSpeakersAgendas($pdo);
        $reply['agendas']=$result2;
    }
    else{
        $reply['status']="fail";
    }
}

//Add a new activity
if(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
    $success=addNewPost($pdo);
    if($success=="dbfault"){
        $reply['status']="fail";
    }
    else{
        $result=getPointDetails($pdo,$success);
        if($result!=null){
            $reply['status']="success";
            $reply=array_merge($reply,$result);
        }
        else{
            $reply['status']="fail";
        }

    }
}

//Get all activities (not used)
if(isset($_REQUEST['action']) && $_REQUEST['action']=="get"){
    $result=array();
    $result=getAllPosts($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['post']=$result;
    }
    else if($result==null){
        $reply['status']="empty";
    }
    else{
        $reply['status']="fail";
    }
}

//Get all activities
if(isset($_REQUEST['action']) && $_REQUEST['action']=="getallactivity"){
    if($_REQUEST['stat']==1) {
        $result = array();
        $result = getAllPosts2($pdo);

        if ($result != null) {
            $reply['status'] = "success";
            $reply['post'] = $result;
        } else if ($result == null) {
            $reply['status'] = "empty";
        } else {
            $reply['status'] = "fail";
        }
    }
    else{
        $reply['status'] = "invalid";
    }
}

//Get comments of an activity
if(isset($_REQUEST['action']) && $_REQUEST['action']=="comment"){
    $result=array();
    $noOfComments=getNoOfComments($pdo);

    if($noOfComments!=0){
        $result=getComments($pdo);
        if($result!=null){
            $reply['status']="success";
            $reply['total_c']=$noOfComments;
            $reply['comment']=$result;
        }
        else{
            $reply['status']="fail";
        }
    }
    else{
        $reply['status']="success";
        $reply['total_c']="No";
        $reply['comment']=$result;
    }
}

//Add a new comment to an activity
if(isset($_REQUEST['action']) && $_REQUEST['action']=="addcomment"){
    $success=addNewComment($pdo);
    if($success=="allok"){
        $reply['status']="success";
    }
    else{
        $reply['status']="fail";
    }
}

//Like an activity
if(isset($_REQUEST['action']) && $_REQUEST['action']=="addlike"){
    $success=addNewLike($pdo);
    if($success=="allok"){
        $reply['status']="success";
    }
    else{
        $reply['status']="fail";
    }
}

//Get count and list of people liked a post
if(isset($_REQUEST['action']) && $_REQUEST['action']=="like"){
    $result=array();
    $noOfLikes=getNoOfLikes($pdo);

    if($noOfLikes!=0){
        $result=getLikes($pdo);
        if($result!=null){
            $reply['status']="success";
            $reply['total_l']=$noOfLikes;
            $reply['like']=$result;
        }
        else{
            $reply['status']="fail";
        }
    }
    else{
        $reply['status']="success";
        $reply['total_l']="No";
        $reply['like']=$result;
    }
}

//Get the list of question and the users question
if(isset($_REQUEST['action']) && $_REQUEST['action']=="questionlist"){
    $result=array();
    $result=getQuestionlist($pdo);

    if($result!=NULL) {
        $reply['status'] = "success";
        $reply['question'] = $result;
    }
    else{
        $reply['status']="fail";
    }
}

//Get the poll page for a question
if(isset($_REQUEST['action']) && $_REQUEST['action']=="questionpoll"){
    $result=array();
    $result=getQuestionPoll($pdo);

    if($result!=NULL) {
        $reply['status'] = "success";
        $reply['poll'] = $result;
    }
    else{
        $reply['status']="fail";
    }
}

//Vote for a question
if(isset($_REQUEST['action']) && $_REQUEST['action']=="dovoting"){
    $result=array();
    $votestat=doVoting($pdo);

    if($votestat) {
        $reply['status'] = "success";
    }
    else{
        $reply['status']="fail";
    }
}


//Get the list of sponser
if(isset($_REQUEST['action']) && $_REQUEST['action']=="sponserlist"){
    $result=array();
    $result=getSponserList($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['sponser']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//get the list of attendees of an event
if(isset($_REQUEST['action']) && $_REQUEST['action']=="attendeelist"){
    $result=array();
    $result=getAttendieslist($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['attendees']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//Leader Board
if(isset($_REQUEST['action']) && $_REQUEST['action']=="leaderboard"){
    $result=array();
    $result=getLeaderBoard($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['leaderboard']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//Get the travel and info help list
if(isset($_REQUEST['action']) && $_REQUEST['action']=="travelinfo"){
    $result=array();
    $result=getTravelInfo($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['travel']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//Get the list of events
if(isset($_REQUEST['action']) && $_REQUEST['action']=="eventlist"){
    $result=array();
    $result=getUserEvents($pdo);

    if($result!=null){
        $reply['status']="success";
        $reply['events']=$result;
    }
    else{
        $reply['status']="fail";
    }
}

//Change the users active event
if(isset($_REQUEST['action']) && $_REQUEST['action']=="changeevent"){
    $result=array();
    $result=changeUserEvent($pdo);

    if($result="allok"){
        $reply['status']="success";
    }
    else{
        $reply['status']="fail";
    }
}




//echo "<pre>";
//print_r($reply);
echo json_encode($reply);


//Add a new post
function addNewPost($pdo){
    $p1=2;
    $p2=0;
    $p3=0;

    $post_user_id = $_REQUEST['userid'];
    $post_text = $_REQUEST['text'];
    $post_time = date("Y-m-d H:i:s");
    $post_agenda_id = $_REQUEST['agendaid'];
    $post_image=$_REQUEST['image'];
    $post_event=$_REQUEST['eventid'];

    $maxquery = $pdo->prepare("INSERT INTO post () VALUES () ");
    $maxquery->execute();
    $result = $pdo->lastInsertId();
    $post_id = $result;

    if($post_image!=""){
        $image_status = true;
        $p2=3;
    }
    else{
        $image_status = false;
        $p2=0;
    }

    if($post_agenda_id != ""){
        $post_agenda_status=true;
        $p3=1;
    }
    else{
        $post_agenda_status=false;
        $p3=0;
    }


        $query=$query=$pdo->prepare("UPDATE post SET post_user_id=:post_user_id, image_status=:image_status, post_text=:post_text, post_time=:post_time, post_agenda_id=:post_agenda_id, post_agenda_status=:post_agenda_status, post_image=:post_image, post_event=:post_event WHERE post_id=:post_id");
        $statusdbentry=$query->execute(array(
            ':post_id'       =>       $post_id,
            ':post_user_id'       =>       $post_user_id,
            ':image_status'       =>       $image_status,
            ':post_text'       =>       $post_text,
            ':post_time'       =>       $post_time,
            ':post_agenda_id'       =>       $post_agenda_id,
            ':post_agenda_status'       =>       $post_agenda_status,
            ':post_image'       =>       $post_image,
            ':post_event'       =>      $post_event,
        ));
    $point=$p1+$p2+$p3;
        if ($statusdbentry) {
            $query=$pdo->prepare("UPDATE leaderboard SET lbrd_user_pnt=lbrd_user_pnt+:point WHERE lbrd_user_id=:user_id AND lbrd_event_id=:event_id");
            $statusdbentry=$query->execute(array(
                ':point' => $point,
                ':user_id' =>$post_user_id,
                ':event_id' => $post_event,
            ));
            if($statusdbentry){
                return $post_user_id;
            }
            else{
                return "dbfault";
            }
        }
        else {
            return "dbfault";
        }
}

function getPointDetails($pdo,$uid){
    $r=array();
    $eventid=$_REQUEST['eventid'];
    if($uid!=1) {
        $query = $pdo->prepare("SELECT max(lbrd_user_pnt) AS lbrd_user_pnt,lbrd_user_id FROM leaderboard WHERE lbrd_event_id=:eventid");
        $query->execute(array(
            ':eventid' => $eventid,
        ));
        $res = $query->fetch(PDO::FETCH_ASSOC);

        $query = $pdo->prepare("SELECT lbrd_user_pnt FROM leaderboard WHERE lbrd_user_id=:user_id AND lbrd_event_id=:eventid");
        $query->execute(array(
            ':user_id' => $uid,
            ':eventid' => $eventid,
        ));
        $res2 = $query->fetch(PDO::FETCH_ASSOC);
        if ($res['lbrd_user_id'] != $uid) {
            $r['user_point'] = $res2['lbrd_user_pnt'];
            $r['to_first'] = ($res['lbrd_user_pnt'] - $res2['lbrd_user_pnt']);
        } else {
            $r['user_point'] = $res2['lbrd_user_pnt'];
            $r['to_first'] = ($res['lbrd_user_pnt'] - $res2['lbrd_user_pnt']) + 1;
        }
    }
    else{
        $r['user_point'] = 0;
        $r['to_first'] = 0;
    }
    return $r;
}

//Retreive all post for main page
function getAllPosts($pdo)
{
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT p.post_id,p.post_agenda_status,DATE_FORMAT(p.post_time, '%d %b %h:%i %p') post_date,p.post_text,p.image_status,p.post_image,a.agenda_id,a.agenda_name,u.id,u.firstname,u.lastname,u.user_image_stat,u.user_image FROM post p LEFT JOIN user u ON p.post_user_id=u.id LEFT JOIN agenda a ON p.post_agenda_id=a.agenda_id WHERE u.user_group=:user_group ORDER BY p.post_time DESC LIMIT 0,3");
    $query->execute(array(
        ':user_group' => $_REQUEST['user_group'],
    ));
    $q1=$pdo->prepare("SELECT COUNT(*) AS like_count FROM post_like WHERE post_like_id=:post_id");
    $q2=$pdo->prepare("SELECT COUNT(*) AS cmnt_count FROM post_comment WHERE post_cmnt_id=:post_id");
    $q3=$pdo->prepare("SELECT * FROM post_like WHERE post_like_id=:post_id AND user_like_id=:user_id");
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $q1->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q2->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q3->execute(array(
            ':post_id' => $res['post_id'],
            ':user_id' => $_REQUEST['user_id'],
        ));

        $r1=$q1->fetch(PDO::FETCH_ASSOC);
        $r2=$q2->fetch(PDO::FETCH_ASSOC);
        $r3=$q3->fetchAll(PDO::FETCH_ASSOC);

        $r[$i]=$res;
        $r[$i]['like_count']=$r1['like_count'];
        $r[$i]['cmnt_count']=$r2['cmnt_count'];
        if(count($r3)==1)
            $r[$i]['user_like_stat']=1;
        else
            $r[$i]['user_like_stat']=0;
        $i++;
    }
    return $r;
}

function getAllPosts2($pdo)
{
    $userid=$_REQUEST['userid'];
    $l=$_REQUEST['counter'];
    $eventid=$_REQUEST['eventid'];

    $r=array();
    $i=0;

    $start=10*$l;
    $query=$pdo->prepare("SELECT p.post_id,p.post_agenda_status,DATE_FORMAT(p.post_time, '%d %b %h:%i %p') post_date,p.post_text,p.image_status,p.post_image,p.post_event,a.agenda_id,a.agenda_name,u.id,u.firstname,u.lastname,u.user_image_stat,u.user_image FROM post p LEFT JOIN user u ON p.post_user_id=u.id LEFT JOIN agenda a ON p.post_agenda_id=a.agenda_id WHERE p.post_event=:user_event ORDER BY p.post_time DESC LIMIT ".$start.",10");
    $query->execute(array(
        ':user_event' => $eventid,
    ));
    $q1=$pdo->prepare("SELECT COUNT(*) AS like_count FROM post_like WHERE post_like_id=:post_id");
    $q2=$pdo->prepare("SELECT COUNT(*) AS cmnt_count FROM post_comment WHERE post_cmnt_id=:post_id");
    $q3=$pdo->prepare("SELECT * FROM post_like WHERE post_like_id=:post_id AND user_like_id=:user_id");
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $q1->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q2->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q3->execute(array(
            ':post_id' => $res['post_id'],
            ':user_id' => $userid,
        ));

        $r1=$q1->fetch(PDO::FETCH_ASSOC);
        $r2=$q2->fetch(PDO::FETCH_ASSOC);
        $r3=$q3->fetchAll(PDO::FETCH_ASSOC);

        $r[$i]=$res;
        $r[$i]['like_count']=$r1['like_count'];
        $r[$i]['cmnt_count']=$r2['cmnt_count'];
        if(count($r3)==1)
            $r[$i]['user_like_stat']=1;
        else
            $r[$i]['user_like_stat']=0;
        $i++;
    }
    return $r;
}

//Get No of Comments For a Specific post
function getNoOfComments($pdo)
{
    $query = $pdo->prepare("SELECT COUNT(*) AS total_c FROM post_comment WHERE post_cmnt_id=:post_id");
    $query->execute(array(
        ':post_id' => $_REQUEST['post_id'],
    ));
    $res = $query->fetch(PDO::FETCH_ASSOC);
    return $res['total_c'];
}

//Get All comments to a specific post
function getComments($pdo){
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT pc.post_cmnt_id,pc.cmnt_text,DATE_FORMAT(pc.post_cmnt_time, '%d %b at %h:%i %p') post_cmnt_time,u.id,u.firstname,u.lastname,u.user_image_stat,u.user_image FROM post_comment pc LEFT JOIN user u ON pc.user_cmnt_id=u.id WHERE pc.post_cmnt_id=:post_id ORDER BY pc.post_cmnt_time ASC");
    $query->execute(array(
        ':post_id' => $_REQUEST['post_id'],
    ));
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $r[$i]=$res;
        $i++;
    }
    return $r;
}

//Add a new comment to a specific post
function addNewComment($pdo){
    $post_cmnt_id = $_REQUEST['post_id'];
    $user_cmnt_id = $_REQUEST['user_id'];
    $cmnt_text = $_REQUEST['cmnt_text'];
    $post_cmnt_time = date("Y-m-d H:i:s");
    $eventid=$_REQUEST['event_id'];


    $query=$pdo->prepare("INSERT INTO post_comment
     (post_cmnt_id,user_cmnt_id,cmnt_text,post_cmnt_time)
VALUES
     (:post_cmnt_id,:user_cmnt_id,:cmnt_text,:post_cmnt_time)                  ");

    $statusdbentry=$query->execute(array(
        ':post_cmnt_id' => $post_cmnt_id,
        ':user_cmnt_id' => $user_cmnt_id,
        ':cmnt_text' => $cmnt_text,
        ':post_cmnt_time' => $post_cmnt_time,
    ));
    if ($statusdbentry) {
        $query = $pdo->prepare("UPDATE leaderboard SET lbrd_user_pnt=lbrd_user_pnt+:point WHERE lbrd_user_id=:user_id AND lbrd_event_id=:eventid");
        $statusdbentry = $query->execute(array(
            ':point' => 1,
            ':user_id' => $user_cmnt_id,
            ':eventid' => $eventid,
        ));
        if ($statusdbentry) {
            return "allok";
        } else {
            return "dbfault";
        }
    }
    else {
        return "dbfault";
    }
}

//Like or Dislike a Specific Post
function addNewLike($pdo)
{
    $post_like_id = $_REQUEST['post_id'];
    $user_like_id = $_REQUEST['user_id'];
    $eventid=$_REQUEST['event_id'];
    $post_like_time = date("Y-m-d H:i:s");

    $q3 = $pdo->prepare("SELECT * FROM post_like WHERE post_like_id=:post_id AND user_like_id=:user_id");
    $q3->execute(array(
        ':post_id' => $post_like_id,
        ':user_id' => $user_like_id,
    ));
    $r3 = $q3->fetchAll(PDO::FETCH_ASSOC);
    if (count($r3) > 0) {
        $query = $pdo->prepare("DELETE FROM post_like WHERE post_like_id=:post_id AND user_like_id=:user_id");
        $statusdbentry = $query->execute(array(
            ':post_id' => $post_like_id,
            ':user_id' => $user_like_id,
        ));
        if ($statusdbentry) {
            $query = $pdo->prepare("UPDATE leaderboard SET lbrd_user_pnt=lbrd_user_pnt-:point WHERE lbrd_user_id=:user_id AND lbrd_event_id=:eventid");
            $statusdbentry = $query->execute(array(
                ':point' => 1,
                ':user_id' => $user_like_id,
                ':eventid' => $eventid,
            ));
        }
    }
    else {
        $query = $pdo->prepare("INSERT INTO post_like
        (post_like_id,user_like_id,post_like_time)
        VALUES
        (:post_like_id,:user_like_id,:post_like_time)                  ");

        $statusdbentry = $query->execute(array(
            ':post_like_id' => $post_like_id,
            ':user_like_id' => $user_like_id,
            ':post_like_time' => $post_like_time,
        ));
        if ($statusdbentry) {
            $query = $pdo->prepare("UPDATE leaderboard SET lbrd_user_pnt=lbrd_user_pnt+:point WHERE lbrd_user_id=:user_id AND lbrd_event_id=:eventid");
            $statusdbentry = $query->execute(array(
                ':point' => 1,
                ':user_id' => $user_like_id,
                ':eventid' => $eventid,
            ));
        }
    }

    if ($statusdbentry) {
        return "allok";
    } else {
        return "dbfault";
    }
}

function getNoOfLikes($pdo)
{
    $query = $pdo->prepare("SELECT COUNT(*) AS total_l FROM post_like WHERE post_like_id=:post_id");
    $query->execute(array(
        ':post_id' => $_REQUEST['post_id'],
    ));
    $res = $query->fetch(PDO::FETCH_ASSOC);
    return $res['total_l'];
}

function getLikes($pdo){
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT pl.post_like_id,DATE_FORMAT(pl.post_like_time, '%d %b at %h:%i %p') post_like_time,u.id,u.firstname,u.lastname,u.user_image_stat,u.user_image FROM post_like pl LEFT JOIN user u ON pl.user_like_id=u.id WHERE pl.post_like_id=:post_id ORDER BY pl.post_like_time DESC");
    $query->execute(array(
        ':post_id' => $_REQUEST['post_id'],
    ));
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $r[$i]=$res;
        $i++;
    }
    return $r;
}


/*------------------agenda------------*/

function getAllAgendas($pdo){

    $eventid=$_REQUEST['event_id'];
    $userid=$_REQUEST['user_id'];
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT agenda_id,agenda_name,DATE_FORMAT(agenda_from, '%l.%i %p') agenda_from,DATE_FORMAT(agenda_to, '%l.%i %p') agenda_to,DATE_FORMAT(agenda_from, '%M %d') agenda_date,agenda_place,poll_stat,agenda_to AS agenda_endtime
                        FROM agenda WHERE agenda_event=:eventid ORDER BY agenda_from ASC ");
    $query->execute(array(
        ':eventid' => $eventid,
    ));

    $q1=$pdo->prepare("SELECT COUNT(*) AS isattending FROM agenda_user WHERE agenda_user_id=:agenda_id AND user_agenda_id=:user_id");
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        $r[$i]=$res;
        $q1->execute(array(
            ':agenda_id' => $res['agenda_id'],
            ':user_id' => $userid,
        ));
        $count=$q1->fetch(PDO::FETCH_ASSOC);
        if($count['isattending']>0){
            $r[$i]['user_attending']=1;
        }
        else{
            $r[$i]['user_attending']=0;
        }
        if($r[$i]['poll_stat']==0){
            $datepoll=new DateTime($r[$i]['agenda_endtime']);
            $datenow=new DateTime();
            if ($datenow>$datepoll){
                $r[$i]['poll_stat']=1;
            }
        }

        $i++;
    }
    return $r;
}

function getSingleAgenda($pdo){

    $agendaid=$_REQUEST['agenda_id'];
    $userid=$_REQUEST['user_id'];
    $query=$pdo->prepare("SELECT agenda_id,agenda_name,DATE_FORMAT(agenda_from, '%d') agenda_day,DATE_FORMAT(agenda_from, '%b-%Y') agenda_mnthyr,DATE_FORMAT(agenda_from, '%l.%i %p') agenda_from,DATE_FORMAT(agenda_to, '%l.%i %p') agenda_to,DATE_FORMAT(agenda_from, '%M %d') agenda_date,agenda_place,agenda_desc,poll_stat,agenda_to AS agenda_endtime
                        FROM agenda WHERE agenda_id=:agenda_id");

    $q1=$pdo->prepare("SELECT COUNT(*) AS isattending FROM agenda_user WHERE agenda_user_id=:agenda_id AND user_agenda_id=:user_id");


    $query->execute(array(
        ':agenda_id' => $agendaid,
    ));
    $r=$query->fetch(PDO::FETCH_ASSOC);

    $q1->execute(array(
        ':agenda_id' => $agendaid,
        ':user_id' => $userid,
    ));
    $r2=$q1->fetch(PDO::FETCH_ASSOC);

    if($r2['isattending']>=1){
        $r['user_attending']=1;
    }
    else{
        $r['user_attending']=0;
    }

    if($r['poll_stat']==0){
        $datepoll=new DateTime($r['agenda_endtime']);
        $datenow=new DateTime();
        if ($datenow>$datepoll){
            $r['poll_stat']=1;
        }
    }

    return $r;
}

function getAgendaSpeakers($pdo){
    $agendaid=$_REQUEST['agenda_id'];
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT s.speaker_id,s.speaker_fname,s.speaker_lname,s.speaker_desg,s.speaker_img_stat,s.speaker_img FROM agenda_speaker asp LEFT JOIN speaker s ON asp.speaker_agenda_id=s.speaker_id WHERE asp.agenda_speaker_id=:agenda_id");
    $query->execute(array(
        ':agenda_id' => $agendaid,
    ));
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['speaker_img_stat']==0){
            $res['speaker_img']=strtoupper(substr($res['speaker_fname'],0,1).substr($res['speaker_lname'],0,1));
        }
        $r[$i]=$res;
        $i++;
    }
    return $r;
}

function getAllAgendaActivity($pdo){
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT p.post_id,p.post_agenda_status,DATE_FORMAT(p.post_time, '%d %b %h:%i %p') post_date,p.post_text,p.image_status,p.post_image,a.agenda_name,u.id,u.firstname,u.lastname,u.user_image_stat,u.user_image FROM post p LEFT JOIN user u ON p.post_user_id=u.id LEFT JOIN agenda a ON p.post_agenda_id=a.agenda_id WHERE p.post_agenda_id=:agenda_id AND u.user_group=:user_group ORDER BY p.post_time DESC LIMIT 0,3");
    $query->execute(array(
        ':agenda_id' => $_REQUEST['agenda_id'],
        ':user_group' => $_REQUEST['user_group'],
    ));
    $q1=$pdo->prepare("SELECT COUNT(*) AS like_count FROM post_like WHERE post_like_id=:post_id");
    $q2=$pdo->prepare("SELECT COUNT(*) AS cmnt_count FROM post_comment WHERE post_cmnt_id=:post_id");
    $q3=$pdo->prepare("SELECT * FROM post_like WHERE post_like_id=:post_id AND user_like_id=:user_id");
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $q1->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q2->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q3->execute(array(
            ':post_id' => $res['post_id'],
            ':user_id' => $_REQUEST['user_id'],
        ));

        $r1=$q1->fetch(PDO::FETCH_ASSOC);
        $r2=$q2->fetch(PDO::FETCH_ASSOC);
        $r3=$q3->fetchAll(PDO::FETCH_ASSOC);

        $r[$i]=$res;
        $r[$i]['like_count']=$r1['like_count'];
        $r[$i]['cmnt_count']=$r2['cmnt_count'];
        if(count($r3)==1)
            $r[$i]['user_like_stat']=1;
        else
            $r[$i]['user_like_stat']=0;
        $i++;
    }
    return $r;
}

function getAllAgendaActivity2($pdo){
    $r=array();
    $i=0;
    $userid=$_REQUEST['user_id'];
    $agendaid=$_REQUEST['agenda_id'];
    $l=$_REQUEST['counter'];
    $start=10*$l;
    $query=$pdo->prepare("SELECT p.post_id,p.post_agenda_status,DATE_FORMAT(p.post_time, '%d %b %h:%i %p') post_date,p.post_text,p.image_status,p.post_image,a.agenda_name,u.id,u.firstname,u.lastname,u.user_image_stat,u.user_image FROM post p LEFT JOIN user u ON p.post_user_id=u.id LEFT JOIN agenda a ON p.post_agenda_id=a.agenda_id WHERE p.post_agenda_id=:agenda_id ORDER BY p.post_time DESC LIMIT ".$start.",10");
    $query->execute(array(
        ':agenda_id' => $agendaid,
    ));
    $q1=$pdo->prepare("SELECT COUNT(*) AS like_count FROM post_like WHERE post_like_id=:post_id");
    $q2=$pdo->prepare("SELECT COUNT(*) AS cmnt_count FROM post_comment WHERE post_cmnt_id=:post_id");
    $q3=$pdo->prepare("SELECT * FROM post_like WHERE post_like_id=:post_id AND user_like_id=:user_id");
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $q1->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q2->execute(array(
            ':post_id' => $res['post_id'],
        ));
        $q3->execute(array(
            ':post_id' => $res['post_id'],
            ':user_id' => $userid,
        ));

        $r1=$q1->fetch(PDO::FETCH_ASSOC);
        $r2=$q2->fetch(PDO::FETCH_ASSOC);
        $r3=$q3->fetchAll(PDO::FETCH_ASSOC);

        $r[$i]=$res;
        $r[$i]['like_count']=$r1['like_count'];
        $r[$i]['cmnt_count']=$r2['cmnt_count'];
        if(count($r3)==1)
            $r[$i]['user_like_stat']=1;
        else
            $r[$i]['user_like_stat']=0;
        $i++;
    }
    return $r;
}

//Attend or not attend the agenda
function addAttendingAgenda($pdo){
    $agendaid = $_REQUEST['agenda_id'];
    $userid = $_REQUEST['user_id'];

    $q3 = $pdo->prepare("SELECT * FROM agenda_user WHERE agenda_user_id=:agenda_id AND user_agenda_id=:user_id");
    $q3->execute(array(
        ':agenda_id' => $agendaid,
        ':user_id' => $userid,
    ));
    $r3 = $q3->fetchAll(PDO::FETCH_ASSOC);
    if (count($r3) > 0) {
        $query = $pdo->prepare("DELETE FROM agenda_user WHERE agenda_user_id=:agenda_id AND user_agenda_id=:user_id");
        $statusdbentry = $query->execute(array(
            ':agenda_id' => $agendaid,
            ':user_id' => $userid,
        ));
    }
    else {
        $query = $pdo->prepare("INSERT INTO agenda_user
        (agenda_user_id,user_agenda_id)
        VALUES
        (:agenda_id,:user_id)                  ");

        $statusdbentry = $query->execute(array(
            ':agenda_id' => $agendaid,
            ':user_id' => $userid,
        ));
    }

    if ($statusdbentry) {
        return "allok";
    } else {
        return "dbfault";
    }
}

/*------------------agenda - end------------*/

/*------------------speaker ------------*/

//Get Details Of a Speaker
function getSpeakerDetails($pdo){
    $query=$pdo->prepare("SELECT * FROM speaker WHERE speaker_id=:speaker_id");
    $query->execute(array(
        ':speaker_id' => $_REQUEST['speaker_id'],
    ));
    $res=$query->fetch(PDO::FETCH_ASSOC);
    return $res;
}

//Get Agendas Of A Speaker
function getSpeakersAgendas($pdo){
    $speakerid=$_REQUEST['speaker_id'];
    $eventid=$_REQUEST['event_id'];
    $userid=$_REQUEST['user_id'];
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT agenda_id,agenda_name,DATE_FORMAT(agenda_from, '%l.%i %p') agenda_from,DATE_FORMAT(agenda_to, '%l.%i %p') agenda_to,DATE_FORMAT(agenda_from, '%M %d') agenda_date,agenda_place FROM agenda WHERE agenda_id IN (SELECT agenda_speaker_id FROM agenda_speaker WHERE speaker_agenda_id=:speakerid AND agenda_event_id=:eventid)");
    $query->execute(array(
        ':speakerid' => $speakerid,
        ':eventid' => $eventid,
    ));
    $q1=$pdo->prepare("SELECT COUNT(*) AS isattending FROM agenda_user WHERE agenda_user_id=:agenda_id AND user_agenda_id=:user_id");
    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        $r[$i]=$res;
        $q1->execute(array(
            ':agenda_id' => $res['agenda_id'],
            ':user_id' => $userid,
        ));
        $count=$q1->fetch(PDO::FETCH_ASSOC);
        if($count['isattending']>0){
            $r[$i]['user_attending']=1;
        }
        else{
            $r[$i]['user_attending']=0;
        }

        $i++;
    }
    return $r;
}

//List of speakers and their details
function getSpeakerlist($pdo){
    $eventid=$_REQUEST['event_id'];
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT DISTINCT s.speaker_id,s.speaker_fname,s.speaker_lname,s.speaker_desg,s.speaker_img_stat,s.speaker_img FROM speaker s INNER JOIN agenda_speaker a ON s.speaker_id=a.speaker_agenda_id WHERE a.agenda_event_id=:eventid");
    $query->execute(array(
        ':eventid' =>  $eventid,
    ));
    $r=$query->fetchAll(PDO::FETCH_ASSOC);
//    while($res=$query->fetch(PDO::FETCH_ASSOC)){
//        $r[$i]=$res;
//        $q2=$pdo->prepare("SELECT agenda_id,agenda_name,DATE_FORMAT(agenda_from, '%l.%i %p') agenda_from,DATE_FORMAT(agenda_to, '%l.%i %p') agenda_to,DATE_FORMAT(agenda_from, '%M %d') agenda_date,agenda_place FROM agenda WHERE agenda_id IN (SELECT agenda_speaker_id FROM agenda_speaker WHERE speaker_agenda_id=:speaker_id AND agenda_event_id=:eventid)");
//        $q2->execute(array(
//            ':speaker_id' => $res['speaker_id'],
//            ':eventid' => $eventid,
//        ));
//        $r2=$q2->fetchAll(PDO::FETCH_ASSOC);
//        $r[$i]['agendas']=$r2;
//        $i++;
//    }
    return $r;
}

/*------------------speaker - end------------*/

/*------------------question-polls------------*/

function getQuestionlist($pdo){
    $userid=$_REQUEST['user_id'];
    $agendaid=$_REQUEST['agenda_id'];
    $r=array();
    $query=$pdo->prepare("SELECT q.qstn_id,q.qstn_qstn,count(CASE WHEN p.poll_qstn_id > 0 THEN 1 END) AS total_vote,(CASE WHEN GROUP_CONCAT('(',p.poll_user_id,')' SEPARATOR ',')  LIKE :userid THEN 1 ELSE 0 END) AS user_vote_stat FROM question q LEFT JOIN question_poll p ON q.qstn_id=p.poll_qstn_id WHERE q.qstn_agenda_id=:agendaid GROUP BY q.qstn_id");
    $query->execute(array(
        ':userid' => "%(".$userid.")%",
        ':agendaid' => $agendaid,
    ));
    $res=$query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function getQuestionPoll($pdo){
    $userid=$_REQUEST['user_id'];
    $qstnid=$_REQUEST['qstn_id'];

    $q1=$pdo->prepare("SELECT qstn_id,qstn_qstn,qstn_opt1,qstn_opt2,qstn_opt3,qstn_opt4,qstn_opt5 FROM question WHERE qstn_id=:qstnid");
    $q1->execute(array(
        ':qstnid' => $qstnid,
    ));

    $q2=$pdo->prepare("SELECT SUM(poll_option = 1) AS count_opt1, SUM(poll_option = 2) AS count_opt2, SUM(poll_option = 3) AS count_opt3, SUM(poll_option = 4) AS count_opt4, SUM(poll_option = 5) AS count_opt5,SUM(poll_qstn_id=:qstnid) AS total_vote  FROM question_poll WHERE poll_qstn_id=:qstnid ");
    $q2->execute(array(
        ':qstnid' => $qstnid,
    ));


    $q3=$pdo->prepare(" SELECT  poll_option FROM question_poll WHERE poll_user_id=:userid AND poll_qstn_id=:qstnid");
    $q3->execute(array(
        ':qstnid' => $qstnid,
        ':userid' => $userid,
    ));

    $r=array_merge($q1->fetch(PDO::FETCH_ASSOC),$q2->fetch(PDO::FETCH_ASSOC));

    $res=$q3->fetch(PDO::FETCH_ASSOC);
    if(count($res)==0){
        $r['user_optn']=0;
    }
    else{
        $r['user_option']=$res['poll_option'];
    }
    return $r;
}

function doVoting($pdo){
    $qstnid=$_REQUEST['qstn_id'];
    $userid=$_REQUEST['user_id'];
    $userpoll=$_REQUEST['user_poll'];
    $r=false;
    $q1=$pdo->prepare("SELECT COUNT(*) as vote_stat FROM question_poll WHERE poll_qstn_id=:qstnid AND poll_user_id=:userid");
    $q1->execute(array(
        ':qstnid' => $qstnid,
        ':userid' => $userid,
    ));
    $r1=$q1->fetch(PDO::FETCH_ASSOC);

    //already voted
    if($r1['vote_stat']>0){

        $r=false;
        $q2=$pdo->prepare("UPDATE question_poll SET poll_option=:userpoll WHERE poll_qstn_id=:qstnid AND poll_user_id=:userid");
        $r=$q2->execute(array(
            ':userpoll' => $userpoll,
            ':qstnid' => $qstnid,
            ':userid' => $userid,
        ));
    }
    //not voted yet
    if($r1['vote_stat']==0){
        $q2=$pdo->prepare("INSERT INTO question_poll (poll_qstn_id,poll_user_id,poll_option) VALUES (:qstnid,:userid,:userpoll)");
        $r=$q2->execute(array(
            'userpoll' => $userpoll,
            ':qstnid' => $qstnid,
            ':userid' => $userid,
        ));

    }
    return $r;
}


/*------------------question-polls-end----------*/


/*------------------event----------*/

function getUserEvents($pdo){
    $query=$pdo->prepare("SELECT event_id,event_name,event_loc FROM event WHERE event_id IN(SELECT event_user_id FROM event_user WHERE user_event_id=:userid) AND event_active=1");
    $query->execute(array(
        ':userid' => $_REQUEST['user_id'],
    ));
    $res=$query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function changeUserEvent($pdo){
    $query=$pdo->prepare("UPDATE user SET user_event=:eventid WHERE id=:userid");
    $query->execute(array(
        ':eventid' => $_REQUEST['event_id'],
        ':userid' => $_REQUEST['user_id'],
    ));
    $res=$query->fetchAll(PDO::FETCH_ASSOC);
    if($res){
        return "allok";
    }
    else{
        return "fail";
    }
}

/*------------------event-end----------*/


function getSponserList($pdo){
    $r=array();
    $i=0;
    $query=$pdo->query("SELECT * FROM sponser ORDER BY spnsr_name ASC ");
    $query->execute();

    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        $r[$i]=$res;
        $r[$i]['spnsr_intro']=substr($res['spnsr_desc'],0,50);
        $i++;
    }
    return $r;
}

function getAttendieslist($pdo){
    $r=array();
    $i=0;
//    $query=$pdo->prepare("SELECT u.id,u.type,u.user_group,u.firstname,u.lastname,u.designation,u.location,u.user_image_stat,u.user_image FROM user u LEFT JOIN event_user e WHERE event_user_id=:eventid ORDER BY firstname");
    $query=$pdo->prepare("SELECT id,type,user_group,firstname,lastname,designation,location,user_image_stat,user_image FROM user WHERE id IN(SELECT user_event_id FROM event_user WHERE event_user_id=:eventid)");
    $query->execute(array(
        ':eventid' => $_REQUEST['event_id'],
    ));

    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $r[$i]=$res;
        $i++;
    }
    return $r;
}

function getLeaderBoard($pdo){
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT u.id,u.type,u.user_group,u.firstname,u.lastname,u.designation,u.location,u.user_image_stat,u.user_image,l.lbrd_user_pnt FROM user u INNER JOIN leaderboard l ON u.id=l.lbrd_user_id WHERE u.user_event=:eventid  ORDER BY l.lbrd_user_pnt DESC");
    $query->execute(array(
        ':eventid' => $_REQUEST['event_id'],
    ));

    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        if($res['user_image_stat']==0){
            $res['user_image']=strtoupper(substr($res['firstname'],0,1).substr($res['lastname'],0,1));
        }
        $r[$i]=$res;
        $i++;
    }
    return $r;
}

function getTravelInfo($pdo){
    $r=array();
    $i=0;
    $query=$pdo->prepare("SELECT * FROM travel WHERE tevent_id=:eventid");
    $query->execute(array(
        ':eventid' => $_REQUEST['event_id'],
    ));

    while($res=$query->fetch(PDO::FETCH_ASSOC)){
        $r[$i]=$res;
        $r[$i]['tintro']=substr(strip_tags($res['tdesc']),0,50);
        $i++;
    }
    return $r;
}

