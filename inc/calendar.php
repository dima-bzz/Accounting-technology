<?php
session_start();
setcookie ('date',date('Y-m-d'));
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('3-7', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_calendar');?></h3>
            </div>
   </div>
    </div>
 <div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?=get_lang('Calendar_title');?>

    </div>
    <div class="panel-body">

<div id='calendar'></div>
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
