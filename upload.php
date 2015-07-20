<?php
include("resize-class.php");
$userid = $_REQUEST['userid'];
$time   = time();
$result=array();
$result['status']="fail";
$new_image_name = $userid."_".$time.".jpg";
$destination="uploads/image_full/".$new_image_name;
//move_uploaded_file($_FILES["file"]["tmp_name"],$destination );
if(move_uploaded_file($_FILES["file"]["tmp_name"],$destination )) {

    $resizeObj = new resize($destination);

// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
    $resizeObj->resizeImage(300, 200, 'crop');

// *** 3) Save image $destination  = "upload/".$random;
    $destination2 = "uploads/".$new_image_name;
    $resizeObj->saveImage($destination2, 100);

    $result['status']="success";
    $result['image_name']=$new_image_name;
}
echo json_encode($result);
?>