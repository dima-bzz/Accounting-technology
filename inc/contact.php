<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-child"></i>&nbsp;<?=get_lang('Contact');?></h3>
            </div>
   </div>
    </div>
 <div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle"></i>&nbsp;<?=get_lang('Contact_title');?>

    </div>
    <div class="panel-body">
      <table id="table_contact" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="center_header"><?=get_lang('Id')?></th>
              <th class="center_header"><?=get_lang('Places')?></th>
              <th class="center_header"><?=get_lang('Fio')?></th>
              <th class="center_header"><?=get_lang('Work_tel')?></th>
              <th class="center_header"><?=get_lang('Mob_tel')?></th>
              <th class="center_header">E-mail</th>
              <th class="center_header"><?=get_lang('Happy')?></th>
            </tr>
          </thead>
      </table>
    </div>
 </div>
 </div>
 </div>
 </div>
<?php
include("footer.php");
?>
<script>
var permit_users_cont = ['<?=str_replace(",", "','", get_conf_param('permit_users_cont'))?>'];
</script>
<?php
}
else {
    include 'auth.php';
}
 ?>
