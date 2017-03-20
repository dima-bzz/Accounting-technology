<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-list-ol"></i>&nbsp;<?=get_lang('Eqmat');?></h3>
            </div>
   </div>
    </div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle"></i>&nbsp;<?=get_lang('Eq_mat_title');?>

    </div>
    <div class="panel-body">
      <table id="eq_mat" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="center_table"><?=get_lang('Id')?></th>
              <th class="center_table"><?=get_lang('Places')?></th>
              <th class="center_table"><?=get_lang('Namenome')?></th>
              <th class="center_table"><?=get_lang('Group')?></th>
              <th class="center_table"><?=get_lang('Sernum')?></th>
              <th class="center_table"><?=get_lang('Shtrih')?></th>
              <th class="center_table"><?=get_lang('Orgname')?></th>
              <th class="center_table"><?=get_lang('Matname')?></th>
              <th class="center_table"><?=get_lang('Os')?></th>
              <th class="center_table"><?=get_lang('Spisan')?></th>
              <th class="center_table"><?=get_lang('Buhname')?></th>
            </tr>
          </thead>
      </table>
    </div>
  </div>
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-random"></i>&nbsp;<?=get_lang('Equipment_move');?>

    </div>
  <div class="panel-body">
    <table id="equipment_move_show" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th rowspan="2" class="center_header"><?=get_lang('Id')?></th>
            <th rowspan="2" class="center_header"><?=get_lang('Date')?></th>
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
</div>
<?php
include("footer.php");
}
else {
    include 'auth.php';
}
 ?>
