<?php
if(!isset($_SESSION))
{
        session_start();
}
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('1-5', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_license');?></h3>
            </div>
   </div>
    </div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?=get_lang('License_title');?>

    </div>
    <div class="panel-body">
      <table id="table_license" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th rowspan="2" class="center_header header_nowrap">Группирование</th>
              <th rowspan="2" class="center_header header_nowrap"><?=get_lang('Id')?></th>
              <th rowspan="2" class="center_header header_nowrap">Пользователь</th>
              <th rowspan="2" class="center_header header_nowrap"><?=get_lang('Orgname')?></th>
              <th rowspan="2" class="center_header header_nowrap">Устройство</th>
              <th rowspan="2" class="center_header header_nowrap">Операционная система</th>
              <th rowspan="2" class="center_header header_nowrap">Офис</th>
              <th colspan="3" class="center_header header_nowrap">Антивирус</th>
              <th rowspan="2" class="center_header header_nowrap">Программное обеспечение</th>
              <th rowspan="2" class="center_header header_nowrap">Комментарий</th>
            </tr>
            <tr>
              <th class="center_header header_nowrap">Чей установлен</th>
              <th class="center_header header_nowrap">Наименование</th>
              <th class="center_header header_nowrap">Дата окончания</th>
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
