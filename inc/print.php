<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('2-2', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
     <div class="page-header" style="margin-top: -15px;">
     <div class="row">
              <div class="col-md-6"> <h3><i class="fa fa-info"></i>&nbsp;<?=get_lang('Menu_printer');?></h3>
              </div>
     </div>
      </div>
     <div class="row">
       <div class="col-md-12">
         <div class="panel panel-default">
         <div class="panel-heading">
           <div class="col-md-3" style="margin-bottom:20px;">
           <label class="control-label"><small><?=get_lang('Places')?>:</small></label>
           <select data-placeholder="Выберите помещение" class='my_select select' name=splaces id=splaces>
                  <option value=""></option>
                  <?php
                  $morgs=GetArrayPlaces_Print_Test();
                  for ($i = 0; $i < count($morgs); $i++) {
                      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                      if ($nid==$placesid){$sl=" selected";} else {$sl="";};
                      echo "<option value=$nid $sl>$nm</option>";
                  };
                  ?>
               </select>
             </div>
             <div class="col-md-3" style="margin-bottom:20px;">

           <label class="control-label"><small><?=get_lang('Matname')?>:</small></label>
         <select data-placeholder="Выберите Мат.отв." class='my_select select' name=suserid id=suserid>
               <option value=""></option>
               <?php
               $morgs=GetArrayUsers_Print_Test();
               for ($i = 0; $i < count($morgs); $i++) {
                   $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
                   if ($nid==$userid){$sl=" selected";} else {$sl="";};
                   echo "<option value=$nid $sl>$nm</option>";
               };
               ?>
             </select>
         </div>
           <button type="submit" id="print_test" class="btn btn-primary btn-block" name="print_test"><i class="fa fa-hand-o-up"></i>&nbsp;<?=get_lang('Button_print_test');?></button>
         </div>

         <div class="panel-body">
           <div id="print_test_show">
         <table  id="table_print_test" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
         <thead>
         <tr>
         <th class="center_header"><?=get_lang('Status')?></th>
         <th class="center_header"><?=get_lang('Ip_name')?></th>
         <th class="center_header"><?=get_lang('Namenome')?></th>
         <th class="center_header"><?=get_lang('Print_color')?></th>
         <th class="center_header"><?=get_lang('Sernumber')?></th>
         <th class="center_header"><?=get_lang('Mod_cart')?></th>
         <th class="center_header"><?=get_lang('Residue')?></th>
         <th class="center_header"><?=get_lang('Published')?></th>
         <th class="center_header"><?=get_lang('Places')?></th>
         <th class="center_header"><?=get_lang('Matname')?></th>
         </tr>
         </thead>
         </table>
         </div>
         </div>
         </div>
         </div>
       </div>
     </div>
     <?php
     }
      else{
     ?>
     <div class="row">
       <div class="col-md-12">
         <center>
         <font size="20"><?=get_lang('Access_denied')?></font>
       </center>
       </div>
     </div>
     <br>
     <?php
     }
     include("footer.php");
     }
     else {
         include 'auth.php';
     }
      ?>
