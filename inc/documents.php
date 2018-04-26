<?php
if(!isset($_SESSION))
{
        session_start();
}
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_documents');?></h3>
            </div>
   </div>
    </div>
 <div class="row">
 <div class="panel panel-default">
 <div class="panel-heading">
   <i class="fa fa-file" aria-hidden="true"></i>&nbsp;<?=get_lang('Files_title');?>
 </div>
 <div class="panel-body">
   <input type="file" id="file_documents">
   <table id="table_documents" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
       <thead>
         <tr>
           <th class="center_header"><?=get_lang('Id')?></th>
           <th class="center_header"><?=get_lang('Name_file')?></th>
         </tr>
       </thead>
   </table>
   <input type="hidden" id="file_size" value="<?=$CONF['file_size']?>">
 </div>
</div>
 </div>
</div>
</div>
 </div>
 </div>
<?php
include("footer.php");
?>
<script>
var file_types = ['<?=str_replace(",", "','", get_conf_param('file_types'))?>'];
var permit_users_documents = ['<?=str_replace(",", "','", get_conf_param('permit_users_documents'))?>'];
</script>
<?php
}
else {
    include 'auth.php';
}
 ?>
