<?php
include_once("../functions.php");
$uploaddir = '../files/contractor/';

$idcontract=$_POST['idcontract'];
if(isset($_FILES["file"]))
{
  $rs = array();
$userfile_name=($_FILES['file']['name']);
$orig_file=$_FILES['file']['name'];
$ext = pathinfo($orig_file, PATHINFO_EXTENSION);
$tmp=randomhash();
$userfile_name=$tmp;
$uploadfile = $uploaddir.$userfile_name.".".$ext;

$sr=$_FILES['file']['tmp_name'];
$dest=$uploadfile;

$res=move_uploaded_file($sr,$dest);
if ($res!=false){
        $rs = array("msg" => "$userfile_name");
      $stmt = $dbConnection->prepare ("INSERT INTO files_contractor (id,idcontract,filename,userfreandlyfilename,file_ext) VALUES (null,:idcontract,:userfile_name,:orig_file,:ext)");
      $stmt->execute(array(':idcontract' => $idcontract, ':userfile_name' => $userfile_name, ':orig_file' => $orig_file, ':ext' => $ext));

    } else {        $rs = array("msg" => 'error');    };
echo json_encode($rs);
}
?>