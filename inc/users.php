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
            <div class="col-md-6"> <h3><i class="fa fa-user-plus"></i>&nbsp;<?=get_lang('Menu_users');?></h3>
            </div>
   </div>
    </div>
 <div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle"></i>&nbsp;<?=get_lang('Users_title');?>
    </div>
    <div class="panel-body">
      <table id="table_users" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="center_header"><?=get_lang('Active')?></th>
              <th class="center_header"><?=get_lang('Id')?></th>
              <th class="center_header"><?=get_lang('Login')?></th>
              <th class="center_header"><?=get_lang('Fio')?></th>
              <th class="center_header"><?=get_lang('Pass')?></th>
              <th class="center_header"><?=get_lang('User_name')?></th>
              <th class="center_header"><?=get_lang('Default_email')?></th>
              <th class="center_header"><?=get_lang('Priv')?></th>
              <th class="center_header"><?=get_lang('Access')?></th>
              <th class="center_header"><?=get_lang('Lang')?></th>
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
include("footer.php");
?>
<script>
var file_types_img = ['<?=str_replace(",", "','", get_conf_param('file_types_img'))?>'];
</script>
<?php
}
}
else {
    include 'auth.php';
}
 ?>
