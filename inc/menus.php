<?php
function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    $file = $_SERVER['REQUEST_URI'];
    $file = explode("?", basename($file));
    $current_file_name=$file[0];

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}
$ap=get_count_delete();
$permit_menu = validate_menu($_SESSION['dilema_user_id']);
$permit = explode(",",$permit_menu);
if (validate_priv($_SESSION['dilema_user_id']) == 1){
  $admin = true;
}
// echo sizeof(preg_grep("/^(1+)?\-\d+$/", $permit)) || ($admin == true));
?>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=$CONF['hostname']?>index.php"><img src="<?=$CONF['hostname']?>images/logo.png"> <?=$CONF['name_of_firm']?></a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav nav-pills">

      <?php
      // if (validate_priv($_SESSION['dilema_user_id']) != 0) {
      // if ((in_array('1-',$permit)) || ($admin == true)){
      if ((sizeof(preg_grep("/^(1+)?\-\d+$/", $permit))!= 0) || ($admin == true)){
       ?>
      <li class="dropdown">
           <a href="#"  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tags fa-fw"></i>&nbsp;<?=get_lang('Menu_journal');?> <span class="caret"></span></a>
           <ul class="dropdown-menu">
             <?php
             if ((in_array('1-1',$permit)) || ($admin == true)){
              ?>
             <li <?=echoActiveClassIfRequestMatches("report")?>><a href="<?=$CONF['hostname']?>report"><i class="fa fa-binoculars fa-fw"></i>&nbsp;<?=get_lang('Menu_reports');?></a></li>
             <?php
              }
              if ((in_array('1-2',$permit)) || ($admin == true)){
              ?>
             <li <?=echoActiveClassIfRequestMatches("invoice")?>><a href="<?=$CONF['hostname']?>invoice"><i class="fa fa-paperclip fa-fw"></i>&nbsp;<?=get_lang('Menu_invoice');?></a></li>
             <?php
              }
              if ((in_array('1-3',$permit)) || ($admin == true)){
              ?>
             <li <?=echoActiveClassIfRequestMatches("moving")?>><a href="<?=$CONF['hostname']?>moving"><i class="fa fa-history fa-fw"></i>&nbsp;<?=get_lang('Menu_history_moving');?></a></li>
             <li role="separator" class="divider"></li>
             <?php
              }
              if ((in_array('1-4',$permit)) || ($admin == true)){
              ?>
             <li <?=echoActiveClassIfRequestMatches("cartridge")?>><a href="<?=$CONF['hostname']?>cartridge"><i class="fa fa-hourglass-half fa-fw"></i>&nbsp;<?=get_lang('Menu_cartridge');?></a></li>
             <?php
              }
              if ((in_array('1-5',$permit)) || ($admin == true)){
            //  if ((validate_priv($_SESSION['dilema_user_id']) == 1) || ($priv_license == 'yes')) {
              ?>
             <li <?=echoActiveClassIfRequestMatches("license")?>><a href="<?=$CONF['hostname']?>license"><i class="fa fa-anchor fa-fw"></i>&nbsp;<?=get_lang('Menu_license');?></a></li>
             <?php
              }
            //  if (validate_priv($_SESSION['dilema_user_id']) == 1) {
              if ((in_array('1-6',$permit)) || ($admin == true)){
              ?>
             <li <?=echoActiveClassIfRequestMatches("equipment")?>><a href="<?=$CONF['hostname']?>equipment"><i class="fa fa-table fa-fw"></i>&nbsp;<?=get_lang('Menu_equipment');?></a></li>
             <?php
              }
              ?>

           </ul>
         </li>

         <?php
       }
        //  if (validate_priv($_SESSION['dilema_user_id']) != 0) {
        // if ((in_array('',$permit)) || ($admin == true)){
        if ((sizeof(preg_grep("/^(2+)?\-\d+$/", $permit))!= 0) || ($admin == true)){
          ?>
         <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shield fa-fw"></i>&nbsp;<?=get_lang('Menu_instrument');?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php
                // if (validate_priv($_SESSION['dilema_user_id']) == 1) {
                if ((in_array('2-1',$permit)) || ($admin == true)){
                 ?>
                <li <?=echoActiveClassIfRequestMatches("ping")?>><a href="<?=$CONF['hostname']?>ping"><i class="fa fa-spinner fa-spin fa-fw"></i>&nbsp;<?=get_lang('Menu_ping');?></a></li>
                <?php
              }
              if ((in_array('2-2',$permit)) || ($admin == true)){
                 ?>
                <li <?=echoActiveClassIfRequestMatches("print")?>><a href="<?=$CONF['hostname']?>print"><i class="fa fa-info fa-fw"></i>&nbsp;<?=get_lang('Menu_printer');?></a></li>
                <?php
              }
                 ?>


              </ul>
            </li>
            <?php
          }
          if ((sizeof(preg_grep("/^(3+)?\-\d+$/", $permit))!= 0) || ($admin == true)){
              ?>
            <li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book fa-fw"></i>&nbsp;<?=get_lang('Menu_sprav');?> <span class="caret"></span></a>
                 <ul class="dropdown-menu">
                   <?php
                   if ((in_array('3-1',$permit)) || ($admin == true)){
                    ?>
                   <li <?=echoActiveClassIfRequestMatches("news")?>><a href="<?=$CONF['hostname']?>news"><i class="fa fa-newspaper-o fa-fw"></i>&nbsp;<?=get_lang('Menu_news');?></a></li>
                   <li role="separator" class="divider"></li>
                   <?php
                    }
                    if ((in_array('3-2',$permit)) || ($admin == true)){
                   ?>
                   <li <?=echoActiveClassIfRequestMatches("eq_list")?>><a href="<?=$CONF['hostname']?>eq_list"><i class="fa fa-list-alt fa-fw"></i>&nbsp;<?=get_lang('Menu_eqlist');?></a></li>
                   <li role="separator" class="divider"></li>
                   <?php
                    }
                    if ((in_array('3-3',$permit)) || ($admin == true)){
                   ?>
                   <li <?=echoActiveClassIfRequestMatches("requisites")?>><a href="<?=$CONF['hostname']?>requisites"><i class="fa fa-building fa-fw"></i>&nbsp;<?=get_lang('Menu_requisites');?></a></li>
                   <?php
                    }
                    if ((in_array('3-4',$permit)) || ($admin == true)){
                   ?>
                   <li <?=echoActiveClassIfRequestMatches("knt")?>><a href="<?=$CONF['hostname']?>knt"><i class="fa fa-university fa-fw"></i>&nbsp;<?=get_lang('Menu_knt');?></a></li>
                   <?php
                    }
                    if ((in_array('3-5',$permit)) || ($admin == true)){
                   ?>
                   <li <?=echoActiveClassIfRequestMatches("documents")?>><a href="<?=$CONF['hostname']?>documents"><i class="fa fa-file-text fa-fw"></i>&nbsp;<?=get_lang('Menu_documents');?></a></li>
                   <li role="separator" class="divider"></li>
                   <?php
                    }
                    if ((in_array('3-6',$permit)) || ($admin == true)){
                   ?>
                   <li <?=echoActiveClassIfRequestMatches("contact")?>><a href="<?=$CONF['hostname']?>contact"><i class="fa fa-child fa-fw"></i>&nbsp;<?=get_lang('Menu_contact');?></a></li>
                   <?php
                    }
                    if ((in_array('3-7',$permit)) || ($admin == true)){
                   ?>
                   <li <?=echoActiveClassIfRequestMatches("calendar")?>><a href="<?=$CONF['hostname']?>calendar"><i class="fa fa-calendar fa-fw"></i>&nbsp;<?=get_lang('Menu_calendar');?></a></li>
                   <?php
                  }
                    ?>
                 </ul>
               </li>
               <?php
             }

if ($admin == true) {
 ?>
      <li class="dropdown">
           <a href="#" class="dropdown-toggle" id="admin" role="menu" data-toggle="dropdown"><i class="fa fa-wrench fa-fw"></i>&nbsp;<?=get_lang('Menu_admin');?> <span class="badge badge-danger" id="ap"><?=$ap;?></span> <span class="caret"></span></a>
           <ul class="dropdown-menu">
             <li <?=echoActiveClassIfRequestMatches("perf")?>><a href="<?=$CONF['hostname']?>perf"><i class="fa fa-cog fa-fw"></i>&nbsp;<?=get_lang('Menu_conf');?></a></li>
             <li role="separator" class="divider"></li>
             <li <?=echoActiveClassIfRequestMatches("org")?>><a href="<?=$CONF['hostname']?>org"><i class="fa fa-money fa-fw"></i>&nbsp;<?=get_lang('Menu_org');?></a></li>
             <li <?=echoActiveClassIfRequestMatches("places")?>><a href="<?=$CONF['hostname']?>places"><i class="fa fa-users fa-fw"></i>&nbsp;<?=get_lang('Menu_places');?></a></li>
             <li <?=echoActiveClassIfRequestMatches("users")?>><a href="<?=$CONF['hostname']?>users"><i class="fa fa-user-plus fa-fw"></i>&nbsp;<?=get_lang('Menu_users');?></a></li>
             <li role="separator" class="divider"></li>
             <li <?=echoActiveClassIfRequestMatches("vendors")?>><a href="<?=$CONF['hostname']?>vendors"><i class="fa fa-apple fa-fw"></i>&nbsp;<?=get_lang('Menu_vendor');?></a></li>
             <li <?=echoActiveClassIfRequestMatches("group")?>><a href="<?=$CONF['hostname']?>group"><i class="fa fa-folder-open fa-fw"></i>&nbsp;<?=get_lang('Menu_group_nome');?></a></li>
             <li <?=echoActiveClassIfRequestMatches("nome")?>><a href="<?=$CONF['hostname']?>nome"><i class="fa fa-server fa-fw"></i>&nbsp;<?=get_lang('Menu_nome');?></a></li>
             <li role="separator" class="divider"></li>
             <li <?=echoActiveClassIfRequestMatches("delete")?>><a href="<?=$CONF['hostname']?>delete"><i class="fa fa-trash fa-fw"></i>&nbsp;<?=get_lang('Menu_delete');?> <span class="badge badge-danger" id="ap2"><?=$ap;?></span> </a></li>
           </ul>
         </li>
         <?php
}
          ?>
       </ul>
         <ul class="nav navbar-nav navbar-right">
           <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i>&nbsp;<?=nameshort(name_of_user_ret($_SESSION['dilema_user_id']));?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li align="center"><img src="images/avatar/<?= get_avatar();?>" class="img-circle img-responsive"></li>
              <br>
              <li class="divider"></li>
              <li <?=echoActiveClassIfRequestMatches("profile")?>><a href="<?=$CONF['hostname']?>profile"><i class="fa fa-cogs fa-fw"></i>&nbsp;<?=get_lang('Profile');?></a></li>
              <li><a href="<?=$CONF['hostname']?>index.php?logout"><i class="fa fa-sign-out fa-fw"></i>&nbsp;<?=get_lang('Logout');?></a></li>
          </ul>
        </li>
    </ul>
  </div>
  </div>
</nav>