<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('1-6', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-table" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_equipment');?></h3>
            </div>
   </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?=get_lang('Equipment_title');?>

      	</div>
      <div class="panel-body">
        <table id="equipment_table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="center_header"><?=get_lang('Active')?></th>
              <th class="center_header"><?=get_lang('Id')?></th>
              <th class="center_header"><?=get_lang('Places')?></th>
              <th class="center_header"><?=get_lang('Namenome')?></th>
              <th class="center_header"><?=get_lang('Group')?></th>
              <th class="center_header"><?=get_lang('Vendor')?></th>
              <th class="center_header"><?=get_lang('Buhname')?></th>
              <th class="center_header"><?=get_lang('Sernum')?></th>
              <th class="center_header"><?=get_lang('Shtrih')?></th>
              <th class="center_header"><?=get_lang('Orgname')?></th>
              <th class="center_header"><?=get_lang('Matname')?></th>
              <th class="center_header"><?=get_lang('Dateprihod')?></th>
              <th class="center_header"><?=get_lang('Comment')?></th>
              <th class="center_header"><?=get_lang('Oldshtrih')?></th>
              <th class="center_header"><?=get_lang('Cost')?></th>
              <th class="center_header"><?=get_lang('Currentcost')?></th>
              <th class="center_header"><?=get_lang('Os')?></th>
              <th class="center_header"><?=get_lang('Spisan')?></th>
              <th class="center_header"><?=get_lang('Bum')?></th>
              <th class="center_header"><?=get_lang('Repair_column')?></th>
              <th class="center_header"><?=get_lang('Dtendgar')?></th>
              <th class="center_header"><?=get_lang('Kntname')?></th>
              <th class="center_header"><?=get_lang('Invoice')?></th>
            </tr>
          </thead>
        </table>
            <div id="photoid" class="center_all"></div>
      </div>
    </div>
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-list" aria-hidden="true"></i>&nbsp;<?=get_lang('Equipment_param');?>

    </div>
    <div class="panel-body">
    <table id="equipment_param" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th class="center_header"><?=get_lang('Id')?></th>
            <th class="center_header"><?=get_lang('Namenome')?></th>
            <th class="center_header"><?=get_lang('Param')?></th>
            <th class="center_header"><?=get_lang('Comment')?></th>
            <th class="center_header"><?=get_lang('Action')?></th>
          </tr>
        </thead>
    </table>
    </div>
    </div>

    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-random" aria-hidden="true"></i>&nbsp;<?=get_lang('Equipment_move');?>

    </div>
  <div class="panel-body">
    <table id="equipment_move" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th rowspan="2" class="center_header"><?=get_lang('Id')?></th>
            <th rowspan="2" class="center_header"><?=get_lang('Date')?></th>
            <th colspan="5" class="center_header"><?=get_lang('From')?></th>
            <th colspan="3" class="center_header"><?=get_lang('To')?></th>
            <th rowspan="2" class="center_header"><?=get_lang('Comment')?></th>
            <th rowspan="2" class="center_header"><?=get_lang('Action')?></th>

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

<div class="panel panel-default">
<div class="panel-heading">
  <i class="fa fa-gavel" aria-hidden="true"></i>&nbsp;<?=get_lang('Equipment_repair');?>

</div>
<div class="panel-body">
<table id="equipment_repair" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th class="center_header"><?=get_lang('Id')?></th>
        <th class="center_header"><?=get_lang('Date_on')?></th>
        <th class="center_header"><?=get_lang('Date_off')?></th>
        <th class="center_header"><?=get_lang('Orgname')?></th>
        <th class="center_header"><?=get_lang('Cost')?></th>
        <th class="center_header"><?=get_lang('Comment')?></th>
        <th class="center_header"><?=get_lang('Status')?></th>
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
?>
<script>
var file_types_img = ['<?=str_replace(",", "','", get_conf_param('file_types_img'))?>'];
</script>
<?php
}
else {
    include 'auth.php';
}
 ?>
