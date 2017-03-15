<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('1-4', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-hourglass-half"></i>&nbsp;<?=get_lang('Menu_cartridge');?></h3>
            </div>
   </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-info-circle"></i>&nbsp;<?=get_lang('Cartridge_title');?>
        </div>
   <div class="panel-body">
     <table id="table_cartridge" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
         <thead>
           <tr>
             <th class="center_header"><?=get_lang('Active')?></th>
             <th class="center_header"><?=get_lang('Id')?></th>
             <th class="center_header"><?=get_lang('Namenome')?></th>
             <th class="center_header"><?=get_lang('Namek')?></th>
             <th class="center_header"><?=get_lang('Places')?></th>
             <th class="center_header"><?=get_lang('Orgname')?></th>
             <th class="center_header"><?=get_lang('Matname')?></th>
             <th class="center_header"><?=get_lang('Coll')?></th>
             <th class="center_header"><?=get_lang('New')?></th>
             <th class="center_header"><?=get_lang('Zapr')?></th>
             <th class="center_header"><?=get_lang('Comment')?></th>
             <th class="center_header"><?=get_lang('Action')?></th>
           </tr>
         </thead>
     </table>
   </div>
</div>

<div class="panel panel-default">
<div class="panel-heading">
  <i class="fa fa-database"></i>&nbsp;<?=get_lang('Cartridge_uchet_title');?>

</div>
<div class="panel-body">
<table id="table_cartridge_uchet" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
 <thead>
   <tr>
     <th class="center_header"><?=get_lang('Id')?></th>
     <th class="center_header"><?=get_lang('Date')?></th>
     <th class="center_header"><?=get_lang('Who_user')?></th>
     <th class="center_header"><?=get_lang('Coll')?></th>
     <th class="center_header"><?=get_lang('Comment')?></th>
     <th class="center_header"><?=get_lang('Action')?></th>
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
