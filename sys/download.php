<?php
include_once("../functions.php");
if (isset($_GET["step"])) {$step=$_GET["step"];} else {$step="";};
$id =$_GET['id'];
    if ($step=="requisites")
{
    $stmt = $dbConnection->prepare ("SELECT * FROM files_requisites where id=:id");
    $stmt->execute(array(':id' => $id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $filename=$row['filename'];
            $ext=$row['file_ext'];
            $userfreandlyfilename=$row['userfreandlyfilename'];
            switch($ext){
          case gif: $application="image/gif";
          break;
          case jpeg: $application="image/jpeg";
          break;
          case jpg: $application="image/jpeg";
          break;
          case png: $application="image/png";
          break;
          case doc: $application="application/msword";
          break;
          case xls: $application="application/vnd.ms-excel";
          break;
          case rtf: $application="application/rtf";
          break;
          case pdf: $application="application/pdf";
          break;
          case bmp: $application="image/bmp";
          break;
          case docx: $application="application/vnd.openxmlformats-officedocument.wordprocessingml.document";
          break;
          case xlsx: $application="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
          break;
            }


    //echo $filename;
    if (file_exists("../files/requisites/".$filename.".".$ext)) {
      header("Content-Disposition: File Transfer");
      header("Content-Type:".$application."");
      header("Content-Disposition:  attachment; filename=\"" . $userfreandlyfilename . "\";" );
      header("Content-Transfer-Encoding:  binary");
      header("Expires: 0");
      header("Cache-Control: must-revalidate");
      header("Pragma: public");
      header("Content-Length:" . filesize("../files/requisites/".$filename.".".$ext));

      ob_clean();
      flush();
      readfile("../files/requisites/".$filename.".".$ext);
      exit;
          }
    }
    if ($step=="contractor")
{
    $stmt = $dbConnection->prepare ("SELECT * FROM files_contractor where id=:id");
    $stmt->execute(array(':id' => $id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $filename=$row['filename'];
            $ext=$row['file_ext'];
            $userfreandlyfilename=$row['userfreandlyfilename'];
            switch($ext){
            case gif: $application="image/gif";
            break;
            case jpeg: $application="image/jpeg";
            break;
            case jpg: $application="image/jpeg";
            break;
            case png: $application="image/png";
            break;
            case doc: $application="application/msword";
            break;
            case xls: $application="application/vnd.ms-excel";
            break;
            case rtf: $application="application/rtf";
            break;
            case pdf: $application="application/pdf";
            break;
            case bmp: $application="image/bmp";
            break;
            case docx: $application="application/vnd.openxmlformats-officedocument.wordprocessingml.document";
            break;
            case xlsx: $application="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
            break;
            }

    //echo $filename;
    if (file_exists("../files/contractor/".$filename.".".$ext)) {
      header("Content-Disposition: File Transfer");
      header("Content-Type:".$application."");
      header("Content-Disposition:  attachment; filename=\"" . $userfreandlyfilename . "\";" );
      header("Content-Transfer-Encoding:  binary");
      header("Expires: 0");
      header("Cache-Control: must-revalidate");
      header("Pragma: public");
      header("Content-Length:" . filesize("../files/contractor/".$filename.".".$ext));

      ob_clean();
      flush();
      readfile("../files/contractor/".$filename.".".$ext);
      exit;
          }
    }
    if ($step=="documents")
{
    $stmt = $dbConnection->prepare ("SELECT * FROM files_documents where id=:id");
    $stmt->execute(array(':id' => $id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $filename=$row['filename'];
            $ext=$row['file_ext'];
            $userfreandlyfilename=$row['userfreandlyfilename'];
            switch($ext){
            case gif: $application="image/gif";
            break;
            case jpeg: $application="image/jpeg";
            break;
            case jpg: $application="image/jpeg";
            break;
            case png: $application="image/png";
            break;
            case doc: $application="application/msword";
            break;
            case xls: $application="application/vnd.ms-excel";
            break;
            case rtf: $application="application/rtf";
            break;
            case pdf: $application="application/pdf";
            break;
            case bmp: $application="image/bmp";
            break;
            case docx: $application="application/vnd.openxmlformats-officedocument.wordprocessingml.document";
            break;
            case xlsx: $application="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
            break;
            }

    //echo $filename;
    if (file_exists("../files/documents/".$filename.".".$ext)) {
      header("Content-Disposition: File Transfer");
      header("Content-Type:".$application."");
      header("Content-Disposition:  attachment; filename=\"" . $userfreandlyfilename . "\";" );
      header("Content-Transfer-Encoding:  binary");
      header("Expires: 0");
      header("Cache-Control: must-revalidate");
      header("Pragma: public");
      header("Content-Length:" . filesize("../files/documents/".$filename.".".$ext));

      ob_clean();
      flush();
      readfile("../files/documents/".$filename.".".$ext);
      exit;
          }
    }
?>