<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
if (validate_priv($_SESSION['dilema_user_id']) == 1) {
include("header.php");
include("menus.php");
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_delete');?></h3>
            </div>
   </div>
    </div>
 <div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?=get_lang('Delete_title');?>
    </div>
    <div class="panel-body">
      <div id="before_delete">
      <?php
      $mfiles1=GetArrayFilesInDir("deleterules");
      foreach ($mfiles1 as &$fname1) {
          if (strripos($fname1,".xml")!=FALSE){
          $xml = simplexml_load_file("deleterules/$fname1");
           foreach($xml->entertable as $data){
                  $entertable_name=$data["name"];
                  $entertable_key=$data["key"];
                  $entertable_comment = lang_delete($entertable_name);
                  $stmt = $dbConnection->prepare("SELECT * FROM $entertable_name where active=0");
                  $stmt->execute();
                  $res1 = $stmt->fetchall();

                  foreach($res1 as $myrow) {
                      $entertable_id=$myrow["$entertable_key"];

                      echo "<i class=\"fa fa-trash fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Table')." <b>$entertable_name ($entertable_comment)</b> ".get_lang('Metka')." $entertable_key = $entertable_id <button id=\"otmena\" class=\"btn btn-xs btn-primary\" id_del=\"$entertable_id\" name=\"$entertable_name\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Otmena')."\"><i class=\"fa fa-remove fa-fw\" aria-hidden=\"true\"></i></button></br>";
                      }

                    }

                  }

                }
                unset($fname1);
       ?>
     </div>
     <div id="delete_ok">
     <?php
     if ($entertable_id != ''){
     echo "<br><b>".get_lang('Delete_ok')."</b> <button class=\"btn btn-danger\" type=\"button\" name=\"dell_all\" id=\"dell_all\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Delete_button')."</button></p>";
     }
      ?>
    </div>
      <div id="infoblock"></div>
    </div>
 </div>
 </div>
 </div>
 </div>
 <?php
 include("footer.php");
}
}
else {
    include 'auth.php';
}
  ?>