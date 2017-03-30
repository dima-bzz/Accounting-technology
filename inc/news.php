<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
  include("header.php");
  include("menus.php");
  if ((in_array('3-1', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){

if (isset($_GET['h'])) {

$h=($_GET['h']);


    $stmt = $dbConnection->prepare('select id, user_init_id, dt, title, message, hashname
			    from news where hashname=:h');
    $stmt->execute(array(':h' => $h));
    $news = $stmt->fetch(PDO::FETCH_ASSOC);


    ?>
    <div class="container-fluid">
    <div class="page-header" style="margin-top: -15px;">
    <div class="row">
    <div class="col-md-10">
<h3><i class="fa fa-globe" aria-hidden="true"></i> <?=get_lang('Menu_news');?></h3>
    </div>

    </div>
     </div>
     <div class="row" id="content_notes" style="padding-bottom: 25px;">
<div class="col-md-1">
<a id="go_back" class="btn btn-primary btn-sm"><i class="fa fa-reply" aria-hidden="true"></i> <?=get_lang('News_back');?></a>
<div><br></div>
</div>
<div class="col-md-11" id="">
<div class="panel panel-default">
  <div class="panel-body">
    <h3 style=" margin-top: 0px; "><?=make_html($news['title'])?></h3>
    <p><?=($news['message'])?></p>
    <hr>
    <p class="text-right"><small class="text-muted"><?=get_lang('News_pub');?>: <?=nameshort(name_of_user_ret($news['user_init_id']));?></small><br><small class="text-muted"><?=get_lang('News_date');?>: <?=$news['dt'];?></small>
    </p>
  </div>
</div>
</div>
</div>
 </div>
    <?php
}
else if (!isset($_GET['h'])) {
  $user_id=$_SESSION['dilema_user_id'];
  $priv = validate_priv($user_id);
  $permit_users_news = get_conf_param('permit_users_news');
  $permit = explode(",",$permit_users_news);
  foreach ($permit as $permit_id) {
  if (($user_id == $permit_id) || ($priv == 1) ){
    $priv_h="yes";
  }
  }
?>

<div class="container-fluid">
    <div class="page-header" style="margin-top: -15px;">
    <div class="row">
    <div class="col-md-3">
<h3><i class="fa fa-globe" aria-hidden="true"></i> <?=get_lang('Menu_news');?></h3>
    </div>
    <div class="col-md-3" style="padding-top: 25px; float: right;">
      <?php
      if ($priv_h == "yes"){
       ?>
    <button id="create_new_news" type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-file-o" aria-hidden="true"></i> <?=get_lang('News_create');?></button>
    <?php
}
    ?>
    </div>
    </div>
     </div>

     <div class="row" id="content_news" style="padding-bottom: 25px;">

 <div class="col-md-3">
 <div class="alert alert-info" role="alert">
 <small>
 <i class="fa fa-info-circle" aria-hidden="true"></i>

<?=get_lang('News_info');?>
 </small>
 </div>
 </div>
 <div id="spinner" class="col-md-9">
     <center>
       <h3>
         <i class="fa fa-spinner fa-spin"></i> <?= get_lang('News_loading'); ?> ...
       </h3>
     </center>
 </div>
<div class="col-md-9" id="news_content">

</div>
<div class="col-md-12" id="page_number">
<?php
$perpage='5';
$res = $dbConnection->prepare("SELECT count(*) from news ");
$res->execute();
$count = $res->fetch(PDO::FETCH_NUM);
$count=$count[0];
if ($count <> 0) {
    $pages_count = ceil($count / $perpage);
}
else {
    $pages_count = 0;
}
if ($pages_count == 0) {
?>
<input type="hidden" id="curent_page" value="null">
<input type="hidden" id="total_pages" value="">
<?php
}
else if ($pages_count <> 0) {
 ?>
<input type="hidden" id="curent_page" value="1">
<input type="hidden" id="cur_page" value="1">
<input type="hidden" id="total_pages" value="<?= $pages_count ?>">
<?php
}
 ?>
<div class="text-center">

<ul id="news_p" class="pagination pagination-sm"></ul>
</div>
</div>
</div>
 </div>
 <?php
 }
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