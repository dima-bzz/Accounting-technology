<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('1-5', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-list-alt"></i>&nbsp;<?=get_lang('Menu_license');?></h3>
            </div>
   </div>
    </div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle"></i>&nbsp;<?=get_lang('License_title');?>

    </div>
    <div class="panel-body">
      <table id="table_license" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th rowspan="2" class="center_header">Группирование</th>
              <th rowspan="2" class="center_header"><?=get_lang('Id')?></th>
              <th rowspan="2" class="center_header">Пользователь</th>
              <th rowspan="2" class="center_header"><?=get_lang('Orgname')?></th>
              <th rowspan="2" class="center_header">Устройство</th>
              <th rowspan="2" class="center_header">Операционная система</th>
              <th rowspan="2" class="center_header">Офис</th>
              <th colspan="3" class="center_header">Антивирус</th>
              <th rowspan="2" class="center_header">Visio</th>
              <th rowspan="2" class="center_header">Adobe Finereader</th>
              <th rowspan="2" class="center_header">Lingvo</th>
              <th rowspan="2" class="center_header">Winrar</th>
              <th rowspan="2" class="center_header">Visual Studio</th>
              <th rowspan="2" class="center_header">Комментарий</th>
            </tr>
            <tr>
              <th class="center_header">Чей установлен</th>
              <th class="center_header">Наименование</th>
              <th class="center_header">Дата окончания</th>
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
