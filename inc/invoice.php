<?php
if(!isset($_SESSION))
{
        session_start();
}
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('1-2', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-paperclip" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_invoice');?></h3>
            </div>
   </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
          <div class="col-md-8">
          <div class="col-md-4">
            <div class="form-group" id="invoice_grp" style="display:inline;">
            <label class="control-label"><small><?=get_lang('Sdaet');?>:</small></label>
          </div>
          <div id="invoice_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
          <select data-placeholder="Выберите кто сдает" class='my_select select' name="userid" id="userid">
           <option value=""></option>
         <?php
         $morgs=GetArrayUsers();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
             echo "<option value=$nid>$nm</option>";
         };
         ?>
          </select>
        </div>
          </div>
          <div class="col-md-4">
          <label class="control-label"><small><?=get_lang('Prinimaet');?>:</small></label>
          <select data-placeholder="Выберите кто принимает" class='my_select select' name="userid2" id="userid2">
           <option value=""></option>
         <?php
         $morgs=GetArrayUsers();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
             echo "<option value=$nid>$nm</option>";
         };
         ?>
          </select>
</div>
<div class="col-md-4">
  <label class="control-label"><small><?=get_lang('Poluchaet');?>:</small></label>
          <select data-placeholder="Выберите кто получает" class='my_select select' name="userid3" id="userid3">
           <option value=""></option>
         <?php
         $morgs=GetArrayUsers();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
             echo "<option value=$nid>$nm</option>";
         };
         ?>
          </select>
</div>
<div class="col-md-4">
  <button type="submit" id="invoice_table" class="btn btn-primary allwidht" name="invoice_table" style="margin-top: 10px;"><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;<?=get_lang('Sfrom');?></button>
</div>
</div>
</div>
        </div>
   <div class="panel-body">
     <div id="invoice_show">
     <table id="invoice" class="table table-striped table-bordered compact" cellspacing="0" width="100%">
         <thead>
           <tr>
             <th class="center_header"><?=get_lang('Id')?></th>
             <th class="center_header"><?=get_lang('Places')?></th>
             <th class="center_header"><?=get_lang('Namenome')?></th>
             <th class="center_header"><?=get_lang('Group')?></th>
             <th class="center_header"><?=get_lang('Sernum')?></th>
             <th class="center_header"><?=get_lang('Shtrih')?></th>
             <th class="center_header"><?=get_lang('Oldshtrih')?></th>
             <th class="center_header"><?=get_lang('Orgname')?></th>
             <th class="center_header"><?=get_lang('Matname')?></th>
             <th class="center_header"><?=get_lang('Spisan')?></th>
             <th class="center_header"><?=get_lang('Os')?></th>
             <th class="center_header"><?=get_lang('Buhname')?></th>
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
