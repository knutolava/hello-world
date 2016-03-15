<?php
$target_dir = "uploads/";
$uploadOk = false;
$result = array('status' => false, 'message' => "Something went wrong!");
include 'db/dbupload.php';
$max_width = 400;
$max_hight = 400;

 function Img_Resize($path) {

           $x = getimagesize($path);
           $width  = $x['0'];
           $height = $x['1'];

           $rs_width  = 240;
           $rs_height = 180;

                 $img = imagecreatefrompng($path);


           $img_base = imagecreatetruecolor($rs_width, $rs_height);
          return imagecopyresized($img_base, $img, 0, 0, 0, 0, $rs_width, $rs_height, $width, $height);

        }


foreach($_FILES["fileupload"]["name"] as $key => $value){
    $uploadOk=true;
    $tmp_name = $_FILES["fileupload"]["tmp_name"][$key];
    $name = $_FILES["fileupload"]["name"][$key];
    $target_file = $target_dir . basename($name);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
      $x = getimagesize($target_file);
           $width  = $x['0'];
           $height = $x['1'];


    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
        $uploadOk = false;
        $result = array('status' => false, 'message' => "Not an image, try again!" );
    }
    if($uploadOk&&move_uploaded_file($tmp_name, $target_file)){
        if($width>$max_width || $height > $max_hight){
         Img_Resize($target_file);
         addToDb($target_file);
        $result = array('status' => true, 'message' => "Picture resized and uploaded!");
        }else{
        addToDb($target_file);
        $result = array('status' => true, 'message' => "Picture uploaded!");
            }
    }

}
echo json_encode($result);
?>
