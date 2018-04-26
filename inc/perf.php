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
 <style>
 .alert-info hr{
   border-top-color: #fff !important;
 }
 .chosen-container{
  width: 100% !important;
  }
 </style>
<div class="container">
<div class="page-header" style="margin-top: -15px;">
<div class="row">
         <div class="col-md-6"> <h3><i class="fa fa-cog" aria-hidden="true"></i>  <?=get_lang('CONF_title');?></h3></div><div class="col-md-6">

</div>

</div>
 </div>


<div class="row" >
<div class="col-md-3">
      <div class="alert alert-info" role="alert">
      <small>
      <i class="fa fa-info-circle" aria-hidden="true"></i>

<?=get_lang('CONF_info');?>
<hr>
<?=get_lang('CONF_version')." ".get_version()?>
<br>
<?=get_lang('CONF_version_1');?>
</small>
<button class="btn btn-default btn-block" style="margin-top: 20px;" id="conf_check_update"><?=get_lang('CONF_check_update');?></button>
<div id="check_update"></div>
<hr>
<button class="btn btn-primary btn-block" id="conf_system_update" data-toggle="tooltip" data-placement="left" title="<?=get_lang('CONF_system_update_title');?>"><?=get_lang('CONF_system_update');?></button>
      <div id="up_success"></div>
      </div>

      </div>

      <div class="col-md-9" id="content_info">
        <div  class="tab_conf">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#conf_main" data-toggle="tab"><i class="fa fa-cog"></i> <?=get_lang('CONF_mains');?></a></li>
                <li><a href="#conf_permit" data-toggle="tab"><i class="fa fa-unlock"></i> <?=get_lang('CONF_user_permit');?></a></li>
                <li><a href="#conf_group" data-toggle="tab"><i class="fa fa-list"></i> <?=get_lang('CONF_group');?></a></li>
                <li><a href="#conf_mail" data-toggle="tab"><i class="fa fa-send"></i> <?=get_lang('CONF_mail_name');?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="conf_main">
                  <div class="col-md-12 box-body_conf">
                    <form class="form-horizontal" role="form">
                    <div class="form-group">
                    <label for="name_of_firm" class="col-sm-4 control-label"><small><?=get_lang('CONF_name');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="name_of_firm" placeholder="<?=get_lang('CONF_name');?>" value="<?=get_conf_param('name_of_firm');?>">
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="mail" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="mail" placeholder="<?=get_lang('CONF_mail');?>" value="<?=get_conf_param('mail');?>">
                    </div>
                  </div>



                  <div class="form-group">
                    <label for="title_header" class="col-sm-4 control-label"><small><?=get_lang('CONF_title_org');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="title_header" placeholder="<?=get_lang('CONF_title_org');?>" value="<?=get_conf_param('title_header');?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="hostname" class="col-sm-4 control-label"><small><?=get_lang('CONF_url');?></small></label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <span class="input-group-addon">http://</span>
                      <input type="text" class="form-control input-sm" id="hostname" placeholder="<?php
                      $pos = strrpos($_SERVER['REQUEST_URI'], '/');
                      echo $_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'], 0, $pos + 1);?>" value="<?=preg_replace("/http:\/\//","",get_conf_param('hostname')); ?>">
                    </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="hostname" class="col-sm-4 control-label"><small><?=get_lang('CONF_home_text');?></small></label>
                    <div class="col-sm-8">
                      <textarea type="text" class="form-control input-sm" rows="3" id="home_text" placeholder="<?=get_lang('CONF_title_home_text');?>"><?=get_conf_param('home_text'); ?></textarea>
                    </div>
                  </div>

                      <div class="form-group">
                    <label for="first_login" class="col-sm-4 control-label"><small><?=get_lang('CONF_f_login');?></small></label>
                    <div class="col-sm-8">
                  <select class="my_select2 select" id="first_login">
                  <option value="true" <?php if (get_conf_param('first_login') == "true") {echo "selected";} ?>><?=get_lang('CONF_true');?></option>
                  <option value="false" <?php if (get_conf_param('first_login') == "false") {echo "selected";} ?>><?=get_lang('CONF_false');?></option>
                </select>
                <p class="help-block"><small>
                <?=get_lang('CONF_f_login_info');?>
                </small></p>
                 </div>
                  </div>
                  <div class="form-group">
                  <label for="time_zone" class="col-sm-4 control-label"><small><?=get_lang('CONF_time_zone');?></small></label>
                  <div class="col-sm-8">
                    <?=Helper_TimeZone::getTimeZoneSelect(get_conf_param('time_zone'));?>
                  </div>
                </div>
                  <div class="form-group">
                  <label for="default_org" class="col-sm-4 control-label"><small><?=get_lang('CONF_default_org');?></small></label>
                  <div class="col-sm-8">
                    <select data-placeholder="Выберите организацию" class='my_select select'  name="default_org" id="default_org">
                     <option value=""></option>
                    <?php
                    $morgs=GetArrayOrg();
                    for ($i = 0; $i < count($morgs); $i++) {
                        $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                        if ($nid==get_conf_param('default_org')){$sl=" selected";} else {$sl="";};
                        echo "<option value=$nid $sl>$nm</option>";
                    };
                    ?>
                    </select>
                  </div>
                </div>
                  <div class="form-group">
                    <label for="file_types" class="col-sm-4 control-label"><small><?=get_lang('CONF_file_types');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="file_types" placeholder="gif,jpeg,jpg,png,doc,xls,rtf,pdf,zip,rar,bmp,docx,xlsx" value="<?= get_conf_param('file_types');?>">

                    </div>
                  </div>

                    <div class="form-group">
                    <label for="file_size" class="col-sm-4 control-label"><small><?=get_lang('CONF_file_size');?></small></label>
                    <div class="col-sm-8">
                    <div class="input-group">
                      <input type="text" class="form-control input-sm" id="file_size" placeholder="5" value="<?=round(get_conf_param('file_size')/1024/1024);?>">
                <span class="input-group-addon">Mb</span>
                    </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="file_types_img" class="col-sm-4 control-label"><small><?=get_lang('CONF_file_types_img');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="file_types_img"  placeholder="jpeg,jpg,png,bmp" value="<?= get_conf_param('file_types_img');?>">

                    </div>
                  </div>
                  <div class="col-md-offset-3 col-md-6">
                <center>
                    <button type="submit" id="conf_edit_main" class="btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> <?=get_lang('CONF_act_edit');?></button>

                </center>

                </div>

                    </form>

                  <div class="col-md-12" style="margin-top:10px;" id="conf_edit_main_res"></div>
                  </div>
                </div>
                <div class="tab-pane fade" id="conf_permit">
                  <div class="col-md-12 box-body_conf">
                    <form class="form-horizontal" role="form">
                        <div class="col-md-12" style="margin-bottom: 15px;">
                          <center>
                            <label for="permit_users" class="control-label"><?=get_lang('CONF_permit_users');?></label>
                          </center>
                          <br>
                          <p>
                            <label class="control-label">
                          <small>
                            <?=get_lang('CONF_Id_knt');?>:
                          </small>
                        </label>
                          </p>
                          <select data-placeholder="<?=get_lang('Select_users');?>" class="my_select2 select input-sm form-control" multiple id="permit_users_knt" name="permit_users_knt[]">
                        <?php
                              $us = get_conf_param('permit_users_knt');
                              $u=explode(",", $us);

                              $stmt = $dbConnection->prepare('SELECT fio as fio, id as value FROM users where on_off=:n2 and id !=:n order by fio asc');
                        $stmt->execute(array(':n'=>'0',':n2'=>'1'));
                          $res1 = $stmt->fetchAll();

                                foreach($res1 as $row) {
                                                    $row['fio']=nameshort($row['fio']);
                                                    $row['value']=(int)$row['value'];
                        $opt_sel='';
                        foreach ($u as $val) {
                        if ($val== $row['value']) {$opt_sel="selected";}
                        }
                                                    ?>
                                                    <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=nameshort($row['fio'])?></option>
                                                <?php
                                                }

                                                ?>
                            </select>
                            <p>
                              <label class="control-label">
                            <small>
                            <?=get_lang('CONF_Id_req');?>:
                          </small>
                        </label>
                          </p>
                          <select data-placeholder="<?=get_lang('Select_users');?>" class="my_select2 select" multiple id="permit_users_req" name="permit_users_req[]">
                        <?php
                              $us = get_conf_param('permit_users_req');
                              $u=explode(",", $us);

                              $stmt = $dbConnection->prepare('SELECT fio as fio, id as value FROM users where on_off=:n2 and id !=:n order by fio asc');
                        $stmt->execute(array(':n'=>'0',':n2'=>'1'));
                          $res1 = $stmt->fetchAll();

                                foreach($res1 as $row) {
                                                    $row['fio']=nameshort($row['fio']);
                                                    $row['value']=(int)$row['value'];
                        $opt_sel='';
                        foreach ($u as $val) {
                        if ($val== $row['value']) {$opt_sel="selected";}
                        }
                                                    ?>
                                                    <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=nameshort($row['fio'])?></option>
                                                <?php
                                                }

                                                ?>
                            </select>
                            <p>
                              <label class="control-label">
                            <small>
                          <?=get_lang('CONF_Id_cont');?>:
                        </small>
                      </label>
                        </p>
                        <select data-placeholder="<?=get_lang('Select_users');?>" class="my_select2 select" multiple id="permit_users_cont" name="permit_users_cont[]">
                      <?php
                            $us = get_conf_param('permit_users_cont');
                            $u=explode(",", $us);

                            $stmt = $dbConnection->prepare('SELECT fio as fio, id as value FROM users where on_off=:n2 and id !=:n order by fio asc');
                      $stmt->execute(array(':n'=>'0',':n2'=>'1'));
                        $res1 = $stmt->fetchAll();

                              foreach($res1 as $row) {
                                                  $row['fio']=nameshort($row['fio']);
                                                  $row['value']=(int)$row['value'];
                      $opt_sel='';
                      foreach ($u as $val) {
                      if ($val== $row['value']) {$opt_sel="selected";}
                      }
                                                  ?>
                                                  <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=nameshort($row['fio'])?></option>
                                              <?php
                                              }

                                              ?>
                          </select>
                          <p>
                            <label class="control-label">
                          <small>
                        <?=get_lang('CONF_Id_documents');?>:
                      </small>
                    </label>
                      </p>
                      <select data-placeholder="<?=get_lang('Select_users');?>" class="my_select2 select" multiple id="permit_users_documents" name="permit_users_documents[]">
                    <?php
                          $us = get_conf_param('permit_users_documents');
                          $u=explode(",", $us);

                          $stmt = $dbConnection->prepare('SELECT fio as fio, id as value FROM users where on_off=:n2 and id !=:n order by fio asc');
                    $stmt->execute(array(':n'=>'0',':n2'=>'1'));
                      $res1 = $stmt->fetchAll();

                            foreach($res1 as $row) {
                                                $row['fio']=nameshort($row['fio']);
                                                $row['value']=(int)$row['value'];
                    $opt_sel='';
                    foreach ($u as $val) {
                    if ($val== $row['value']) {$opt_sel="selected";}
                    }
                                                ?>
                                                <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=nameshort($row['fio'])?></option>
                                            <?php
                                            }

                                            ?>
                        </select>
                        <p>
                          <label class="control-label">
                        <small>
                      <?=get_lang('CONF_Id_news');?>:
                    </small>
                  </label>
                    </p>
                    <select data-placeholder="<?=get_lang('Select_users');?>" class="my_select2 select" multiple id="permit_users_news" name="permit_users_news[]">
                    <?php
                        $us = get_conf_param('permit_users_news');
                        $u=explode(",", $us);

                          $stmt = $dbConnection->prepare('SELECT fio as fio, id as value FROM users where on_off=:n2 and id !=:n order by fio asc');
                    $stmt->execute(array(':n'=>'0',':n2'=>'1'));
                    $res1 = $stmt->fetchAll();

                          foreach($res1 as $row) {
                                              $row['fio']=nameshort($row['fio']);
                                              $row['value']=(int)$row['value'];
                    $opt_sel='';
                    foreach ($u as $val) {
                    if ($val== $row['value']) {$opt_sel="selected";}
                    }
                                              ?>
                                              <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=nameshort($row['fio'])?></option>
                                          <?php
                                          }

                                          ?>
                      </select>
                      <p>
                        <label class="control-label">
                      <small>
                      <?=get_lang('CONF_Id_license');?>:
                    </small>
                  </label>
                    </p>
                    <select data-placeholder="<?=get_lang('Select_users');?>" class="my_select2 select" multiple id="permit_users_license" name="permit_users_license[]">
                    <?php
                        $us = get_conf_param('permit_users_license');
                        $u=explode(",", $us);

                          $stmt = $dbConnection->prepare('SELECT fio as fio, id as value FROM users where on_off=:n2 and id !=:n order by fio asc');
                    $stmt->execute(array(':n'=>'0',':n2'=>'1'));
                    $res1 = $stmt->fetchAll();

                          foreach($res1 as $row) {
                                              $row['fio']=nameshort($row['fio']);
                                              $row['value']=(int)$row['value'];
                    $opt_sel='';
                    foreach ($u as $val) {
                    if ($val== $row['value']) {$opt_sel="selected";}
                    }
                                              ?>
                                              <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=nameshort($row['fio'])?></option>
                                          <?php
                                          }

                                          ?>
                      </select>
                      <p>
                    </div>
                      <div class="col-md-offset-3 col-md-6">
                    <center>
                        <button type="submit" id="conf_edit_permit" class="btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> <?=get_lang('CONF_act_edit');?></button>

                    </center>

                    </div>
                    </form>

                    <div class="col-md-12" style="margin-top:10px;" id="conf_edit_permit_res"></div>

                  </div>
                </div>
                <div class="tab-pane fade" id="conf_group">
                  <div class="col-md-12 box-body_conf">
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                        <label for="what_cartridge" class="col-sm-4 control-label"><small><?=get_lang('CONF_cartridge');?></small></label>
                        <div class="col-sm-8">
                          <select data-placeholder="<?=get_lang('Select_group');?>" class="my_select2 select" multiple id="what_cartridge" name="what_cartridge[]">
                          <?php
                          $us = get_conf_param('what_cartridge');
                          $u=explode(",", $us);

                                $stmt = $dbConnection->prepare('SELECT name as name, id as value FROM group_nome where active =1');
                          $stmt->execute();
                          $res1 = $stmt->fetchAll();

                                foreach($res1 as $row) {
                                                    $row['name']=$row['name'];
                                                    $row['value']=(int)$row['value'];
                          $opt_sel='';
                          foreach ($u as $val) {
                          if ($val== $row['value']) {$opt_sel="selected";}
                          }
                                                    ?>
                                                    <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=$row['name']?></option>
                                                <?php
                                                }

                                                ?>
                            </select>

                        </div>
                      </div>
                      <div class="form-group">
                        <label for="what_print_test" class="col-sm-4 control-label"><small><?=get_lang('CONF_print_test');?></small></label>
                        <div class="col-sm-8">
                          <select data-placeholder="<?=get_lang('Select_group');?>" class="my_select2 select" multiple id="what_print_test" name="what_print_test[]">
                          <?php
                          $us = get_conf_param('what_print_test');
                          $u=explode(",", $us);

                                $stmt = $dbConnection->prepare('SELECT name as name, id as value FROM group_nome where active =1');
                          $stmt->execute();
                          $res1 = $stmt->fetchAll();

                                foreach($res1 as $row) {
                                                    $row['name']=$row['name'];
                                                    $row['value']=(int)$row['value'];
                          $opt_sel='';
                          foreach ($u as $val) {
                          if ($val== $row['value']) {$opt_sel="selected";}
                          }
                                                    ?>
                                                    <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=$row['name']?></option>
                                                <?php
                                                }

                                                ?>
                            </select>

                        </div>
                      </div>
                      <div class="form-group">
                        <label for="what_license" class="col-sm-4 control-label"><small><?=get_lang('CONF_license');?></small></label>
                        <div class="col-sm-8">
                          <select data-placeholder="<?=get_lang('Select_group');?>" class="my_select2 select" multiple id="what_license" name="what_license[]">
                          <?php
                          $us = get_conf_param('what_license');
                          $u=explode(",", $us);

                                $stmt = $dbConnection->prepare('SELECT name as name, id as value FROM group_nome where active =1');
                          $stmt->execute();
                          $res1 = $stmt->fetchAll();

                                foreach($res1 as $row) {
                                                    $row['name']=$row['name'];
                                                    $row['value']=(int)$row['value'];
                          $opt_sel='';
                          foreach ($u as $val) {
                          if ($val== $row['value']) {$opt_sel="selected";}
                          }
                                                    ?>
                                                    <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=$row['name']?></option>
                                                <?php
                                                }

                                                ?>
                            </select>

                        </div>
                      </div>
                      <div class="col-md-offset-3 col-md-6">
                    <center>
                        <button type="submit" id="conf_edit_group" class="btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> <?=get_lang('CONF_act_edit');?></button>

                    </center>

                    </div>
                    </form>
                    <div class="col-md-12" style="margin-top:10px;" id="conf_edit_group_res"></div>

                  </div>
                </div>
                <div class="tab-pane fade" id="conf_mail">
                  <div class="col-md-12 box-body_conf">
                    <form class="form-horizontal" role="form">
                    <div class="form-group">
                    <label for="mail_active" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_status');?></small></label>
                    <div class="col-sm-8">
                  <select class="my_select2 select" id="mail_active">
                  <option value="true" <?php if (get_conf_param('mail_active') == "true") {echo "selected";} ?>><?=get_lang('CONF_true');?></option>
                  <option value="false" <?php if (get_conf_param('mail_active') == "false") {echo "selected";} ?>><?=get_lang('CONF_false');?></option>
                </select>    </div>
                  </div>

                  <div class="form-group">
                    <label for="from" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_from');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="from" placeholder="<?=get_lang('CONF_mail_from');?>" value="<?=get_conf_param('mail_from')?>">
                    </div>
                  </div>
                      <div class="form-group">
                    <label for="mail_type" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_type');?></small></label>
                    <div class="col-sm-8">
                  <select class="my_select2 select" id="mail_type">
                  <option value="sendmail" <?php if (get_conf_param('mail_type') == "sendmail") {echo "selected";} ?>>sendmail</option>
                  <option value="SMTP" <?php if (get_conf_param('mail_type') == "SMTP") {echo "selected";} ?>>SMTP</option>
                </select>    </div>
                  </div>

                  <div id="smtp_div">

                    <div class="form-group">
                    <label for="host" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_host');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="host" placeholder="<?=get_lang('CONF_mail_host');?>" value="<?=get_conf_param('mail_host')?>">
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="port" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_port');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="port" placeholder="<?=get_lang('CONF_mail_port');?>" value="<?=get_conf_param('mail_port')?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="auth" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_auth');?></small></label>
                    <div class="col-sm-8">
                  <select class="my_select2 select" id="auth">
                  <option value="true" <?php if (get_conf_param('mail_auth') == "true") {echo "selected";} ?>><?=get_lang('CONF_true');?></option>
                  <option value="false" <?php if (get_conf_param('mail_auth') == "false") {echo "selected";} ?>><?=get_lang('CONF_false');?></option>
                </select>    </div>
                  </div>

                  <div class="form-group">
                    <label for="auth_type" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_type');?></small></label>
                    <div class="col-sm-8">
                  <select class="my_select2 select" id="auth_type">
                  <option value="none" <?php if (get_conf_param('mail_auth_type') == "none") {echo "selected";} ?>>no</option>
                  <option value="ssl" <?php if (get_conf_param('mail_auth_type') == "ssl") {echo "selected";} ?>>SSL</option>
                  <option value="tls" <?php if (get_conf_param('mail_auth_type') == "tls") {echo "selected";} ?>>TLS</option>
                </select>    </div>
                  </div>

                      <div class="form-group">
                    <label for="username" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_login');?></small></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" id="username" placeholder="<?=get_lang('CONF_mail_login');?>" value="<?=get_conf_param('mail_username')?>">
                    </div>
                  </div>

                      <div class="form-group">
                    <label for="password" class="col-sm-4 control-label"><small><?=get_lang('CONF_mail_pass');?></small></label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control input-sm" id="password" placeholder="<?=get_lang('CONF_mail_pass');?>" value="<?=get_conf_param('mail_password')?>">
                    </div>
                  </div>

                  </div>


                    <div class="col-md-offset-3 col-md-6">
                <center>
                    <button type="submit" id="conf_edit_mail" class="btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> <?=get_lang('CONF_act_edit');?></button>

                </center>
                </div>
                    </form>
                    <button type="submit" id="conf_test_mail" class="btn btn-default btn-sm pull-right"> test</button>
                      <div class="col-md-12" style="margin-top:10px;" id="conf_edit_mail_res"></div>
                      <div class="col-md-12" style="margin-top:10px;" id="conf_test_mail_res"></div>
                  </div>
                </div>
              </div>
            </div>




      </div>
            <br>
      <?php

       ?>



</div>




<br>
</div>

<?php
include("footer.php");
}
}
else {
    include 'auth.php';
}
 ?>
