<?php
if(!isset($_SESSION))
{
        session_start();
}
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
if (validate_priv($_SESSION['dilema_user_id']) == 1) {
include("header.php");
include("menus.php");
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-folder-open" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_group_nome');?></h3>
            </div>
   </div>
    </div>
 <div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?=get_lang('Group_title');?>

    </div>
    <div class="panel-body">
      <table id="table_group_nome" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="center_header"><?=get_lang('Active')?></th>
              <th class="center_header"><?=get_lang('Id')?></th>
              <th class="center_header"><?=get_lang('Name')?></th>
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
include("footer.php");
}
}
else {
    include 'auth.php';
}
 ?>
