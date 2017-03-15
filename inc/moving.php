<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('1-3', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-history"></i>&nbsp;<?=get_lang('Menu_history_moving');?></h3>
            </div>
   </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-info-circle"></i>&nbsp;<?=get_lang('Moving_history_title');?>

        </div>
   <div class="panel-body">
     <table id="equipment_move_show_all" class="table table-striped table-bordered compact" cellspacing="0" width="100%">
         <thead>
           <tr>
             <th rowspan="2" class="center_header"><?=get_lang('Id')?></th>
             <th rowspan="2" class="center_header"><?=get_lang('Date')?></th>
             <th rowspan="2" class="center_header"><?=get_lang('TMC')?></th>
             <th colspan="5" class="center_header"><?=get_lang('From')?></th>
             <th colspan="3" class="center_header"><?=get_lang('To')?></th>
             <th rowspan="2" class="center_header"><?=get_lang('Comment')?></th>
           </tr>
           <tr>
             <th class="center_header"><?=get_lang('Orgname')?></th>
             <th class="center_header"><?=get_lang('Places')?></th>
             <th class="center_header"><?=get_lang('Matname')?></th>
             <th class="center_header"><?=get_lang('Kntname')?></th>
             <th class="center_header"><?=get_lang('Invoice')?></th>
             <th class="center_header"><?=get_lang('Orgname')?></th>
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
