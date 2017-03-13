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
            <div class="col-md-6"> <h3><i class="fa fa-users"></i>&nbsp;<?=get_lang('Menu_places');?></h3>
            </div>
   </div>
    </div>
 <div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle"></i>&nbsp;<?=get_lang('Places_title');?>

    </div>
    <div class="panel-body">
      <table id="table_places" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="center_header"><?=get_lang('Active')?></th>
              <th class="center_header"><?=get_lang('Id')?></th>
              <th class="center_header"><?=get_lang('Places')?></th>
              <th class="center_header"><?=get_lang('Comment')?></th>
              <th class="center_header"><?=get_lang('Action')?></th>
            </tr>
          </thead>
      </table>
    </div>
 </div>
 <div class="panel panel-default">
 <div class="panel-heading">
   <i class="fa fa-male"></i>&nbsp;<?=get_lang('Places_sub_title');?>

 </div>
 <div class="panel-body">
   <table id="table_places_sub" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
       <thead>
         <tr>
           <th class="center_header"><?=get_lang('Id')?></th>
           <th class="center_header"><?=get_lang('Fio')?></th>
           <th class="center_header"><?=get_lang('Login')?></th>
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
