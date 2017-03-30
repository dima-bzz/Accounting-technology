<?php

session_start();
include_once("functions.php");
if ( isset($_POST['mode']) ) {
    $mode=($_POST['mode']);

    if ($mode == "get_lang_param") {
        $p=($_POST['param']);
        $r=lang($p);
        print($r);
    }

    if ($mode == "activate_login") {
    $mailadr=($_POST['mailadress']);


    $stmt = $dbConnection->prepare('SELECT id, fio,login,dostup FROM users where email=:mailadr');
    $stmt->execute(array(':mailadr' => $mailadr));
    $r = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($r)) {

        if ($r['dostup'] == "0") {

            $l=$r['login'];
            $fio=$r['fio'];
            $id=$r['id'];

            $pass=randomPassword();

            mailtoactivate($l, $mailadr, $pass);
            mailtoactivate_admin($l, $mailadr, $pass);

            // $npass=$pass;
            $stmt = $dbConnection->prepare("UPDATE users SET pass=:pass, dostup=1 where id=:id");
            $stmt->execute(array(':pass' => $pass, ':id' => $id));

            ?>
            <div class="alert alert-success">
                <center><?=get_lang('CREATE_ACC_success');?>
                </center>
            </div>
        <?php
        }
        else if ($r['dostup'] == "1") {

            ?>
            <div class="alert alert-danger">
                <center><?=get_lang('CREATE_ACC_already');?>
                </center>
            </div>
        <?php

        }

    }
    else {
        ?>
        <div class="alert alert-danger">
            <center><?=get_lang('CREATE_ACC_error');?>
            </center>
        </div>
    <?php
    }
    ?>
    <center>
  <i class="fa fa-slideshare fa-5x" aria-hidden="true"></i>
  <h2 class="text-muted"><?=get_lang('MAIN_TITLE');?></h2><small class="text-muted"><?=get_lang('AUTH_USER');?></small></center><br>
  <input type="text" class="form-control" autocomplete="off"  id="login" name="login" placeholder="<?=get_lang('CONF_mail_login');?>">
  <input type="password" class="form-control" autocomplete="off" id="password" name="password" placeholder="<?=get_lang('CONF_mail_pass');?>">
    <div style="padding-left:75px;">
        <div class="checkbox">
            <label>
                <input id="mc" name="remember_me" value="1" type="checkbox"> <?=get_lang('remember_me');?>
            </label>
        </div>
    </div>
        <?php if ($va == 'error') { ?>
            <div class="alert alert-danger">
                <center><?=get_lang('error_auth');?></center>
            </div> <?php } ?>
            <input type="hidden" name="req_url" value="/index.php">
  <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;<?=get_lang('log_in');?></button>
  <?php

   if ($CONF['first_login'] == "true") { ?>
  <small>
      <center style=" margin-bottom: -20px; "><br><a href="#" id="show_activate_form"><?=get_lang('first_in_auth');?>.</a>
      </center>
  </small>
<?php } ?>

  <small>
            <center style=" margin-bottom: -20px; "><br><a href="/hd/index.php">Система Заявок</a>
            </center>
        </small>

<?php

}
if ($mode == "activate_login_form") {
    ?>
    <center><i class="fa fa-slideshare fa-5x" aria-hidden="true"></i><h2 class="text-muted"><?=get_lang('MAIN_TITLE');?></h2><small class="text-danger"><?=get_lang('user_auth');?></small></center><br>
    <input type="text" id="mailadress" name="login" autocomplete="off" class="form-control" placeholder="<?=get_lang('work_mail');?>">
    <p class="help-block"><small><?=get_lang('work_mail_ph');?></small></p>
    <div style="padding-left:75px;">
    </div>
    <br>
    <button id="do_activate" type="submit" class="btn btn-lg btn-success btn-block"> <i class="fa fa-check-circle-o" aria-hidden="true"></i>  <?=get_lang('action_auth');?></button>






<?php
}

    if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
      if ($mode == "show") {
  if (isset($_POST['query'])) {
    $query = $_POST['query'];
    if ($query != 'online' || 'offline'){
  $stmt = $dbConnection->prepare('SELECT fio, id FROM users WHERE fio LIKE :query and on_off = 1 order by fio asc');
  $stmt->execute(array(':query' => '%'.$query.'%'));
  $res1 = $stmt->fetchAll();
  $array  = array();
  foreach($res1 as $row) {
    $s = get_user_status_home($row['id']);

    $array[]=$s."#".$row['fio'];

  }
  }
  if ($query == 'online') {
    $stmt = $dbConnection->prepare('SELECT fio, id FROM users WHERE UNIX_TIMESTAMP(lastdt)>UNIX_TIMESTAMP(NOW())-20 and on_off = 1 order by fio asc');
    $stmt->execute();
    $res1 = $stmt->fetchAll();
    $array  = array();
    foreach($res1 as $row) {
      $s = get_user_status_home($row['id']);

      $array[]=$s."#".$row['fio'];

    }
  }
  if ($query == 'offline') {
    $stmt = $dbConnection->prepare('SELECT fio, id FROM users WHERE UNIX_TIMESTAMP(lastdt)<UNIX_TIMESTAMP(NOW())-20 and on_off = 1 order by fio asc');
    $stmt->execute();
    $res1 = $stmt->fetchAll();
    $array  = array();
    foreach($res1 as $row) {
      $s = get_user_status_home($row['id']);

      $array[]=$s."#".$row['fio'];

    }
  }
  echo json_encode($array);
  }
  }
  if ($mode == "search") {
    if (isset($_POST['search'])) {
        // никогда не доверяйте входящим данным! Фильтруйте всё!
        $word = mysql_real_escape_string($_POST['search']);
        // Строим запрос
      $stmt = $dbConnection->prepare("SELECT users_profile.homephone as homephone, users_profile.telephonenumber as telephonenumber, users.email as email, users_profile.emaildop as emaildop, users.fio, places.name as plname FROM users_profile INNER JOIN users ON users.id =users_profile.usersid LEFT JOIN places_users ON users.id=userid LEFT JOIN places ON places.id=placesid WHERE users.fio = :word and users.on_off = 1");
        $stmt->execute(array(':word' => $word));
        $res1 = $stmt->fetchAll();

        foreach($res1 as $row) {
                      if ($row['plname'] != ''){
                        echo "<div class=\"form-group\"><div class=\"col-sm-6 text-right\"><strong><small>Кабинет:</small></strong></div><div class=\"col-sm-6\"><small>". $row['plname']."</small></div></div>";
                      }
                     if ($row['homephone'] != ''){
                       echo "<div class=\"form-group\"><div class=\"col-sm-6 text-right\"><strong><small>Рабочий телефон:</small></strong></div><div class=\"col-sm-6\"><small>". $row['homephone']."</small></div></div>";
                     }
                     if ($row['telephonenumber'] != ''){
                       echo "<div class=\"form-group\"><div class=\"col-sm-6 text-right\"><strong><small>Сотовый телефон:</strong></small></div><div class=\"col-sm-6\"><small>". $row['telephonenumber']."</small></div></div>";
                     }
                     if ($row['email'] != ''){
                       echo "<div class=\"form-group\"><div class=\"col-sm-6 text-right\"><strong><small>Основной E-mail:</strong></small></div><div class=\"col-sm-6\"><small>". $row['email']."</small></div></div>";
                     }
                     if ($row['emaildop'] != ''){
                       echo "<div class=\"form-group\"><div class=\"col-sm-6 text-right\"><strong><small>Дополнительный E-mail:</strong></small></div><div class=\"col-sm-6\"><small>". $row['emaildop']."</small></div></div>";
                     }
          }
    }
    }
if ($mode == "conf_edit_main") {
update_val_by_key("name_of_firm", $_POST['name_of_firm']);
update_val_by_key("title_header", $_POST['title_header']);
update_val_by_key("hostname", $_POST['hostname']);
update_val_by_key("first_login", $_POST['first_login']);
update_val_by_key("mail", $_POST['mail']);
update_val_by_key("file_types", $_POST['file_types']);
update_val_by_key("file_types_img", $_POST['file_types_img']);
update_val_by_key("file_size", $_POST['file_size']);
update_val_by_key("permit_users_knt", $_POST['permit_users_knt']);
update_val_by_key("permit_users_req", $_POST['permit_users_req']);
update_val_by_key("permit_users_cont", $_POST['permit_users_cont']);
update_val_by_key("permit_users_documents", $_POST['permit_users_documents']);
update_val_by_key("permit_users_news", $_POST['permit_users_news']);
update_val_by_key("permit_users_license", $_POST['permit_users_license']);
update_val_by_key("default_org", $_POST['default_org']);
update_val_by_key("what_cartridge", $_POST['what_cartridge']);
update_val_by_key("what_print_test", $_POST['what_print_test']);
update_val_by_key("what_license", $_POST['what_license']);
update_val_by_key("home_text", $_POST['home_text']);


?>
<div class="alert alert-success">
<?=get_lang('PROFILE_msg_ok');?>
</div>
<?php
}

if ($mode == "conf_edit_mail") {
update_val_by_key("mail_type", $_POST['type']);
update_val_by_key("mail_active", $_POST['mail_active']);
update_val_by_key("mail_host", $_POST['host']);
update_val_by_key("mail_port", $_POST['port']);
update_val_by_key("mail_auth", $_POST['auth']);
update_val_by_key("mail_auth_type", $_POST['auth_type']);
update_val_by_key("mail_username", $_POST['username']);
update_val_by_key("mail_password", $_POST['password']);
update_val_by_key("mail_from", $_POST['from']);
//update_val_by_key("mail_debug", $_POST['debug']);
?>
<div class="alert alert-success">
<?=get_lang('PROFILE_msg_ok');?>
</div>
<?php
}

if ($mode == "delete_all"){

  echo "<button class=\"btn btn-primary\" type=\"button\" name=\"delete_update\" id=\"delete_update\">".get_lang('Update')."</button></p>";

  $mfiles1=GetArrayFilesInDir("deleterules");
  foreach ($mfiles1 as &$fname1) {
      if (strripos($fname1,".xml")!=FALSE){
      echo "<i class=\"fa fa-undo fa-flip-horizontal fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Update_pravil')." $fname1</br>";
      $xml = simplexml_load_file("deleterules/$fname1");
       foreach($xml->entertable as $data){
              $entertable_name=$data["name"];
              $entertable_comment = lang_delete($entertable_name);
              $entertable_key=$data["key"];
              echo "&nbsp;&nbsp;<i class=\"fa fa-arrow-down fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Table2')." $entertable_name ($entertable_comment). ".get_lang('Poisk')." $entertable_key</br>";
              $stmt = $dbConnection->prepare("SELECT * FROM $entertable_name where active=0");
              $stmt->execute();
              $res1 = $stmt->fetchall();

                  // листаем все записи таблицы помеченные на удаление
                  foreach($res1 as $myrow) {
                      $entertable_id=$myrow["$entertable_key"];
                      echo "&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-arrow-down fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Check')." $entertable_name ".get_lang('C')." $entertable_key = $entertable_id</br>";
                      foreach($data->reqtable as $data_req){
                          $data_req_name=$data_req["name"];
                          $data_req_comment = lang_delete($data_req_name);
                          $data_req_key=$data_req["key"];
                          $data_req_is_delete=$data_req["is_delete"];
                          $data_req_is_delete_lang = lang_is_delete($data_req_is_delete);
                          $yet=false;
                          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-arrow-down fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Table3')." $data_req_name ($data_req_comment). ".get_lang('Poisk')." $data_req_key. ".get_lang('Del_zavis').": $data_req_is_delete_lang</br>";
                          // если удаляем безоговорочно, то удаляем. Иначе - если записи есть в таблице зависимые, то прерываем выполнение скрипта
                          if ($data_req_is_delete=="yes") {
                            $stmt = $dbConnection->prepare("SELECT * FROM $data_req_name WHERE $data_req_key=$entertable_id");
                            // проверяем наличие записей

                          //   if ($entertable_name == 'users_profile'){
                          //   $stmt = $dbconnect->prepare ("SELECT jpegphoto from $entertable_name WHERE $entertable_key=$entertable_id");
                          //   $stmt->execute();
                          //   $row = $stmt->fetch(PDO::FETCH_ASSOC);
                          //   $photo=$row['jpegphoto'];
                          // }



                            $stmt->execute();
                            $res1 = $stmt->fetchall();
                            foreach($res1 as $myrow){
                              // удаляем содержимое таблицы
                                if ($data_req_name == 'users_profile'){
                              $photo=$myrow['jpegphoto'];
                              if ($photo != 'noavatar.png'){
                              unlink(realpath(dirname(__FILE__))."/images/avatar/".$photo);
                            }
                            }
                             echo "<div class=\"text-success\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-trash fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Del_row')."<br></div>";
                            }
                            $stmt = $dbConnection->prepare("DELETE FROM $data_req_name WHERE $data_req_key=$entertable_id");
                            $stmt->execute();
                          } else
                          {
                            $stmt = $dbConnection->prepare("SELECT * FROM $data_req_name WHERE $data_req_key=$entertable_id");
                            // проверяем наличие записей
                            $stmt->execute();
                            $res1 = $stmt->fetchall();
                            foreach($res1 as $myrow) {$yet=true;echo "<div class=\"text-danger\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fa fa-exclamation fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Find_zavis')."<br></div>";};
                          };
                          if (($yet==true) and ($data_req_is_delete=="no")) {break;};
                      };
                      if (($yet==true) and ($data_req_is_delete=="no")) {break;} else {
                          if ($entertable_name == 'equipment'){
                          $stmt = $dbConnection->prepare ("SELECT photo from $entertable_name WHERE $entertable_key=$entertable_id");
                          $stmt->execute();
                          $row = $stmt->fetch(PDO::FETCH_ASSOC);
                          $photo=$row['photo'];
                          if ($photo != 'noimage.png'){
                          unlink(realpath(dirname(__FILE__))."/images/equipment/".$photo);
                        }
                        }

                            $stmt = $dbConnection->prepare("DELETE FROM $entertable_name WHERE $entertable_key=$entertable_id");
                            $stmt->execute();

                            $stmt = $dbConnection->prepare("DELETE FROM approve WHERE $entertable_name=$entertable_id");
                            $stmt->execute();
                             // удаляем содержимое таблицы
                            echo "<div class=\"text-success\"><i class=\"fa fa-trash fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Del_row2')." $entertable_name ".get_lang('C')." $entertable_key = $entertable_id<br></div>";
                      };
                  };
              //var_dump($data);
          };

      }
  }
  echo "<br><i class=\"fa fa-check fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Search_delete')."<br>";
  unset($fname1);
}
if ($mode == "otmena_delete"){
  if ($_POST['id'] != ''){
  $id = $_POST['id'];
  $name = $_POST['name'];

  $stmt = $dbConnection->prepare ("UPDATE $name SET active = 1 WHERE id = $id");
  $stmt->execute();

  $stmt = $dbConnection->prepare ("DELETE FROM approve WHERE $name = $id");
  $stmt->execute();
}

  $mfiles1=GetArrayFilesInDir("deleterules");
  foreach ($mfiles1 as &$fname1) {
      if (strripos($fname1,".xml")!=FALSE){
      $xml = simplexml_load_file("deleterules/$fname1");
       foreach($xml->entertable as $data){
              $entertable_name=$data["name"];
              $entertable_key=$data["key"];
              $entertable_comment = lang_delete($entertable_name);

              $stmt = $dbConnection->prepare("SELECT * FROM $entertable_name where active=0");
              $stmt->execute();
              $res1 = $stmt->fetchall();

              foreach($res1 as $myrow) {
                  $entertable_id=$myrow["$entertable_key"];

                  echo "<i class=\"fa fa-trash fa-fw\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Table')." <b>$entertable_name ($entertable_comment)</b> ".get_lang('Metka')." $entertable_key = $entertable_id <button id=\"otmena\" class=\"btn btn-xs btn-primary\" id_del=\"$entertable_id\" name=\"$entertable_name\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Otmena')."\"><i class=\"fa fa-remove fa-fw\" aria-hidden=\"true\"></i></button></br>";
                }
                }

              }

            }


            unset($fname1);
?>
<div id="delete_ok">
<?php
if ($entertable_id != ''){
echo "<br><b>".get_lang('Delete_ok')."</b> <button class=\"btn btn-danger\" type=\"button\" name=\"dell_all\" id=\"dell_all\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i>&nbsp;".get_lang('Delete_button')."</button></p>";
}
 ?>
</div>
<?php
}
if ($mode == "equipment_add") {
  define('UPLOAD_DIR', 'images/equipment/');
  $sorgid=($_POST['sorgid']);
  $splaces=($_POST['splaces']);
  $suserid=($_POST['suserid']);
  $snomeid=($_POST['snomeid']);
  $dtpost=DateToMySQLDateTime2($_POST["dtpost"]);
	$dtendgar=DateToMySQLDateTime2($_POST["dtendgar"]);
  $buhname=($_POST['buhname']);
  $cost=($_POST['cost']);
  $currentcost=($_POST['currentcost']);
  $sernum=mb_strtoupper(($_POST["sernum"]),'utf-8');
  $invnum=($_POST['invnum']);
  $invoice=($_POST['invoice']);
  $invoice_date=($_POST['invoice_date']);
  $invoice_end = $invoice." от ".$invoice_date;
  $os=($_POST['os']);
  if ($os == "true") {$os=1;} else {$os=0;}
  $mode_eq=($_POST['mode_eq']);
  if ($mode_eq == "true") {$mode_eq=1;} else {$mode_eq=0;}
  $eq_util=($_POST['eq_util']);
  if ($eq_util == "true") {$eq_util=1;} else {$eq_util=0;}
  $eq_sale=($_POST['eq_sale']);
  if ($eq_sale == "true") {$eq_sale=1;} else {$eq_sale=0;}
  $bum=($_POST['bum']);
  if ($bum == "true") {$bum=1;} else {$bum=0;}
  $comment=($_POST['comment']);
  $ip=($_POST['ip']);
  $kntid=($_POST['kntid']);
  if ($_POST['img'] !=''){
$img = ($_POST['img']);

$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = uniqid() . '.png';
$success = file_put_contents(UPLOAD_DIR . $file, $data);
// print $success ? $file : 'Unable to save the file.';
}
else {
  $file = 'noimage.png';
}
  $stmt = $dbConnection->prepare('INSERT INTO equipment (id,orgid,placesid,usersid,nomeid,buhname,datepost,cost,currentcost,sernum,invnum,invoice,os,mode,bum,comment,photo,active,ip,kntid,dtendgar,util,sale) VALUES (:id,:sorgid,:splaces,:suserid,:snomeid,:buhname,:dtpost,:cost,:currentcost,:sernum,:invnum,:invoice,:os,:mode,:bum,:comment,:photo,:active,:ip,:kntid,:dtendgar,:util,:sale)');
  $stmt->execute(array(
      ':id'=>'NULL',
      ':sorgid'=>$sorgid,
      ':splaces'=>$splaces,
      ':suserid'=>$suserid,
      ':snomeid'=>$snomeid,
      ':buhname'=>$buhname,
      ':dtpost'=>$dtpost,
      ':cost'=>$cost,
      ':currentcost'=>$currentcost,
      ':sernum'=>$sernum,
      ':invnum'=>$invnum,
      ':invoice'=>$invoice_end,
      ':os'=>$os,
      ':mode'=>$mode_eq,
      ':bum'=>$bum,
      ':comment'=>$comment,
      ':photo'=>$file,
      ':active'=>'1',
      ':ip'=>$ip,
      ':kntid'=>$kntid,
      ':dtendgar'=>$dtendgar,
      ':util'=>$eq_util,
      ':sale'=>$eq_sale));

      $stmt = $dbConnection->prepare('Select max(last_insert_id(id)) as eq_id from equipment');
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $eq_id = $row["eq_id"];
      // var_dump($eq_id);
      $stmt = $dbConnection->prepare('INSERT INTO shtr (eqid,orgid) VALUES (:eqid, :orgid)');
      $stmt->execute(array(':eqid'=> $eq_id,':orgid'=> $sorgid));
      echo "ok";

// $stmt->debugDumpParams();
}
if ($mode == "equipment_edit"){
  define('UPLOAD_DIR', 'images/equipment/');
  $id = ($_POST['id']);
  $snomeid=($_POST['snomeid']);
  $dtpost=DateToMySQLDateTime2($_POST["dtpost"]);
	$dtendgar=DateToMySQLDateTime2($_POST["dtendgar"]);
  $buhname=($_POST['buhname']);
  $cost=($_POST['cost']);
  $currentcost=($_POST['currentcost']);
  $sernum=mb_strtoupper(($_POST["sernum"]),'utf-8');
  $invnum=($_POST['invnum']);
  $invoice=($_POST['invoice']);
  $invoice_date=($_POST['invoice_date']);
  $invoice_end = $invoice." от ".$invoice_date;
  $os=($_POST['os']);
  if ($os == "true") {$os=1;} else {$os=0;}
  $mode_eq=($_POST['mode_eq']);
  if ($mode_eq == "true") {$mode_eq=1;} else {$mode_eq=0;}
  $eq_util=($_POST['eq_util']);
  if ($eq_util == "true") {$eq_util=1;} else {$eq_util=0;}
  $eq_sale=($_POST['eq_sale']);
  if ($eq_sale == "true") {$eq_sale=1;} else {$eq_sale=0;}
  $bum=($_POST['bum']);
  if ($bum == "true") {$bum=1;} else {$bum=0;}
  $comment=($_POST['comment']);
  $ip=($_POST['ip']);
  $kntid=($_POST['kntid']);
$img = ($_POST['img']);
$stmt = $dbConnection->prepare ('SELECT photo FROM equipment WHERE id=:id');
$stmt->execute(array(':id' => $id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$photo = $row['photo'];
if ($_POST['img'] != ''){
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
if (($photo != '') && ($photo != 'noimage.png')){
if (file_exists(UPLOAD_DIR . $photo)){
  $file = $photo;
}
else{
$file = uniqid() . '.png';
}
}
else {
$file = uniqid() . '.png';
}
$success = file_put_contents(UPLOAD_DIR . $file, $data);
print $success ? $file : 'Unable to save the file.';
}
else {
  if ($photo != ''){
    $file = $photo;
  }
  else {
    $file = 'noimage.png';
  }
}
  $stmt = $dbConnection->prepare ('UPDATE equipment SET nomeid=:snomeid,buhname=:buhname,
datepost=:dtpost,cost=:cost,currentcost=:currentcost,sernum=:sernum,invnum=:invnum,
invoice=:invoice,os=:os,mode=:mode,bum=:bum,comment=:comment,ip=:ip,kntid=:kntid,dtendgar=:dtendgar,photo=:photo,util=:util,sale=:sale WHERE id=:id');
$stmt->execute(array(
    ':id' => $id,
    ':snomeid'=>$snomeid,
    ':buhname'=>$buhname,
    ':dtpost'=>$dtpost,
    ':cost'=>$cost,
    ':currentcost'=>$currentcost,
    ':sernum'=>$sernum,
    ':invnum'=>$invnum,
    ':invoice'=>$invoice_end,
    ':os'=>$os,
    ':mode'=>$mode_eq,
    ':bum'=>$bum,
    ':comment'=>$comment,
    ':ip'=>$ip,
    ':kntid'=>$kntid,
    ':dtendgar'=>$dtendgar,
    ':photo'=>$file,
    ':util'=>$eq_util,
    ':sale'=>$eq_sale));
    echo "ok";
}
if ($mode == "equipment_move"){
  $sorgid=$_POST["sorgid"];
  $splaces=$_POST["splaces"];
  $suserid=$_POST["suserid"];
  $comment=$_POST["comment"];

  $id = ($_POST['id']);
  $id = explode(",",$id);
  for ($i=0; $i < count($id) ; $i++) {
  $ids = $id[$i];
  $etmc=new Tequipment;
  $etmc->GetById($ids);

  $stmt = $dbConnection->prepare ('UPDATE equipment SET orgid=:orgid,placesid=:splaces,usersid=:suserid WHERE id= :id');
  $stmt->execute(array(':orgid' => $sorgid, ':splaces' => $splaces, ':suserid' => $suserid, ':id' => $ids));

  $stmt = $dbConnection->prepare ('UPDATE license SET usersid=:suserid WHERE usersid=:usersid and  eqid= :id');
  $stmt->execute(array(':usersid' => $etmc->usersid, ':suserid' => $suserid, ':id' => $ids));

  $stmt = $dbConnection->prepare ('INSERT INTO move (id,eqid,dt,orgidfrom,orgidto,placesidfrom,placesidto,useridfrom,useridto,kntfrom,invoice,comment) VALUES (NULL,:eqid,NOW(),:orgid,:sorgid,:placesid,:splaces,:usersid,:suserid,:kntid,:invoice,:comment)');
  $stmt->execute(array(':usersid' => $etmc->usersid,':suserid' => $suserid, ':orgid' => $etmc->orgid, ':sorgid' => $sorgid, ':placesid' => $etmc->placesid, ':splaces' => $splaces, ':kntid' => $etmc->kntid, ':invoice' => $etmc->invoice, ':comment' => $comment, ':eqid' => $ids));
  }
  echo "ok";
}
if ($mode == "equipment_copy"){
  $sorgid=$_POST["sorgid"];
  $splaces=$_POST["splaces"];
  $suserid=$_POST["suserid"];
  if ($_POST['nomcopy'] != "") {$nomcopy=$_POST["nomcopy"];} else {$nomcopy = "1";};
  $buhname=($_POST["buhname"]);

  $id = ($_POST['id']);
  $id = explode(",",$id);
  foreach ($id as $ids) {
  $etmc=new Tequipment;
  $etmc->GetById($ids);
  // echo($ids);

  for ($g = 1; $g <= $nomcopy; $g++){
      $stmt = $dbConnection->prepare ('INSERT INTO equipment (id, orgid, placesid, usersid, nomeid, buhname, datepost, cost, currentcost, sernum, invnum, invoice, os, mode, bum,  comment, active, kntid,dtendgar) VALUES (NULL,:sorgid, :splaces, :suserid, :nomeid, :buhname, :datepost, :cost,:currentcost, :sernum, :invnum, :invoice,:os,:mode,:bum, :comment,:active,:kntid, :dtendgar)');
      $stmt->execute(array(
        ':suserid' => $suserid,
        ':sorgid' => $sorgid,
        ':splaces' => $splaces,
        ':kntid' => $etmc->kntid,
        ':invoice' => $etmc->invoice,
        ':comment' => $etmc->comment,
        ':nomeid' => $etmc->nomeid,
        ':buhname' => $buhname,
        ':datepost' => $etmc->datepost,
        ':cost' => $etmc->cost,
        ':currentcost' => $etmc->currentcost,
        ':sernum' => $etmc->sernum,
        ':invnum' => $etmc->invnum,
        ':os' => $etmc->os,
        ':mode' => $etmc->mode,
        ':bum' => $etmc->bum,
        ':dtendgar' => $etmc->dtendgar,
        ':active' => '1'));

        $stmt = $dbConnection->prepare('Select max(last_insert_id(id)) as eq_id from equipment');
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $eq_id = $row["eq_id"];
        // var_dump($eq_id);
        $stmt = $dbConnection->prepare('INSERT INTO shtr (eqid,orgid) VALUES (:eqid, :orgid)');
        $stmt->execute(array(':eqid'=> $eq_id,':orgid'=> $sorgid));
      }
    }
    echo "ok";
}
if ($mode == "equipment_delete"){
  $id=$_POST["id"];
  $id = explode(",",$id);
  foreach ($id as $ids) {
        $stmt = $dbConnection->prepare ('UPDATE equipment SET active = not active WHERE id = :id');
        $stmt->execute(array(':id' => $ids));

        $stmt = $dbConnection->prepare ('SELECT active FROM equipment WHERE id=:id');
        $stmt->execute(array(':id' => $ids));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $active = $row['active'];
        if ($active == '0'){
        $stmt = $dbConnection->prepare ('INSERT INTO approve (id,equipment) VALUES (NULL,:id)');
        $stmt->execute(array(':id' => $ids));
      }
      else {
        $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE equipment = :id');
        $stmt->execute(array(':id' => $ids));
      }
}
echo "ok";
}
if ($mode == "equipment_repair"){
  $id=$_POST["id"];
  $dt = DateToMySQLDateTime2($_POST["dt"]);
  $dtend = DateToMySQLDateTime2($_POST["dtend"]." 00:00:00");
  $kntid=$_POST["kntid"];
  $cst=$_POST["cst"];
  $comment=$_POST["comment"];
  $status = $_POST['status'];
  if ($status == '1'){
  $stmt = $dbConnection->prepare ('INSERT INTO repair (id,dt,kntid,eqid,cost,comment,dtend,status)
  VALUES (NULL,:dt,:kntid,:eqid,:cst,:comment,:dtend,:status)');
  $stmt->execute(array(':dt' => $dt, ':kntid' => $kntid, ':eqid' => $id, ':cst' => $cst, ':comment' => $comment, ':dtend' => $dtend, 'status' => $status));
  echo "ok";
  }
  else {
    $stmt = $dbConnection->prepare ('UPDATE repair SET dt = :dt, kntid = :kntid, cost = :cst, comment = :comment, dtend = :dtend, status = :status WHERE eqid = :eqid and status = 1');
    $stmt->execute(array(':dt' => $dt, ':kntid' => $kntid, ':eqid' => $id, ':cst' => $cst, ':comment' => $comment, ':dtend' => $dtend, 'status' => $status));
    echo "ok";
  }
  $stmt = $dbConnection->prepare ('UPDATE equipment SET repair=:status WHERE id=:eqid');
  $stmt->execute(array(':status' => $status, ':eqid' => $id));
}
if ($mode == "equipment_repair_edit"){
  $id=$_POST["id"];
  $dt = DateToMySQLDateTime2($_POST["dt"]);
  $dtend = DateToMySQLDateTime2($_POST["dtend"]);
  $kntid=$_POST["kntid"];
  $cst=$_POST["cst"];
  $comment=$_POST["comment"];
  $status = $_POST['status'];

  $stmt = $dbConnection->prepare ('UPDATE repair SET dt = :dt, kntid = :kntid, cost = :cst, comment = :comment, dtend = :dtend, status = :status WHERE id = :id');
  $stmt->execute(array(':dt' => $dt, ':kntid' => $kntid, ':id' => $id, ':cst' => $cst, ':comment' => $comment, ':dtend' => $dtend, 'status' => $status));
  echo "ok";
}
if ($mode == "equipment_repair_delete"){
  $id=$_POST["id"];
  $eqid=$_POST["eqid"];

  $stmt = $dbConnection->prepare ('DELETE FROM repair WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('UPDATE equipment SET repair= 0 WHERE id=:eqid');
  $stmt->execute(array(':eqid' => $eqid));
  echo "ok";
}
if ($mode == "equipment_move_edit"){
  $id=$_POST["id"];
  $comment=$_POST["comment"];

  $stmt = $dbConnection->prepare ('UPDATE move SET comment = :comment WHERE id = :id');
  $stmt->execute(array(':id' => $id, ':comment' => $comment));
  echo "ok";
}
if ($mode == "equipment_move_delete"){
  $id=$_POST["id"];

  $stmt = $dbConnection->prepare ('DELETE FROM move WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  echo "ok";
}
if ($mode == "eq_mat"){
  $uid = $_SESSION['dilema_user_id'];
  $stmt = $dbConnection->prepare('SELECT name as grname,res2.* FROM group_nome INNER JOIN (SELECT places.name as plname,res.* FROM places INNER JOIN(
                SELECT name AS namenome,nome.groupid as grpid, eq . *  FROM nome INNER JOIN(SELECT users.fio AS fio, fi . * FROM users INNER JOIN(SELECT org.name AS orgname, rg . * FROM org INNER JOIN ( SELECT shtr.id as shtrid, shtr.orgid as shtr_orgid, shtr.shtr_id as shtr_id, sh . * FROM shtr INNER JOIN(
                SELECT equipment.id AS eqid, equipment.placesid AS plid, equipment.usersid AS usid,equipment.orgid AS eqorgid, equipment.nomeid AS nid, equipment.buhname AS bn, equipment.cost AS cs, equipment.currentcost AS curc, equipment.invnum, equipment.sernum, equipment.mode as eqmode, equipment.os as os FROM equipment
                WHERE  equipment.active = :eq_active and equipment.usersid= :eq_usersid and equipment.util = :eq_util and equipment.sale = :eq_sale)
                AS sh ON shtr.eqid = sh.eqid)
    AS rg ON org.id=rg.eqorgid)
    AS fi ON users.id=fi.usid)
                AS eq ON nome.id = eq.nid)
                AS res ON places.id=res.plid)   AS res2 ON group_nome.id=res2.grpid');
                $stmt->execute(array(':eq_active'=> '1',':eq_usersid'=> $uid,':eq_util'=>'0',':eq_sale'=>'0'));
                $res1 = $stmt->fetchall();
                  foreach($res1 as $row => $info) {
                    if ($info['os']==1){$os= true;} else {$os= false;};
                    if ($info['eqmode']==1){$eqmode=true;} else {$eqmode=false;};
                    $fiopol=nameshort($info['fio']);
                    $shtrih = ($info['shtrid'])."".(str_pad(($info['shtr_orgid']),3,'0',STR_PAD_LEFT))."".(str_pad(($info['shtr_id']),7,'0',STR_PAD_LEFT));

                    $data = array($info['eqid'],$info['plname'],$info['namenome'],$info['grname'],$info['sernum'],$shtrih,$info['orgname'],$fiopol,$os,$eqmode,$info['bn']);
                    $output['aaData'][] = $data;
                  }
                  if ($output != ''){
                  echo json_encode($output);
                }else {
                  $data = array('aaData'=>'');
                  $output['aaData']=$data;
                  echo json_encode($output);
                }
}
if ($mode == "eq"){
    $orid = $_COOKIE['cookieorgid'];
    $util_eq= $_COOKIE['cookie_eq_util'];
    $sale_eq= $_COOKIE['cookie_eq_sale'];
  $stmt = $dbConnection->prepare("SELECT equipment.dtendgar, knt.name as kntname, getvendorandgroup.grnomeid,equipment.id AS eqid,equipment.orgid AS eqorgid, org.name AS orgname, getvendorandgroup.vendorname AS vname,
            getvendorandgroup.groupname AS grnome, places.name AS placesname, users.login AS userslogin,users.fio AS fio,
            getvendorandgroup.nomename AS nomename, buhname, sernum, invnum, shtr.id as shtrid, shtr.orgid as shtr_orgid, shtr.shtr_id as shtr_id,invoice, datepost, cost, currentcost, os, equipment.mode AS eqmode,equipment.bum AS eqbum,equipment.comment AS eqcomment, equipment.active AS eqactive,equipment.repair AS eqrepair, equipment.util AS equtil, equipment.sale AS eqsale
  FROM equipment
  INNER JOIN (
  SELECT nome.groupid AS grnomeid,nome.id AS nomeid, vendor.name AS vendorname, group_nome.name AS groupname, nome.name AS nomename
  FROM nome
  INNER JOIN group_nome ON nome.groupid = group_nome.id
  INNER JOIN vendor ON nome.vendorid = vendor.id
  ) AS getvendorandgroup ON getvendorandgroup.nomeid = equipment.nomeid
  INNER JOIN org ON org.id = equipment.orgid
  INNER JOIN places ON places.id = equipment.placesid
  INNER JOIN shtr ON shtr.eqid = equipment.id
  INNER JOIN users ON users.id = equipment.usersid
  LEFT JOIN knt ON knt.id = equipment.kntid WHERE equipment.orgid = :equipment_orgid  and equipment.util = :equipment_util and equipment.sale = :equipment_sale");
  $stmt->execute(array(':equipment_orgid' => $orid, ':equipment_util' => $util_eq, ':equipment_sale' => $sale_eq));
  $res1 = $stmt->fetchall();


  foreach($res1 as $row => $key) {
    if ($key['eqactive']=="1") {$active="active";} else {$active="not_active";};
    if ($key['eqrepair']=="1"){$active="repair";};
    if ($key['equtil']=="1"){$active="util";};
    if ($key['eqsale']=="1"){$active="sale";};
    if ($key['os']==1){$os=true;} else {$os=false;};
    if ($key['eqmode']==1){$eqmode=true;} else {$eqmode=false;};
    if ($key['eqbum']==1){$eqbum=true;} else {$eqbum=false;};
    if ($key['eqrepair']=="1") {$eqrepair=true;} else {$eqrepair=false;};
    $dtpost=MySQLDateToDate($key['datepost']);
    $dtendgar=MySQLDateToDate($key['dtendgar']);
    $fiopol=nameshort($key['fio']);
    $shtrih = ($key['shtrid'])."".(str_pad(($key['shtr_orgid']),3,'0',STR_PAD_LEFT))."".(str_pad(($key['shtr_id']),7,'0',STR_PAD_LEFT));

    $data = array($active,$key['eqid'],$key['placesname'],$key['nomename'],$key['grnome'],$key['vname'],$key['buhname'],$key['sernum'],$shtrih,$key['orgname'],$fiopol,$dtpost,$key['eqcomment'],$key['invnum'],$key['cost'],$key['currentcost'],$os,$eqmode,$eqbum,$eqrepair,$dtendgar,$key['kntname'],$key['invoice']);
    $output['aaData'][] = $data;
  }
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "eq_table_move"){
  if ($_POST['move_eqid'] != ''){
  $eqid = ($_POST['move_eqid']);
  $stmt = $dbConnection->prepare('SELECT mv.id as mvid, mv.eqid, nome.name,mv.nomeid,mv.dt, mv.orgname1, org.name AS orgname2, mv.place1, places.name AS place2, mv.user1, users.fio AS user2, mv.kntfrom, move.invoice as invoicefrom,move.comment as comment
            FROM move
            INNER JOIN (
            SELECT move.id, move.eqid, equipment.nomeid,move.dt AS dt, org.name AS orgname1, places.name AS place1, users.fio AS user1, knt.name as kntfrom
            FROM move
            INNER JOIN org ON org.id = orgidfrom
            INNER JOIN places ON places.id = placesidfrom
            INNER JOIN users ON users.id = useridfrom
            INNER JOIN equipment ON equipment.id = eqid
	    INNER JOIN knt ON knt.id = kntfrom
            ) AS mv ON move.id = mv.id
            INNER JOIN org ON org.id = move.orgidto
            INNER JOIN places ON places.id = placesidto
            INNER JOIN users ON users.id = useridto
            INNER JOIN nome ON nome.id = mv.nomeid WHERE move.eqid = :move_eqid');
            $stmt->execute(array(':move_eqid' => $eqid));
            $res1 = $stmt->fetchall();

            foreach($res1 as $row => $key) {
              $dt=MySQLDateTimeToDateTime($key['dt']);
              $user1 = nameshort($key["user1"]);
              $user2 = nameshort($key["user2"]);
              $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"move_edit\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"move_eq_delete\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";

              $data = array($key['mvid'],$dt,$key["orgname1"],$key["place1"],$user1,$key["kntfrom"],$key["invoicefrom"],$key["orgname2"],$key["place2"],$user2,$key["comment"],$act);
              $output['aaData'][] = $data;
            }
            if ($output != ''){
            echo json_encode($output);
          }else {
            $data = array('aaData'=>'');
            $output['aaData']=$data;
            echo json_encode($output);
          }
}
else {
  $data = array('aaData'=>'');
  $output['aaData']=$data;
  echo json_encode($output);
}
}
if ($mode == "eq_table_move_show_all"){
  $util_eq= $_COOKIE['cookie_eq_util'];
  $sale_eq= $_COOKIE['cookie_eq_sale'];

  $stmt = $dbConnection->prepare('SELECT mv.id as mvid, mv.eqid, nome.name,mv.nomeid,mv.dt, mv.orgname1, org.name AS orgname2, mv.place1, places.name AS place2, mv.user1, users.fio AS user2, mv.kntfrom, move.invoice as invoicefrom,move.comment as comment
            FROM move
            INNER JOIN (
            SELECT move.id, move.eqid, equipment.nomeid,move.dt AS dt, org.name AS orgname1, places.name AS place1, users.fio AS user1, knt.name as kntfrom
            FROM move
            INNER JOIN org ON org.id = orgidfrom
            INNER JOIN places ON places.id = placesidfrom
            INNER JOIN users ON users.id = useridfrom
            INNER JOIN equipment ON equipment.id = eqid
	          INNER JOIN knt ON knt.id = kntfrom WHERE equipment.util=:util_eq and equipment.sale=:sale_eq
            ) AS mv ON move.id = mv.id
            INNER JOIN org ON org.id = move.orgidto
            INNER JOIN places ON places.id = placesidto
            INNER JOIN users ON users.id = useridto
            INNER JOIN nome ON nome.id = mv.nomeid');
            $stmt->execute(array(':util_eq' => $util_eq, ':sale_eq' => $sale_eq));
            $res1 = $stmt->fetchall();

            foreach($res1 as $row => $key) {
              $dt=MySQLDateTimeToDateTime($key['dt']);
              $user1 = nameshort($key["user1"]);
              $user2 = nameshort($key["user2"]);
              $data = array($key['mvid'],$dt,$key["name"],$key["orgname1"],$key["place1"],$user1,$key["kntfrom"],$key["invoicefrom"],$key["orgname2"],$key["place2"],$user2,$key["comment"]);
              $output['aaData'][] = $data;
            }
            if ($output != ''){
            echo json_encode($output);
          }else {
            $data = array('aaData'=>'');
            $output['aaData']=$data;
            echo json_encode($output);
          }
}
if ($mode == "eq_table_repair"){
  if ($_POST['repair_eqid'] != ''){
  $eqid = ($_POST['repair_eqid']);
  $stmt = $dbConnection->prepare ('SELECT repair.id,repair.dt,repair.dtend,repair.kntid,knt.name,repair.cost,repair.comment,repair.status FROM repair INNER JOIN knt on knt.id=repair.kntid WHERE repair.eqid=:repair_eqid');
  $stmt->execute(array(':repair_eqid' => $eqid));
  $res1 = $stmt->fetchall();

  foreach($res1 as $row => $key) {
    $dt=MySQLDateToDate($key['dt']);
    $dtend=MySQLDateToDate($key['dtend']);
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"repair_edit\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"repair_eq_delete\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";

    if ($key["status"]=="1"){$st="Ремонт";} else {$st="Сделано";};
  $data = array($key["id"],$dt,$dtend,$key["name"],$key["cost"],$key["comment"],$st,$act);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "ven"){
  $groupid = $_POST['groupid'];
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  $morgs=GetArrayGroup_vendor($groupid);
  // echo var_dump($morgs);
  echo "<option value\"\"></option>";
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
      //if ($nid==$groupid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid>$nm</option>";
      };
}
if ($mode == "nome"){
  $vendorid = $_POST['vendorid'];
  $groupid = $_POST['groupid'];
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  $morgs=GetArrayVendor_nome($groupid,$vendorid);
  //echo var_dump($morgs);
  echo "<option value=\"\"></option>";
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
      //if ($nid==$vendorid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid>$nm</option>";
      };
}
if ($mode == "nome_lic"){
  $usersid = $_POST['usersid'];
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  $morgs=GetArrayNome_users($usersid);
  //echo var_dump($morgs);
  //echo "<option value=\"\"></option>";
  //echo "<option value=0>Отсутствует</option>";
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
      //if ($nid==$usersid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid>$nm</option>";
      };
}
if ($mode == "paramlist"){
  if ($_POST['id'] != ''){
  $eqid = ($_POST['id']);
  // $stmt = $dbConnection->prepare ('SELECT eq_param.id as pid,group_param.name as pname,eq_param.param as pparam FROM eq_param INNER JOIN group_param ON group_param.id=eq_param.paramid WHERE eqid= :eqid');
  $stmt = $dbConnection->prepare ('SELECT id,pname,param,comment FROM eq_param WHERE eqid= :eqid');
  $stmt->execute(array(':eqid' => $eqid));
  $res1 = $stmt->fetchall();

  foreach($res1 as $row => $key) {
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"param_edit\" class=\"btn btn-xs btn-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\"><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"param_del\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";

    $data = array($key["id"],$key["pname"],$key["param"],$key["comment"],$act);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
  }
if ($mode == "table_ping"){
  $orgid=$_POST['sorgid'];
  $userid=$_POST['suserid'];
  $placesid=$_POST['splaces'];
  // var_dump($userid);
  $where="";
  if ($userid!='') {$where=$where." and equipment.usersid=$userid";}
  if ($orgid!='') {$where=$where." and equipment.orgid=$orgid";}
  if ($placesid!='') {$where=$where." and equipment.placesid=$placesid";}

  $stmt = $dbConnection->prepare  ("SELECT places.name as pname,eq3.fio as fio,eq3.grname as grname,eq3.ip as ip,eq3.nomename as nomename FROM places INNER JOIN (SELECT users.fio as fio,eq2.placesid as placesid, eq2.grname as grname,eq2.ip as ip,eq2.nomename as nomename FROM users INNER JOIN (SELECT eq1.placesid as placesid,eq1.usersid as usersid,group_nome.name as grname,eq1.ip as ip,eq1.nomename as nomename FROM group_nome INNER JOIN (SELECT eq.placesid as placesid, eq.usersid as usersid,nome.groupid as groupid,eq.ip as ip,nome.name as nomename FROM nome INNER JOIN (SELECT equipment.placesid as placesid, equipment.usersid as usersid,equipment.nomeid as nomeid,equipment.ip as ip FROM equipment WHERE equipment.active=1 and equipment.util=0 and equipment.sale=0 and equipment.ip<>'' ".$where." ) as eq ON eq.nomeid=nome.id)  as eq1 ON eq1.groupid=group_nome.id) as eq2 ON eq2.usersid=users.id) as eq3 ON places.id=eq3.placesid");
  $stmt->execute();
  $res1 = $stmt->fetchall();
  foreach($res1 as $row => $key) {
    $ip = $key['ip'];
    $ip = vsprintf("%d.%d.%d.%d", explode(".", $ip));
 exec("ping $ip -c 1 -w 1 && exit", $output, $retval);
 if ($retval != 0){$res=false;} else {$res=true;};
  $data = array($res,$ip,$key["nomename"],$key["grname"],$key["pname"],$key["fio"]);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "eq_list"){
  $uid = $_SESSION['dilema_user_id'];

  $stmt = $dbConnection->prepare ("SELECT name as grname,res2.* FROM group_nome INNER JOIN (SELECT places.name as plname,res.* FROM places INNER JOIN(
                SELECT name AS namenome,nome.groupid as grpid, eq . *  FROM nome INNER JOIN(SELECT users.fio AS fio, fi . * FROM users INNER JOIN(SELECT org.name AS orgname, rg . * FROM org INNER JOIN ( SELECT shtr.id as shtrid, shtr.orgid as shtr_orgid, shtr.shtr_id as shtr_id, sh . * FROM shtr INNER JOIN(
                SELECT equipment.id AS eqid, equipment.placesid AS plid,equipment.usersid AS usid,equipment.orgid AS eqorgid,  equipment.nomeid AS nid, equipment.buhname AS bn, equipment.cost AS cs, equipment.currentcost AS curc, equipment.invnum, equipment.sernum, equipment.mode, equipment.os FROM equipment INNER JOIN (
                SELECT placesid FROM places_users WHERE userid =:userid) AS pl ON pl.placesid = equipment.placesid
                WHERE equipment.active =1 and equipment.util=0 and equipment.sale=0)
								AS sh ON shtr.eqid = sh.eqid)
		AS rg ON org.id=rg.eqorgid)
		AS fi ON users.id=fi.usid)
                AS eq ON nome.id = eq.nid)
                AS res ON places.id=res.plid)  AS res2 ON group_nome.id=res2.grpid");
                $stmt->execute(array(':userid' => $uid));
                $res1 = $stmt->fetchall();
                foreach($res1 as $row => $key) {
                  $fiopol=nameshort($key['fio']);
                  $shtrih = ($key['shtrid'])."".(str_pad(($key['shtr_orgid']),3,'0',STR_PAD_LEFT))."".(str_pad(($key['shtr_id']),7,'0',STR_PAD_LEFT));
                  $data = array($key['eqid'],$key['plname'],$key['namenome'],$key['grname'],$key['sernum'],$shtrih,$key['orgname'],$fiopol,$key['mode']);
                  $output['aaData'][] = $data;
                }
                  if ($output != ''){
                    echo json_encode($output);
                  }
                  else {
                    $data = array('aaData'=>'');
                    $output['aaData']=$data;
                    echo json_encode($output);
                  }
}
if ($mode == "invoice_show"){
  if (isset($_POST['query'])) {
    $query = $_POST['query'];
  $stmt = $dbConnection->prepare('SELECT invoice FROM equipment group by invoice');
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  $array  = array();
  foreach($res1 as $row) {

    $array[]=($row['invoice']);

  }
  echo json_encode($array);
  }
}
if ($mode == "license"){
  $util_eq= $_COOKIE['cookie_eq_util'];
  $sale_eq= $_COOKIE['cookie_eq_sale'];

  $stmt = $dbConnection->prepare ("SELECT license.id as licenseid,license.system as system, license.office as office,license.antiname as antiname,license.antivirus as antivirus,license.visio as visio,license.adobe as adobe,license.lingvo as lingvo,license.winrar as winrar,license.visual as visual,users.fio as fio,license.comment as comment,license.active as active,nome.name as nomename, orgg.orgname as orname,orgg.orgid as orggid, orgg2.name as organti, orgg.anti_col as anti_col FROM license INNER JOIN(SELECT equipment.orgid as eqorgid, org.name as orgname, org.antivirus_col as anti_col, org.id as orgid, equipment.usersid as equsersid, equipment.id as eqid, equipment.nomeid as eqnomeid FROM equipment INNER JOIN org ON org.id = equipment.orgid  WHERE equipment.util=:util_eq and equipment.sale=:sale_eq) AS orgg ON orgg.equsersid = license.usersid and orgg.eqid = license.eqid INNER JOIN users ON license.usersid=users.id INNER JOIN nome ON orgg.eqnomeid = nome.id LEFT JOIN org as orgg2 ON orgg2.id = license.organti  GROUP BY license.id");
  $stmt->execute(array(':util_eq' => $util_eq, ':sale_eq' => $sale_eq));
  $res1 = $stmt->fetchAll();

  foreach($res1 as $row => $key) {

	    $fiopol=nameshort($key['fio']);
	    switch($key["system"]){
		case 0: $sys="";
			break;
		case 1: $sys="Windows XP Professional";
			break;
		case 2: $sys="Windows 7 Professional";
			break;
		case 3: $sys="Windows 7 Home Basic";
			break;
		case 4: $sys="Windows XP Home";
			break;
		case 5: $sys="Windows 8 Single Language";
			break;
		case 6: $sys="Windows 8.1 Professional";
			break;
		case 7: $sys="Windows 8.1 Single Language";
			break;
    case 8: $sys="Windows 10 Single Language";
  		break;
    case 9: $sys="Windows 10 Home Single Language";
    	break;
	    };
	    switch($key["office"]){
		case 0: $off="";
			break;
		case 1: $off="Microsoft Office 2007";
			break;
		case 2: $off="Microsoft Office 2010";
			break;
		case 3: $off="Microsoft Office 2013";
			break;
    case 4: $off="Microsoft Office 2016";
			break;
	    };
		$antinames = array("0" => "", "1" => "Dr.Web", "2" => "Касперский");

	    $antivirus=MySQLDateToDate($key['antivirus']);
		if ($antivirus == "00.00.0000"){
      $antivir = "";
		}
		else {
				$antivir = $antivirus;
		}

    $stmt = $dbConnection->prepare ("SELECT license.organti, license.antiname, equipment.util, equipment.sale, Count(*) as count FROM license INNER JOIN equipment ON equipment.id = license.eqid WHERE license.antiname IN (1,2) and license.organti =:organti and equipment.util=0 and equipment.sale=0 Group by license.antiname,license.organti");
    $stmt->execute(array(':organti' => $key['orggid']));

    $res1 = $stmt->fetchAll();
    // $counts = array();
    $counts_str = "";
    foreach($res1 as $row) {
    $licid = $row['antiname'];
    // if (!array_key_exists($counts[$licid], $counts)) {
      $counts_str = $counts_str."".$antinames[$licid]." = ".$row['count']."; ";
    // }
  }
  $stmt = $dbConnection->prepare ("SELECT Count(*) as count,orgg.orgid as orggid FROM license INNER JOIN(SELECT equipment.orgid as eqorgid, org.id as orgid, equipment.id as eqid FROM equipment INNER JOIN org ON org.id = equipment.orgid WHERE org.id = :orgid and equipment.util=0 and equipment.sale=0) AS orgg ON  orgg.eqid = license.eqid GROUP BY orggid");
  $stmt->execute(array(':orgid' => $key['orggid']));

  $res1 = $stmt->fetchAll();
  foreach($res1 as $row) {
    $total_count = $row['count'];
}
  if (($key['anti_col'] != "") && ($counts_str != "")){
      $or = $key['orname']." <b>".get_lang('Totale_position')." - ".$total_count."</b><br><font color=\"red\">(".get_lang('Amount_license')." ".$key['anti_col'].")</font> ".get_lang('Totale_install').": ".$counts_str;
    }
  else if (($counts_str != "") && ($key['anti_col'] == "")) {
    $or = $key['orname']." <b>".get_lang('Totale_position')." - ".$total_count."</b><br>".get_lang('Totale_install').": ".$counts_str;
    }
    else if (($counts_str == "") && ($key['anti_col'] != "")) {
            $or = $key['orname']." <b>".get_lang('Totale_position')." - ".$total_count."</b><br><font color=\"red\">(".get_lang('Amount_license')." ".$key['anti_col'].")</font> ";
      }
  else {
    $or = $key['orname']." <b>".get_lang('Totale_position')." - ".$total_count."</b>";
  }


		$data = array($or,$key['licenseid'],$fiopol,$key['orname'],$key['nomename'],$sys,$off,$key['organti'],$antinames[$key['antiname']],$antivir,$key['visio'],$key['adobe'],$key['lingvo'],$key['winrar'],$key['visual'],$key['comment']);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
  }
if ($mode == "dialog_repair_edit"){
  $id=$_POST["id"];
      $stmt = $dbConnection->prepare ('SELECT repair.dt,repair.dtend,repair.kntid,repair.cost,repair.comment,repair.status FROM repair INNER JOIN knt on knt.id=repair.kntid WHERE repair.id=:id');
      $stmt->execute(array(':id' => $id));
      $res1 = $stmt->fetchall();

      foreach($res1 as $row) {
        $status = $row['status'];
        $kntid = $row['kntid'];
        $cst = $row['cost'];
        $dt = MySQLDateToDate($row["dt"]);
        $comment = $row['comment'];
        $dtend = MySQLDateToDate($row["dtend"]);

      }
  ?>
  <form id="myForm_repair_edit" class="well" method="post">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group" id="knt_grp" style="display:inline;">
     <label class="control-label"><small>Кто ремонтирует:</small></label>
   </div>
     <div id="kntid_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
     <select data-placeholder="Выберите организацию" class='my_select select' name="kntid" id="kntid">
     <option value=""></option>
     <?php
         $morgs=GetArrayKnt();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
             if ($nid==$kntid){$sl=" selected";} else {$sl="";};
             echo "<option value=$nid $sl>$nm</option>";
         };
     ?>
  </select>
</div>
</div>
  <div class="col-md-6">
    <label class="control-label"><small>Статус:</small></label>
        <select  class="my_select select" name="status" id="status">
             <option value="0" <?php if ($status == 0) echo 'selected="selected"'; ?>>Ремонт завершен</option>
             <option value="1" <?php if ($status == 1) echo 'selected="selected"'; ?>>В ремонте</option>
        </select>
   </div>
 </div>
 <div class="row">
   <div class="col-md-6">
   <label class="control-label"><small>Начало ремонта:</small></label>
   <input name="dt" id="dt" class="form-control input-sm allwidht" type="text" readonly='true' maxlength="10" value="<?php echo "$dt"; ?>">
</div>
<div class="col-md-6">
<label class="control-label"><small>Конец ремонта:</small></label>
<input name="dtend" id="dtend" type="text" readonly='true' maxlength="10" class="form-control input-sm allwidht" value="<?php echo "$dtend"; ?>">
</div>
</div>
<div class="row">
<div class="col-md-6">
  <label class="control-label"><small>Стоимость ремонта:</small></label>
  <input class="form-control input-sm allwidht" name="cst" id="cst" type="text" value="<?php echo "$cst"; ?>">
 </div>
      </div>
      <label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
      <textarea class="form-control" name="comment" id="comment"><?php echo "$comment";?></textarea>

       <div class="center_submit">
          <button type="submit" id="equipment_repair_edit" class="btn btn-success"><?=get_lang('Edit');?></button>
       </div>
  </form>
  <?php
}
if ($mode == "dialog_move_edit"){
  $id=$_POST["id"];
      $stmt = $dbConnection->prepare ('SELECT comment FROM move WHERE id=:id');
      $stmt->execute(array(':id' => $id));
      $res1 = $stmt->fetchall();

      foreach($res1 as $row) {
        $comment = $row['comment'];
      }
?>
<form id="myForm_repair_edit" class="well" method="post">
<div class="row">
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
<textarea rows="5" class="form-control allwidht" name="comment" id="comment" placeholder="<?=get_lang('Comment_placeholder');?>"><?php echo "$comment";?></textarea>
</div>
 <div class="center_submit">
    <button type="submit" id="equipment_move_edit" class="btn btn-success"><?=get_lang('Edit');?></button>
 </div>
</form>
<?php
}
if ($mode == "dialog_repair"){
  $id=$_POST["id"];
  $stmt = $dbConnection->prepare ('SELECT COUNT(*) as count FROM repair where eqid = :id');
  $stmt->execute(array(':id'=> $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $count = $row['count'];
  // var_dump($count);
  if ($count > 0){
      $stmt = $dbConnection->prepare ('SELECT repair.dt,repair.dtend,repair.kntid,repair.cost,repair.comment,repair.status FROM repair INNER JOIN knt on knt.id=repair.kntid WHERE repair.eqid=:id and repair.status = 1');
      $stmt->execute(array(':id' => $id));
      $res1 = $stmt->fetchall();

      foreach($res1 as $row) {
        $status = $row['status'];
        $kntid = $row['kntid'];
        $cst = $row['cost'];
        $dt = MySQLDateToDate($row["dt"]);
        $comment = $row['comment'];
        $dtend = date("d.m.Y");
      }
  }
  else {
      $status = "-1";
      $kntid = "";
      $cst = "";
      $dt="";
      $comment="";
  }
  ?>
  <form id="myForm_repair" class="well" method="post">
  <div class="row">
         <div class="col-md-6">
           <div class="form-group" id="knt_grp" style="display:inline;">
          <label class="control-label"><small>Кто ремонтирует:</small></label>
        </div>
          <div id="kntid_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
          <select data-placeholder="Выберите организацию" class='my_select select' name="kntid" id="kntid">
          <option value=""></option>
          <?php
              $morgs=GetArrayKnt();
              for ($i = 0; $i < count($morgs); $i++) {
                  $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                  if ($nid==$kntid){$sl=" selected";} else {$sl="";};
                  echo "<option value=$nid $sl>$nm</option>";
              };
          ?>
       </select>
     </div>
</div>
  <div class="col-md-6">
    <label class="control-label"><small>Статус:</small></label>
    <?php
      if ($status == '1'){
        ?>
        <select  class="my_select select" name="status" id="status">
             <option value="0" <?php if ($status == 0) echo 'selected="selected"'; ?>>Ремонт завершен</option>
        </select>
        <?php
      }
      else
      {
        ?>
        <select  class="my_select select" name="status" id="status">
            <option value="1" <?php if ($status == 1) echo 'selected="selected"'; ?>>В ремонте</option>
        </select>
        <?php
      }
     ?>
   </div>
 </div>
 <div class="row">
   <div class="col-md-6">

    <div class="form-group" id="dt_grp" style="display:inline;">
   <label class="control-label"><small>Начало ремонта:</small></label>
   <input name="dt" id="dt" class="form-control input-sm allwidht" type="text" readonly='true' maxlength="10" data-toggle="popover" data-trigger="manual" data-container="body" data-html="true" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" value="<?php echo "$dt"; ?>" autocomplete="off">
 </div>
</div>
<?php
if ($status == '1'){
 ?>
<div class="col-md-6">
<label class="control-label"><small>Конец ремонта:</small></label>
<input name="dtend" id="dtend" type="text" readonly='true' maxlength="10" class="form-control input-sm" value="<?php echo "$dtend"; ?>">
</div>
<?php
}
 ?>
<div class="col-md-6">
  <label class="control-label"><small>Стоимость ремонта:</small></label>
  <input class="form-control input-sm allwidht" name="cst" id="cst" type="text" value="<?php echo "$cst"; ?>">
 </div>
      </div>
      <label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
      <textarea class="form-control" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"><?php echo "$comment";?></textarea>
      <?php
      if ($status == '1'){
       ?>
       <div class="center_submit">
          <button type="submit" id="equipment_repair" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Забрать из ремонта</button>
       </div>
       <?php
     }
     else {
        ?>
      <div class="center_submit">
         <button type="submit" id="equipment_repair" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Отдать в ремонт</button>
      </div>
      <?php
    }
       ?>
  </form>
  <?php
}
if ($mode == "dialog_copy"){
  $id=$_POST["id"];
  $tmptmc=new Tequipment;
  $tmptmc->GetById($id);

  $orgid=$tmptmc->orgid;
  $placesid=$tmptmc->placesid;
  $userid=$tmptmc->usersid;
  $buhname=$tmptmc->buhname;

  ?>
  <form id="myForm_copy" class="well"  method="post">
  <div class="row">
     <div class="col-md-6">
       <div class="form-group" id="org_copy_to" style="display:inline;">
        <label class="control-label"><small>Организация:</small></label>
      </div>
      <div id="org_copy" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title'); ?>">
            <select data-placeholder="Выберите организацию" class='my_select select' name="sorgid" id="sorgid" >
          <option value=""></option>
          <?php
          $morgs=GetArrayOrg();
          for ($i = 0; $i < count($morgs); $i++) {
              $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
              if ($nid==$orgid){$sl=" selected";} else {$sl="";};
              echo "<option value=$nid $sl>$nm</option>";
          };
          ?>
           </select>
         </div>
       </div>
         <div class="col-md-6">
           <div class="form-group" id="places_copy_to" style="display:inline;">
          <label class="control-label"><small>Помещение:</small></label>
        </div>
        <div id="places_copy" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title'); ?>">
          <select data-placeholder="Выберите помещение" class='my_select select' name="splaces" id="splaces">
              <option value=""></option>
              <?php
              $morgs=GetArrayPlaces();
              for ($i = 0; $i < count($morgs); $i++) {
                  $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                  if ($nid==$placesid){$sl=" selected";} else {$sl="";};
                  echo "<option value=$nid $sl>$nm</option>";
              };
              ?>
      </select>
          </div>
        </div>
        </div>
  <div class="row">
     <div class="col-md-6">
       <div class="form-group" id="mat_copy_to" style="display:inline;">
          <label class="control-label"><small>ФИО:</small></label>
        </div>
        <div id="mat_copy" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>">
       <select data-placeholder="Выберите Мат.отв." class='my_select select' name="suserid" id="suserid">
          <option value=""></option>
          <?php
          $morgs=GetArrayUsers();
          for ($i = 0; $i < count($morgs); $i++) {
              $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
              if ($nid==$userid){$sl=" selected";} else {$sl="";};
              echo "<option value=$nid $sl>$nm</option>";
          };
          ?>
      </select>
    </div>
  </div>
    <div class="col-md-6">
     <label class="control-label"><small>Имя по бухгалтерии:</small></label>
       <input class="form-control input-sm allwidht" name="buhname" id="buhname" type="text" value="<?php $buhname=htmlspecialchars($buhname);echo "$buhname";?>">
</div>
       </div>
       <div class="row">
    <div class="center_all">
  <label class="control-label"><small>Введите колличестов копий:</small></label>
      <input class="form-control input-sm" id="nomcopy" name="nomcopy" type="text" style="width:50px;margin: 0 auto;">
      </div>
        </div>
      <div class="center_submit">
      <button type="submit" id="equipment_copy" class="btn btn-primary"><?=get_lang('Copy');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_move"){
  $id=$_POST["id"];
  $tmptmc=new Tequipment;
  $tmptmc->GetById($id);

  $orgid=$tmptmc->orgid;
  $placesid=$tmptmc->placesid;
  $userid=$tmptmc->usersid;
  ?>
  <form id="myForm_move" class="well form-inline" onkeypress="return event.keyCode != 13;">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group" id="org_to" style="display:inline;">
      <label class="control-label"><small>Организация (куда):</small></label>
    </div>
    <div id="org_move" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title'); ?>">
      <select data-placeholder="Выберите организацию" class='my_select select' name="sorgid" id="sorgid">
       <option value=""></option>
      <?php
      $morgs=GetArrayOrg();
      for ($i = 0; $i < count($morgs); $i++) {
          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
          if ($nid==$orgid){$sl=" selected";} else {$sl="";};
          echo "<option value=$nid $sl>$nm</option>";
      };
      ?>
      </select>
    </div>
      <div class="form-group" id="places_to" style="display:inline;">
          <label class="control-label"><small>Помещение:</small></label>
        </div>
        <div id="places_move" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>">
          <select data-placeholder="Выберите помещение" class='my_select2 select' name="splaces" id="splaces">
           <option value=""></option>
        <?php
        $morgs=GetArrayPlaces();
        for ($i = 0; $i < count($morgs); $i++) {
            $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
            if ($nid==$placesid){$sl=" selected";} else {$sl="";};
            echo "<option value=$nid $sl>$nm</option>";
        };
        ?>
        </select>
      </div>
        <div class="form-group" id="mat_to" style="display:inline;">
          <label class="control-label"><small>ФИО:</small></label>
        </div>
        <div id="mat_move" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>">
          <select data-placeholder="Выберите Мат.отв." class='my_select2 select' name="suserid" id="suserid">
           <option value=""></option>
         <?php
         $morgs=GetArrayUsers();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
             if ($nid==$userid){$sl=" selected";} else {$sl="";};
             echo "<option value=$nid $sl>$nm</option>";
         };
         ?>
         </select>
       </div>
  </div>
    <div class="col-md-8">
      <label class="control-label"><small><?=get_lang('Comment');?>: </small></label>
      <textarea rows="5" class="form-control comment" id="comment" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment"></textarea>
    </div>
</div>
  <div class="center_submit">
  <button type="submit" id="equipment_move" class="btn btn-primary"><?=get_lang('Move');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_equipment_edit"){
    $id=$_POST["id"];
    // var_dump("$id");
    $stmt = $dbConnection->prepare("SELECT * FROM equipment WHERE id=:id;");
    $stmt->execute(array(':id' => $id));
    $res1 = $stmt->fetchAll();
    foreach($res1 as $myrow) {
     $dtpost=MySQLDateToDate($myrow["datepost"]);
     $dtendgar=MySQLDateToDate($myrow["dtendgar"]);
     $orgid=$myrow["orgid"];
     $placesid=$myrow["placesid"];
     $userid=$myrow["usersid"];
     $nomeid=$myrow["nomeid"];
     $buhname=$myrow["buhname"];
     $cost=$myrow["cost"];
     $currentcost=$myrow["currentcost"];
     $sernum=$myrow["sernum"];
     $invnum=$myrow["invnum"];
     $invoice=$myrow["invoice"];
     $os=$myrow["os"];
     $mode=$myrow["mode"];
     $bum=$myrow["bum"];
     $comment=$myrow["comment"];
    $ip=$myrow["ip"];
     $kntid=$myrow["kntid"];
     $photo=$myrow["photo"];
     $eq_util=$myrow["util"];
     $eq_sale=$myrow["sale"];
   }
   $stmt = $dbConnection->prepare('SELECT * FROM nome WHERE id= :nomeid;');
   $stmt->execute(array(':nomeid' => $nomeid));
   $res1 = $stmt->fetchAll();
   foreach($res1 as $myrow) {
    $vendorid=$myrow["vendorid"];
    $groupid=$myrow["groupid"];
     };
     $photo = $photo."?".time();
     $invoice_end = explode(" от ",$invoice);
  ?>
  <style>
  .typeahead {
    width: 91%;
    max-height: 200px;
    overflow-y: auto;
  }
  </style>
  <script type="text/javascript">
        var Equipment_img = "images/equipment/<?php echo "$photo";?>";
  </script>
  <form id="myForm_edit" class="well form-inline"  method="post" onkeypress="return event.keyCode != 13;">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group" id="dtpost_edit_grp" style="display:inline;">
      <label class="control-label"><small>Дата<font color="red">*</font>:</small></label>
      <p><input class="form-control input-sm allwidht" name=dtpost id="dtpost" readonly='true' type="text" maxlength="10" value="<?php echo "$dtpost"; ?>" data-toggle="popover" data-trigger="manual" data-container="body" data-html="true" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off"></p>
  </div>
      <label class="control-label"><small>Орг./Помещение/Мат.Отв.<font color="red">*</font>:</small></label>
          <select data-placeholder="Выберите организацию" class='my_select select' disabled="disabled" name="sorgid" id="sorgid">
           <option value=""></option>
          <?php
          $morgs=GetArrayOrg();
          for ($i = 0; $i < count($morgs); $i++) {
              $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
              if ($nid==$orgid){$sl=" selected";} else {$sl="";};
              echo "<option value=$nid $sl>$nm</option>";
          };
          ?>
          </select>
          <select data-placeholder="Выберите помещение" class='my_select2 select' disabled="disabled" name="splaces" id="splaces">
           <option value=""></option>
        <?php
        $morgs=GetArrayPlaces();
        for ($i = 0; $i < count($morgs); $i++) {
            $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
            if ($nid==$placesid){$sl=" selected";} else {$sl="";};
            echo "<option value=$nid $sl>$nm</option>";
        };
        ?>
        </select>
        <select data-placeholder="Выберите Мат.отв." class='my_select2 select' disabled="disabled" name="suserid" id="suserid">
         <option value=""></option>
       <?php
       $morgs=GetArrayUsers();
       for ($i = 0; $i < count($morgs); $i++) {
           $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
           if ($nid==$userid){$sl=" selected";} else {$sl="";};
           echo "<option value=$nid $sl>$nm</option>";
       };
       ?>
       </select>
       <p></p>
      <label class="control-label"><small>Серийный номер:</small></label>
      <input class="form-control input-sm allwidht" name="sernum" id="sernum" type="text" style="text-transform: uppercase;" value="<?php echo "$sernum";?>">
      <div class="form-group" id="ip_grp" style="display:inline;">
      <label class="control-label"><small>Статический IP:</small></label>
      <input class="form-control input-sm allwidht" name=ip id=ip type="text" value="<?php echo "$ip"; ?>">
    </div>
  </div>
  <div class="col-md-4">

  <label class="control-label"><small>Поставщик:</small></label>

  <p><select data-placeholder="Выберите поставщика" class='my_select select' name=kntid id=kntid>
  <option value=""></option>
           <?php
               $morgs=GetArrayKnt();
               for ($i = 0; $i < count($morgs); $i++) {
                   $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                   if ($nid==$kntid){$sl=" selected";} else {$sl="";};
                   echo "<option value=$nid $sl>$nm</option>";
               };
           ?>
  </select></p>
  <div class="form-group" id="what" style="display:inline;">
  <label class="control-label"><small>Что<font color="red">*</font>:</small></label>
  </div>
  <div id="sgroupname_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
  <select data-placeholder="Выберите группу" class="my_select select" name="sgroupname" id="sgroupname">
  <option value=""></option>
  <?php
                $morgs=GetArrayGroup();
                for ($i = 0; $i < count($morgs); $i++) {
                    $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                    if ($nid==$groupid){$sl=" selected";} else {$sl="";};
                    echo "<option value=$nid $sl>$nm</option>";
                };
            ?>
  </select>
  </div>
  <div id="svendid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title_select'); ?>">
  <select data-placeholder="Выберите производителя" class="my_select2 select" name=svendid id=svendid>
        <option value=""></option>
             <?php
                $morgs=GetArrayGroup_vendor($groupid);
                for ($i = 0; $i < count($morgs); $i++) {
                    $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                    if ($nid==$vendorid){$sl=" selected";} else {$sl="";};
                    echo "<option value=$nid $sl>$nm</option>";
                };
            ?>
  </select>
  </div>
  <div id="snomeid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
  <select data-placeholder="Выберите номенклатуру" class="my_select2 select" name="snomeid" id="snomeid">
        <option value=""></option>
            <?php
                $morgs=GetArrayVendor_nome($groupid,$vendorid);
                for ($i = 0; $i < count($morgs); $i++) {
                    $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                    if ($nid==$nomeid){$sl=" selected";} else {$sl="";};
                    echo "<option value=$nid $sl>$nm</option>";
                };
             ?>
  </select>
  </div>
  <p></p>
  <label class="control-label"><small>Старый Штрихкод: </small></label>
  <p><input class="form-control input-sm allwidht" id=invnum name=invnum type="text" value="<?php echo "$invnum";?>"></p>
  <label class="checkbox-inline">
    <input type="checkbox" name="os" id="os"  <?php if ($os=="1") {echo "checked";};?>><b><small>Основные ср-ва</small></b>
  </label><br>
  <label class="checkbox-inline">
    <input type="checkbox" name="bum" id="bum"  <?php if ($bum=="1") {echo "checked";};?>><b><small>На Бумаге</small></b>
  </label>

  </div>

  <div class="col-md-4">
  <label class="control-label"><small>Гарантия до:</small></label><br>
  <input class="form-control input-sm allwidht" name=dtendgar id=dtendgar type="text" maxlength="10" value="<?php echo "$dtendgar"; ?>">
  <label class="control-label"><small>Имя по бухгалтерии:</small></label>
  <input class="form-control input-sm allwidht" name=buhname id=buhname type="text" value="<?php $buhname=htmlspecialchars($buhname);echo "$buhname";?>">
  <input class="form-control input-sm allwidht"  name="cost" id="cost" type="text" value="<?php echo "$cost";?>"placeholder="Начальная стоимость"   >
  <input class="form-control input-sm allwidht" name="currentcost" id="currentcost" type="text" value="<?php echo "$currentcost";?>" placeholder="Текущая стоимость">
  <label class="control-label"><small>Номер накладной: </small></label>
  <!-- <input class="form-control input-sm allwidht" id=invoice name=invoice type="text" value="<?php echo "$invoice";?>" placeholder="РкТ-123 от 04.02.2016"> -->
  <div class="invoice">
  <input class="form-control input-sm col-md-2" id="invoice" style="width:66%;" name="invoice" type="text" data-provide="typeahead" autocomplete="off" placeholder="Номер накладной" value="<?php echo "$invoice_end[0]";?>"><b><small style="float:left;line-height:2.5">от</small></b>
  <input class="form-control input-sm col-md-2" id="invoice_date" readonly='true' maxlength="10" style="width:29%;" name="invoice_date" type="text" autocomplete="off" placeholder="Дата" value="<?php echo "$invoice_end[1]";?>">
</div>
  <label class="checkbox-inline">
  <input type="checkbox" name="mode" id="mode_eq"  <?php if ($mode=="1") {echo "checked";};?>><b><small>Списано</small></b>
</label><br>
  <label class="checkbox-inline">
  <input type="checkbox" name="eq_util" id="eq_util" value="<?php echo $eq_util?>"  <?php if ($eq_util=="1") {echo "checked";};?>><b><small>Утилизировано</small></b>
</label><br>
  <label class="checkbox-inline">
    <input type="checkbox" name="eq_sale" id="eq_sale" value="<?php echo $eq_sale?>"  <?php if ($eq_sale=="1") {echo "checked";};?>><b><small>Продано</small></b>
  </label>
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-4">
    <div id="img_show" class="center_all">
      <img src="images/equipment/<?php echo $photo?>" style="border-radius:10px; border:1px solid #aaa;">
      <div style="margin-top:5px;">
        <div class="btn-group">
      <button class="btn btn-primary" type="button" id="ch_img" style="width: 225px;">Сменить</button>
      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li style="width: 248px;" class="center_all"><a href="#" id="img_del_equipment"><?=get_lang('Delete');?></a></li>
      </ul>
    </div>
    </div>
    </div>
  <div id="change_img">
    <div class="imageBox2">
      <div class="thumbBox2"></div>
      <div class="spinner2" style="display: none">Loading...</div>
    </div>
    <div class="action2">
      <input type="file" id="file">
      <div class="btn-group btn-group-justified">
        <div class="btn-group">
          <button type="button" class="btn btn-primary" id="btn_file" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_upload');?>"><i class="fa fa-upload" aria-hidden="true"></i>
    </div>
    <div class="btn-group">
      <button class="btn btn-primary" type="button" id="btnZoomIn" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomin');?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
    <div class="btn-group">
      <button class="btn btn-primary" type="button" id="btnZoomOut" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomout');?>"><i class="fa fa-minus" aria-hidden="true"></i></button>
    </div>
    <div class="btn-group">
      <button class="btn btn-primary" type="button" id="btnRotate" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_rotate');?>"><i class="fa fa-rotate-right" aria-hidden="true"></i></button>
    </div>
    </div>
  </div>
    </div>
  </div>
  <div class="col-md-8">
  <textarea class="form-control comment" id="comment" name="comment" placeholder="<?=get_lang('Comment_placeholder');?>"  rows="14"><?php echo "$comment";?></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="equipment_edit" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_equipment_add"){
  ?>
  <style>
  .typeahead {
    width: 91%;
    max-height: 200px;
    overflow-y: auto;
  }
  </style>
  <script type="text/javascript">
        var Equipment_img = "images/equipment/noimage.png";
  </script>
  <form id="myForm_add" class="well form-inline" onkeypress="return event.keyCode != 13;">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group" id="dtpost_add_grp" style="display:inline;">
      <label class="control-label"><small>Дата<font color="red">*</font>:</small></label>
      <p><input class="form-control input-sm allwidht" name="dtpost" id="dtpost" readonly='true' maxlength="10" type="text" value="<?php echo "$dtpost"; ?>"  data-toggle="popover" data-trigger="manual" data-container="body" data-html="true" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off"></p>
  </div>
  <div class="form-group" id="org_places_user" style="display:inline;">
      <label class="control-label"><small>Орг./Помещение/Мат.Отв.<font color="red">*</font>:</small></label>
    </div>
      <div id="sorgid_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
          <select data-placeholder="Выберите организацию" class='my_select select' name="sorgid" id="sorgid">
           <option value=""></option>
          <?php
                 $morgs=GetArrayOrg();
                 for ($i = 0; $i < count($morgs); $i++) {
                     $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                     if ($nid==$orgid){$sl=" selected";} else {$sl="";};
                     echo "<option value=$nid $sl>$nm</option>";
                 };
          ?>
          </select>
        </div>
  <div id="splaces_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title_select'); ?>">
          <select data-placeholder="Выберите помещение" class='my_select2 select' name="splaces" id="splaces">
           <option value=""></option>
        <?php
               $morgs=GetArrayPlaces();
               for ($i = 0; $i < count($morgs); $i++) {
                   $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                   if ($nid==$placesid){$sl=" selected";} else {$sl="";};
                   echo "<option value=$nid $sl>$nm</option>";
               };
        ?>
        </select>
      </div>
  <div id="suserid_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
        <select data-placeholder="Выберите Мат.отв." class='my_select2 select' name="suserid" id="suserid">
         <option value=""></option>
       <?php
          $morgs=GetArrayUsers();
          for ($i = 0; $i < count($morgs); $i++) {
              $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
              if ($nid==$userid){$sl=" selected";} else {$sl="";};
              echo "<option value=$nid $sl>$nm</option>";
          };
       ?>
       </select>
       <p></p>
     </div>
      <label class="control-label"><small>Серийный номер:</small></label>
      <input class="form-control input-sm allwidht" name="sernum" id="sernum" type="text" style="text-transform: uppercase;" value="<?php echo "$sernum";?>">
      <div class="form-group" id="ip_grp" style="display:inline;">
      <label class="control-label"><small>Статический IP:</small></label>
      <input class="form-control input-sm allwidht" name="ip" id="ip" type="text" value="<?php echo "$ip"; ?>">
    </div>
    </div>
  <div class="col-md-4">

  <label class="control-label"><small>Поставщик:</small></label>

  <p><select data-placeholder="Выберите поставщика" class='my_select select' name="kntid" id="kntid">
  <option value=""></option>
           <?php
               $morgs=GetArrayKnt();
               for ($i = 0; $i < count($morgs); $i++) {
                   $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                   if ($nid==$kntid){$sl=" selected";} else {$sl="";};
                   echo "<option value=$nid $sl>$nm</option>";
               };
           ?>
  </select></p>
  <div class="form-group" id="what" style="display:inline;">
  <label class="control-label"><small>Что<font color="red">*</font>:</small></label>
  </div>
  <div id="sgroupname_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
  <select data-placeholder="Выберите группу" class="my_select select" name="sgroupname" id="sgroupname">
  <option value=""></option>
  <?php
                $morgs=GetArrayGroup();
                for ($i = 0; $i < count($morgs); $i++) {
                    $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                    if ($nid==$groupid){$sl=" selected";} else {$sl="";};
                    echo "<option value=$nid $sl>$nm</option>";
                };
            ?>
  </select>
  </div>
  <div id="svendid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title_select'); ?>">
  <select data-placeholder="Выберите производителя" class="my_select2 select" name="svendid" id="svendid">
        <option value=""></option>
             <?php
                $morgs=GetArrayGroup_vendor($groupid);
                for ($i = 0; $i < count($morgs); $i++) {
                    $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                    if ($nid==$vendorid){$sl=" selected";} else {$sl="";};
                    echo "<option value=$nid $sl>$nm</option>";
                };
            ?>
  </select>
  </div>
  <div id="snomeid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
  <select data-placeholder="Выберите номенклатуру" class="my_select2 select" name="snomeid" id="snomeid">
        <option value=""></option>
            <?php
                $morgs=GetArrayVendor_nome($groupid,$vendorid);
                for ($i = 0; $i < count($morgs); $i++) {
                    $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                    if ($nid==$nomeid){$sl=" selected";} else {$sl="";};
                    echo "<option value=$nid $sl>$nm</option>";
                };
           ?>
  </select>
  </div>
  <p></p>
  <label class="control-label"><small>Старый Штрихкод: </small></label>
  <p><input class="form-control input-sm allwidht" id="invnum" name="invnum" type="text"></p>
  <label class="checkbox-inline">
    <input type="checkbox" name="os" id="os"><b><small>Основные ср-ва</small></b>
  </label><br>
  <label class="checkbox-inline">
    <input type="checkbox" name="bum" id="bum"><b><small>На Бумаге</small></b>
  </label>

  </div>

  <div class="col-md-4">
  <label class="control-label"><small>Гарантия до:</small></label><br>
  <input class="form-control input-sm allwidht" name="dtendgar" id="dtendgar" type="text" maxlength="10">
  <label class="control-label"><small>Имя по бухгалтерии:</small></label>
  <input class="form-control input-sm allwidht" name="buhname" id="buhname" type="text">
  <input class="form-control input-sm allwidht"  name="cost" id="cost" type="text" placeholder="Начальная стоимость"   >
  <input class="form-control input-sm allwidht" name="currentcost" id="currentcost" type="text" placeholder="Текущая стоимость">
  <label class="control-label"><small>Номер накладной: </small></label>
  <!-- <input class="form-control input-sm allwidht" id="invoice" name="invoice" type="text" data-provide="typeahead" autocomplete="off" placeholder="РкТ-123 от 04.02.2016"> -->
  <div class="invoice">
  <input class="form-control input-sm col-md-2" id="invoice" style="width:65%;" name="invoice" type="text" data-provide="typeahead" autocomplete="off" placeholder="Номер накладной"><b><small style="float:left;line-height:2.5">от</small></b>
  <input class="form-control input-sm col-md-2" id="invoice_date" readonly='true' maxlength="10" style="width:30%;" name="invoice_date" type="text" autocomplete="off" placeholder="Дата">
  </div>
  <label class="checkbox-inline">
  <input type="checkbox" name="mode_eq" id="mode_eq"><b><small>Списано</small></b>
</label><br>
  <label class="checkbox-inline">
  <input type="checkbox" name="eq_util" id="eq_util"><b><small>Утилизировано</small></b>
</label><br>
  <label class="checkbox-inline">
  <input type="checkbox" name="eq_sale" id="eq_sale"><b><small>Продано</small></b>
  </label>
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-4">
    <div id="img_show" class="center_all">
      <img src="images/equipment/noimage.png" style="border-radius:10px; border:1px solid #aaa;">
      <div style="margin-top:10px;">
      <button class="btn btn-primary" type="button" id="ch_img" style="width: 240px;">Сменить</button>
    </div>
    </div>
  <div id="change_img">
    <div class="imageBox2">
      <div class="thumbBox2"></div>
      <div class="spinner2" style="display: none">Loading...</div>
    </div>
    <div class="action2">
      <input type="file" id="file">
      <div class="btn-group btn-group-justified">
        <div class="btn-group">
          <button type="button" class="btn btn-primary" id="btn_file" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_upload');?>"><i class="fa fa-upload" aria-hidden="true"></i>
    </div>
    <div class="btn-group">
      <button class="btn btn-primary" type="button" id="btnZoomIn" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomin');?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
    <div class="btn-group">
      <button class="btn btn-primary" type="button" id="btnZoomOut" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomout');?>"><i class="fa fa-minus" aria-hidden="true"></i></button>
    </div>
    <div class="btn-group">
      <button class="btn btn-primary" type="button" id="btnRotate" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_rotate');?>"><i class="fa fa-rotate-right" aria-hidden="true"></i></button>
    </div>
    </div>
  </div>
    </div>
  </div>
  <div class="col-md-8">
  <textarea class="form-control comment" name="comment" id="comment" placeholder="<?=get_lang('Comment_placeholder');?>" rows="14"><?php echo "$comment";?></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="equipment_add" class="btn btn-success"><?=get_lang('Add');?></button>
  </div>
  </form>

  <?php
}
if ($mode == "dialog_license_add"){
  ?>
  <form id='myForm_license_add' class="well form-inline"  method="post">
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="usersid_li_add_grp" style="display:inline;">
   <label class="control-label"><small>Мат.отв.:</small></label>
 </div>
 <div id="usersid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите Мат.отв." class='my_select select' name="usersid" id="usersid">
  	<option value=""></option>
  <?php
                      $morgs=GetArrayUsers();
                      for ($i = 0; $i < count($morgs); $i++) {
                          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
                          if ($nid==$usersid){$sl=" selected";} else {$sl="";};
                          echo "<option value=$nid $sl>$nm</option>";
                      };
                  ?>
   </select>
 </div>
 </div>
   <div class="col-md-6">
     <div class="form-group" id="eqid_li_add_grp" style="display:inline;">
    <label class="control-label"><small>Устройство:</small></label>
  </div>
  <div id="eqid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите устройство" class='my_select select' name="eqid" id="eqid">
  	<option value=""></option>
  <?php
                      $morgs=GetArrayNome_users($usersid);
  		    //echo var_dump($morgs);
  		    //echo "<option value=0>Отсутствует</option>";
                      for ($i = 0; $i < count($morgs); $i++) {
                          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                          if ($nid==$eqid){$sl=" selected";} else {$sl="";};
                          echo "<option value=$nid $sl>$nm</option>";
                      };
                  ?>
   </select>
   </div>
 </div>
 </div><br>
 <div class="row">
  <div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="visio" id="visio" ><b><small>Visio</small></b>
  </label>
</div>
  <div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="lingvo" id="lingvo" ><b><small>Lingvo</small></b>
  </label>
</div>
<div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="winrar" id="winrar" ><b><small>Winrar</small></b>
  </label>
</div>
</div><br>
<div class="row">
<div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="adobe" id="adobe" ><b><small>Adobe Finereader</small></b>
    </label>
  </div>
  <div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="visual" id="visual" ><b><small>Visual Studio</small></b>
      </label>
  </div>
</div><br>
  <div class="row">
  <div class="col-md-6">
  <label class="control-label"><small>Операционная система:</small></label>
  <select data-placeholder="Выберите операционную систему" class='my_select select' name="system" id="system">
  	<option value=""></option>
       <option value="1">Windows XP Professional</option>
       <option value="2">Windows 7 Professional</option>
       <option value="3">Windows 7 Home Basic</option>
       <option value="4">Windows XP Home</option>
       <option value="5">Windows 8 Single Language</option>
       <option value="6">Windows 8.1 Professional</option>
       <option value="7">Windows 8.1 Single Language</option>
       <option value="8">Windows 10 Single Language</option>
       <option value="9">Windows 10 Home Single Language</option>
      </select>
  </div>
  <div class="col-md-6">
  <label class="control-label"><small>Офис:</small></label>
  <select data-placeholder="Выберите офис" class='my_select select' name="office" id="office">
  	<option value=""></option>
       <option value="1">Microsoft Office 2007</option>
       <option value="2">Microsoft Office 2010</option>
       <option value="3">Microsoft Office 2013</option>
       <option value="4">Microsoft Office 2016</option>
      </select>
  </div>
  </div>
  <br>
  <div class="row">
  	<div class="col-md-6">
  		<label class="control-label"><small>Чей антивирус установлен:</small></label>
      <select data-placeholder="Выберите организацию" class='my_select select' name="organti" id="organti">
       <option value=""></option>
      <?php
      $morgs=GetArrayOrg();
      for ($i = 0; $i < count($morgs); $i++) {
          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
          if ($nid==$organti){$sl=" selected";} else {$sl="";};
          echo "<option value=$nid $sl>$nm</option>";
      };
      ?>
      </select>
  		</div>
  	<div class="col-md-6">
      <label class="control-label"><small>Наименование антивируса:</small></label>
      <select data-placeholder="Выберите антивирус" class='my_select select' name="antiname" id="antiname">
        <option value=""></option>
           <option value="1">Dr.Web</option>
           <option value="2">Касперский</option>
          </select>
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-12">
    <div class="center_all">
    <label class="control-label" style="display:inline;"><small>Дата оконачания:</small></label>
    <input class="input-sm form-control" type="text" placeholder="Дата" name="antivirus" id="antivirus">
  </div>
  </div>
  	</div><br>
  	<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
  <textarea class="form-control allwidht" name="comment" id="comment"  rows="3" placeholder="<?=get_lang('Comment_placeholder');?>"></textarea>
   <div class="center_submit">
  	<button type="submit" id="license_add" class="btn btn-success"><?=get_lang('Add');?></button>
  	</div>
  </form>
  <?php
}
if ($mode == "dialog_license_edit") {
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT * FROM license WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow) {
$usersid=$myrow['usersid'];
$eqid=$myrow['eqid'];
$system=$myrow['system'];
$office=$myrow['office'];
$visio=$myrow['visio'];
$visual=$myrow['visual'];
$organti=$myrow['organti'];
$antiname=$myrow['antiname'];
$antivirus=MySQLDateToDate($myrow["antivirus"]);
$adobe=$myrow['adobe'];
$lingvo=$myrow['lingvo'];
$winrar=$myrow['winrar'];
$comment=$myrow['comment'];
};
  ?>
  <form id='myForm_license_edit' class="well form-inline"  method="post">
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="usersid_li_edit_grp" style="display:inline;">
   <label class="control-label"><small>Мат.отв.:</small></label>
 </div>
 <div id="usersid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите Мат.отв." class='my_select select' name="usersid" id="usersid">
  	<option value=""></option>
  <?php
                      $morgs=GetArrayUsers();
                      for ($i = 0; $i < count($morgs); $i++) {
                          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
                          if ($nid==$usersid){$sl=" selected";} else {$sl="";};
                          echo "<option value=$nid $sl>$nm</option>";
                      };
                  ?>
   </select>
 </div>
 </div>
   <div class="col-md-6">
     <div class="form-group" id="eqid_li_edit_grp" style="display:inline;">
    <label class="control-label"><small>Устройство:</small></label>
  </div>
    <div id="eqid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите устройство" class='my_select select' name="eqid" id="eqid">
  	<option value=""></option>
  <?php
                      $morgs=GetArrayNome_users($usersid);
  		    //echo var_dump($morgs);
  		    //echo "<option value=0>Отсутствует</option>";
                      for ($i = 0; $i < count($morgs); $i++) {
                          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                          if ($nid==$eqid){$sl=" selected";} else {$sl="";};
                          echo "<option value=$nid $sl>$nm</option>";
                      };
                  ?>
   </select>
   </div>
 </div>
 </div><br>
 <div class="row">
  <div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="visio" id="visio"  <?php if ($visio=="1") {echo "checked";};?>><b><small>Visio</small></b>
  </label>
</div>
  <div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="lingvo" id="lingvo"  <?php if ($lingvo=="1") {echo "checked";};?>><b><small>Lingvo</small></b>
  </label>
</div>
<div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="winrar" id="winrar"  <?php if ($winrar=="1") {echo "checked";};?>><b><small>Winrar</small></b>
  </label>
</div>
</div><br>
<div class="row">
<div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="adobe" id="adobe"  <?php if ($adobe=="1") {echo "checked";};?>><b><small>Adobe Finereader</small></b>
    </label>
  </div>
  <div class="col-md-4">
  <label class="checkbox-inline">
  <input type="checkbox" name="visual" id="visual"  <?php if ($visual=="1") {echo "checked";};?>><b><small>Visual Studio</small></b>
      </label>
  </div>
</div><br>
  <div class="row">
  <div class="col-md-6">
  <label class="control-label"><small>Операционная система:</small></label>
  <select data-placeholder="Выберите операционную систему" class='my_select select' name="system" id="system">
  	<option value=""></option>
       <option value="1" <?php if ($system == 1) echo 'selected="selected"'; ?>>Windows XP Professional</option>
       <option value="2" <?php if ($system == 2) echo 'selected="selected"'; ?>>Windows 7 Professional</option>
       <option value="3" <?php if ($system == 3) echo 'selected="selected"'; ?>>Windows 7 Home Basic</option>
       <option value="4" <?php if ($system == 4) echo 'selected="selected"'; ?>>Windows XP Home</option>
       <option value="5" <?php if ($system == 5) echo 'selected="selected"'; ?>>Windows 8 Single Language</option>
       <option value="6" <?php if ($system == 6) echo 'selected="selected"'; ?>>Windows 8.1 Professional</option>
       <option value="7" <?php if ($system == 7) echo 'selected="selected"'; ?>>Windows 8.1 Single Language</option>
       <option value="8" <?php if ($system == 8) echo 'selected="selected"'; ?>>Windows 10 Single Language</option>
       <option value="9" <?php if ($system == 8) echo 'selected="selected"'; ?>>Windows 10 Home Single Language</option>
      </select>
  </div>
  <div class="col-md-6">
  <label class="control-label"><small>Офис:</small></label>
  <select data-placeholder="Выберите офис" class='my_select select' name="office" id="office">
  	<option value=""></option>
       <option value="1" <?php if ($office == 1) echo 'selected="selected"'; ?>>Microsoft Office 2007</option>
       <option value="2" <?php if ($office == 2) echo 'selected="selected"'; ?>>Microsoft Office 2010</option>
       <option value="3" <?php if ($office == 3) echo 'selected="selected"'; ?>>Microsoft Office 2013</option>
       <option value="4" <?php if ($office == 4) echo 'selected="selected"'; ?>>Microsoft Office 2016</option>
      </select>
  </div>
  </div>
  <br>
  <div class="row">
  	<div class="col-md-6">
  		<label class="control-label"><small>Чей антивирус установлен:</small></label>
      <select data-placeholder="Выберите организацию" class='my_select select' name="organti" id="organti">
       <option value=""></option>
      <?php
      $morgs=GetArrayOrg();
      for ($i = 0; $i < count($morgs); $i++) {
          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
          if ($nid==$organti){$sl=" selected";} else {$sl="";};
          echo "<option value=$nid $sl>$nm</option>";
      };
      ?>
      </select>
  		</div>
  	<div class="col-md-6">
      <label class="control-label" style="display: inline;"><small>Наименование антивируса:</small></label>
      <select data-placeholder="Выберите антивирус" class='my_select select' name="antiname" id="antiname">
        <option value=""></option>
           <option value="1" <?php if ($antiname == 1) echo 'selected="selected"'; ?>>Dr.Web</option>
           <option value="2" <?php if ($antiname == 2) echo 'selected="selected"'; ?>>Касперский</option>
          </select>
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-12">
    <div class="center_all">
    <label class="control-label" style="display:inline-block;"><small>Дата оконачания:</small></label>
    <input class="input-sm form-control" type="text" placeholder="Дата" name="antivirus" id="antivirus" value="<?php echo "$antivirus";?>">
  </div>
  </div>
  	</div><br>
  	<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
  <textarea class="form-control allwidht" name="comment" id="comment"  rows="3" placeholder="<?=get_lang('Comment_placeholder');?>"><?php echo "$comment";?></textarea>
   <div class="center_submit">
  	<button type="submit" id="license_edit" class="btn btn-success"><?=get_lang('Edit');?></button>
  	</div>
  </form>
  <?php
}
if ($mode =="license_add"){
  $system= $_POST['system'];
  $office= $_POST['office'];
  $organti=$_POST['organti'];
  $antiname=$_POST['antiname'];
  $antivirus=DateToMySQLDateTime2($_POST['antivirus']);
  $comment= $_POST['comment'];
  $visio=($_POST['visio']);
  if ($visio == "true") {$visio=1;} else {$visio=0;}
  $adobe=($_POST['adobe']);
  if ($adobe == "true") {$adobe=1;} else {$adobe=0;}
  $lingvo=($_POST['lingvo']);
  if ($lingvo == "true") {$lingvo=1;} else {$lingvo=0;}
  $winrar=($_POST['winrar']);
  if ($winrar == "true") {$winrar=1;} else {$winrar=0;}
  $visual=($_POST['visual']);
  if ($visual == "true") {$visual=1;} else {$visual=0;}
      $usersid=$_POST["usersid"];
      $eqid=$_POST["eqid"];

  $stmt = $dbConnection->prepare ('INSERT INTO license (id,usersid,eqid,system,office,organti,antiname,antivirus,visio,adobe,lingvo,winrar,visual,comment,active) VALUES (NULL,:usersid,:eqid,:system,:office,:organti,:antiname,:antivirus,:visio,:adobe,:lingvo,:winrar,:visual,:comment,1)');
  $stmt->execute(array(
    ':usersid' => $usersid,
    ':eqid' => $eqid,
    ':system' => $system,
    ':office' => $office,
    ':organti' => $organti,
    ':antiname' => $antiname,
    ':antivirus' => $antivirus,
    ':visio' => $visio,
    ':adobe' => $adobe,
    ':lingvo' => $lingvo,
    ':winrar' => $winrar,
    ':visual' => $visual,
    ':comment' => $comment));
    echo "ok";
}
if ($mode == "license_edit"){
  $id = $_POST['id'];
  $system= $_POST['system'];
  $office= $_POST['office'];
  $organti=$_POST['organti'];
  $antiname=$_POST['antiname'];
  $antivirus=DateToMySQLDateTime2($_POST['antivirus']);
  $comment= $_POST['comment'];
  $visio=($_POST['visio']);
  if ($visio == "true") {$visio=1;} else {$visio=0;}
  $adobe=($_POST['adobe']);
  if ($adobe == "true") {$adobe=1;} else {$adobe=0;}
  $lingvo=($_POST['lingvo']);
  if ($lingvo == "true") {$lingvo=1;} else {$lingvo=0;}
  $winrar=($_POST['winrar']);
  if ($winrar == "true") {$winrar=1;} else {$winrar=0;}
  $visual=($_POST['visual']);
  if ($visual == "true") {$visual=1;} else {$visual=0;}
      $usersid=$_POST["usersid"];
      $eqid=$_POST["eqid"];

      $stmt = $dbConnection->prepare ('UPDATE license SET usersid=:usersid,eqid=:eqid,system=:system,office=:office,organti=:organti,antiname=:antiname,antivirus=:antivirus,visio=:visio,adobe=:adobe,lingvo=:lingvo,winrar=:winrar,visual=:visual,comment=:comment WHERE id=:id');
      $stmt->execute(array(
        ':usersid' => $usersid,
        ':eqid' => $eqid,
        ':system' => $system,
        ':office' => $office,
        ':organti' => $organti,
        ':antiname' => $antiname,
        ':antivirus' => $antivirus,
        ':visio' => $visio,
        ':adobe' => $adobe,
        ':lingvo' => $lingvo,
        ':winrar' => $winrar,
        ':visual' => $visual,
        ':comment' => $comment,
        ':id' => $id));
        echo "ok";
}
if ($mode == "license_delete"){
  $id = $_POST['id'];
  $id = explode(",",$id);
foreach ($id as $ids) {
  	$stmt = $dbConnection->prepare ('DELETE FROM license WHERE id =:id');
    $stmt->execute(array(':id' => $ids));
  }
  echo "ok";
}
if ($mode == "dialog_antivirus_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT * FROM license WHERE id= :id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow) {
$organti=$myrow['organti'];
$antiname=$myrow['antiname'];
$antivirus=MySQLDateToDate($myrow["antivirus"]);
};
?>
  <form id="myForm_anti_edit" class="well form-inline" method="post">
  <div class="row">
        <div class="col-md-6">
          <div class="form-group" id="organti_grp" style="display:inline;">
  	<label class="control-label"><small>Чей антивирус установлен:</small></label>
  </div>
  <div id="organti_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
      <select data-placeholder="Выберите организацию" class='my_select select' name="organti" id="organti">
       <option value=""></option>
      <?php
      $morgs=GetArrayOrg();
      for ($i = 0; $i < count($morgs); $i++) {
          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
          if ($nid==$organti){$sl=" selected";} else {$sl="";};
          echo "<option value=$nid $sl>$nm</option>";
      };
      ?>
      </select>
  	       </div>
              </div>
              <div class="col-md-6">
                <div class="form-group" id="antiname_grp" style="display:inline;">
                <label class="control-label"><small>Наименование антивируса:</small></label>
              </div>
              <div id="antiname_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
            <select data-placeholder="Выберите антивирус" class='my_select select' name="antiname" id="antiname">
            	<option value=""></option>
                 <option value="1" <?php if ($antiname == 1) echo 'selected="selected"'; ?>>Dr.Web</option>
                 <option value="2" <?php if ($antiname == 2) echo 'selected="selected"'; ?>>Касперский</option>
                </select>
              </div>
     </div>
   </div><br>
   <div class="row">
      <div class="col-md-12">
        <div class="center_all">
        <label class="control-label" style="display:inline-block;"><small>Дата оконачания:</small></label>
        <input class="input-sm form-control" type="text" placeholder="Дата" name="antivirus" id="antivirus" value="<?php echo "$antivirus";?>">
      </div>
  </div>
      </div>
  <div class="center_submit">
              <button type="submit" id="edit_anti" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "antivirus_edit"){
  $antivirus=DateToMySQLDateTime2($_POST["antivirus"]);
  $antiname=$_POST['antiname'];
  $organti=$_POST['organti'];
  $id = $_POST["id"];
  $id = explode(",",$id);
foreach ($id as $ids) {

  $stmt = $dbConnection->prepare ('UPDATE license SET organti=:organti, antiname=:antiname,antivirus=:antivirus WHERE id= :ids');
  $stmt->execute(array(':ids' => $ids, ':organti' => $organti, ':antiname' => $antiname, ':antivirus' => $antivirus));
}
echo "ok";
}
if ($mode == "dialog_license_col"){
?>
<form id="myForm_anti_edit" class="well form-inline" method="post">
<div class="row">
      <div class="col-md-8">
<div class="form-group" id="org_name_grp" style="display:inline;">
<label class="control-label"><small>Организация:</small></label>
</div>
<div id="org_name_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title_select'); ?>">
<select data-placeholder="Выберите организацию" class='my_select select' name="org_name" id="org_name">
 <option value=""></option>
<?php
$morgs=GetArrayOrg();
for ($i = 0; $i < count($morgs); $i++) {
    $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
    if ($nid==$organti){$sl=" selected";} else {$sl="";};
    echo "<option value=$nid $sl>$nm</option>";
};
?>
</select>
</div>
</div>
<div class="col-md-4">
<label class="control-label"><small>Кол-во лицензий:</small></label>
<input id="anti_col" placeholder="Введите кол-во" type="text" class="allwidht form-control input-sm">
</div>
</div>
<div class="center_submit">
            <button type="submit" id="edit_anti_col" class="btn btn-success"><?=get_lang('Edit');?></button>
</div>
</form>
<?php
}
if ($mode == "input_antivirus_col"){
    $id = $_POST["id"];
    $stmt = $dbConnection->prepare ("SELECT antivirus_col FROM org WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $col = $row['antivirus_col'];
    echo $col;
}
if ($mode == "antivirus_col_update"){
  $id = $_POST["id"];
  $antivirus_col = $_POST["antivirus_col"];
  $stmt = $dbConnection->prepare ('UPDATE org SET antivirus_col = :antivirus_col WHERE id = :id');
  $stmt->execute(array(':id' => $id, ':antivirus_col' => $antivirus_col));
}
if ($mode == "print_test"){
  $placesid=$_POST['splaces'];
  $userid=$_POST['suserid'];
  $where="";
  $what_print_test = get_conf_param('what_print_test');
  if ($placesid!='') {$where=$where." and equipment.placesid=$placesid";}
  if ($userid!='') {$where=$where." and equipment.usersid=$userid";}
  include_once 'inc/Printer.php';
  $stmt = $dbConnection->prepare ("SELECT places.name as pname,eq3.fio as fio,eq3.ip as ip,eq3.nomename as nomename FROM places INNER JOIN (SELECT users.fio as fio,eq2.placesid as placesid, eq2.ip as ip,eq2.nomename as nomename FROM users INNER JOIN (SELECT * FROM group_nome INNER JOIN (SELECT eq.placesid as placesid, eq.usersid as usersid,nome.groupid as groupid,eq.ip as ip,nome.name as nomename FROM nome INNER JOIN (SELECT equipment.placesid as placesid, equipment.usersid as usersid,equipment.nomeid as nomeid,equipment.ip as ip FROM equipment WHERE equipment.active=1 and equipment.util=0 and equipment.sale=0 and equipment.ip<>'' ".$where.") as eq ON eq.nomeid=nome.id)  as eq1 ON eq1.groupid=group_nome.id where eq1.groupid IN (".$what_print_test.")) as eq2 ON eq2.usersid=users.id) as eq3 ON places.id=eq3.placesid");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow => $key) {
    $ip = $key['ip'];
    $ip = vsprintf("%d.%d.%d.%d", explode(".", $ip));
    exec("ping $ip -c 1 -w 1 && exit", $output, $retval);
    if ($retval != 0){$res=false;} else {$res=true;};

    $nm=$key['nomename'];
    $pnm=$key['pname'];
    $fio=$key['fio'];
    try {
        $printer = new Kohut_SNMP_Printer($ip);
        if ($printer->isColorPrinter() == true ) {
        $ostatok_color = "<span style=\"background: cyan; color: black;\">Cyan Toner:</span> ".round($printer->getCyanTonerLevel(), 2)."%<br />
        <span style=\"background: magenta; color: white;\">Magenta Toner:</span> ".round($printer->getMagentaTonerLevel(), 2)."%<br />
        <span style=\"background: yellow; color: black;\">Yellow Toner:</span> ".round($printer->getYellowTonerLevel(), 2)."%<br />";
        }
        $ostatok = "<span style=\"background: black; color: white;\">Black Toner:</span> ".round($printer->getBlackTonerLevel(), 2)."%<br />".$ostatok_color;
          if ($printer->isColorPrinter() == true ) {
            $model = 'Цветная';
          }
          else if ($printer->isMonoPrinter() == true) {
            $model ='Черно-белая';
          }

          $color = $printer->getBlackCatridgeType()."".$printer->getBlackCatridgeType2()."<br />
                  ".$printer->getCyanCatridgeType()."<br />
                  ".$printer->getMagentaCatridgeType()."<br />
                  ".$printer->getYellowCatridgeType();


        $data = array($res, $ip, $nm,$model,$printer->getSerialNumber(),$color,$ostatok, $printer->getNumberOfPrintedPapers(),$pnm,$fio);
        $output['aaData'][] = $data;

    } catch(Kohut_SNMP_Exception $e) {
        echo 'SNMP Error: ' . $e->getMessage();
    }
     }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }

  }
if ($mode == "cartridge"){
  $stmt = $dbConnection->prepare ('SELECT print.id as printid,nome.name as nomename,org.name as orgname,places.name as plname,users.fio as fio,print.namek as namep,print.coll as coll,print.newk as newk,print.zapr as zapr,print.comment as comment,print.active as printactive FROM print  INNER JOIN nome ON print.nomeid=nome.id INNER JOIN org ON print.orgid=org.id INNER JOIN places ON print.placesid=places.id INNER JOIN users ON print.userid=users.id');
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow => $key) {
    if ($key['printactive']=="1") {$active="active";} else {$active="not_active";};
    $fiopol=nameshort($key['fio']);
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"fast_edit\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_fast_toggle')."\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"cart_delete\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";

  $data = array($active,$key['printid'],$key['nomename'],$key['namep'],$key['plname'],$key['orgname'],$fiopol,$key['coll'],$key['newk'],$key['zapr'],$key['comment'],$act);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "dialog_cartridge_add"){
  ?>
  <form id='myForm_cart_add' class="well form-inline"  method="post">
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="nomeid_add_grp" style="display:inline;">
  <label class="control-label"><small>Наименование оборудования:</small></label>
</div>
   <div id="nomeid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите оборудование" class='my_select select' name="nomeid" id="nomeid">
  	<option value=""></option>
  <?php
    $cartridge = get_conf_param('what_cartridge');
    $stmt= $dbConnection->prepare("SELECT * FROM nome WHERE active=1 and groupid IN (".$cartridge.") order by name;");
    $stmt->execute();
    $res1 = $stmt->fetchAll();
    foreach($res1 as $myrow)
      {$vl=$myrow['id'];
        echo "<option value=$vl";
        if ($myrow["id"]==$nomeid){echo " selected";};
        $nm=$myrow['name'];
        echo ">$nm</option>";
      };

  ?>
   </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group" id="placesid_add_grp" style="display:inline;">
   <label class="control-label"><small>Помещение:</small></label>
 </div>
    <div id="placesid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите помещение" class='my_select select' name="placesid" id="placesid">
  	<option value=""></option>
  <?php
  $morgs=GetArrayPlaces();
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
      if ($nid==$placesid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid $sl>$nm</option>";
  };
  ?>
   </select>
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="orgid_add_grp" style="display:inline;">
   <label class="control-label"><small>Организация:</small></label>
 </div>
    <div id="orgid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите организацию" class='my_select select' name="orgid" id="orgid">
  	<option value=""></option>
  <?php
  $morgs=GetArrayOrg();
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
      if ($nid==$orgid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid $sl>$nm</option>";
  };
  ?>
   </select>
    </div>
   </div>
  <div class="col-md-6">
    <div class="form-group" id="userid_add_grp" style="display:inline;">
   <label class="control-label"><small>Мат.отв.:</small></label>
 </div>
    <div id="userid_add_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите Мат.отв." class='my_select select' name="userid" id="userid">
  	<option value=""></option>
  <?php
  $morgs=GetArrayUsers();
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
      if ($nid==$userid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid $sl>$nm</option>";
  };
  ?>
   </select>
    </div>
   </div>
  </div>
  <div class="row">
  <div class="col-md-6">
  <label class="control-label"><small>Модель картриджа:</small></label>
  <input class="input-sm form-control allwidht" type="text" placeholder="Модель картриджа" name="namek" id="namek" value="<?php echo "$namek";?>">
  <label class="control-label"><small>Колличество:</small></label>
  <input class="input-sm form-control allwidht" type="text" placeholder="Кол-во" name="coll" id="coll" value="<?php echo "$coll";?>">
  </div>

  <div class="col-md-6">
    <div class="center_all">
      <br>
  <label class="checkbox-inline">
          <input type="checkbox" name="newk" id="newk"  <?php if ($newk=="1") {echo "checked";};?>><small>Новый</small>
  </label><br><br>



  <label class="checkbox-inline">
          <input type="checkbox" name="zapr" id="zapr"  <?php if ($zapr=="1") {echo "checked";};?>><small>Заправленный</small>
      </label>
    </div>
  </div>
  </div>
   <div class="center_submit">
  	<button type="submit" id="cartridge_add" class="btn btn-success"><?=get_lang('Add');?></button>
   </div>
  </form>
  <?php
}
if ($mode == "dialog_cartridge_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT * FROM print WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
if ($res1!='') {
  foreach($res1 as $myrow){
          $nomeid=$myrow['nomeid'];
$orgid=$myrow['orgid'];
          $placesid=$myrow['placesid'];
$userid=$myrow['userid'];
          $namek=$myrow['namek'];
$coll=$myrow['coll'];
$newk=$myrow['newk'];
$zapr=$myrow['zapr'];
}
}
  ?>
  <form id='myForm_cart_edit' class="well form-inline"  method="post">
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="nomeid_edit_grp" style="display:inline;">
  <label class="control-label"><small>Наименование оборудования:</small></label>
</div>
   <div id="nomeid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите оборудование" class='my_select select' name="nomeid" id="nomeid">
  	<option value=""></option>
  <?php
    $cartridge = get_conf_param('what_cartridge');
    $stmt= $dbConnection->prepare("SELECT * FROM nome WHERE active=1 and groupid IN (".$cartridge.") order by name;");
    $stmt->execute();
    $res1 = $stmt->fetchAll();
    foreach($res1 as $myrow)
      {$vl=$myrow['id'];
        echo "<option value=$vl";
        if ($myrow["id"]==$nomeid){echo " selected";};
        $nm=$myrow['name'];
        echo ">$nm</option>";
      };

  ?>
   </select>
 </div>
  </div>
  <div class="col-md-6">
    <div class="form-group" id="placesid_edit_grp" style="display:inline;">
   <label class="control-label"><small>Помещение:</small></label>
 </div>
    <div id="placesid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите помещение" class='my_select select' name="placesid" id="placesid">
  	<option value=""></option>
  <?php
  $morgs=GetArrayPlaces();
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
      if ($nid==$placesid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid $sl>$nm</option>";
  };
  ?>
   </select>
 </div>
 </div>
  </div>
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="orgid_edit_grp" style="display:inline;">
   <label class="control-label"><small>Организация:</small></label>
 </divv>
    <div id="orgid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите организацию" class='my_select select' name="orgid" id="orgid">
  	<option value=""></option>
  <?php
  $morgs=GetArrayOrg();
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
      if ($nid==$orgid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid $sl>$nm</option>";
  };
  ?>
   </select>
    </div>
   </div>
 </div>
  <div class="col-md-6">
    <div class="form-group" id="userid_edit_grp" style="display:inline;">
   <label class="control-label"><small>Мат.отв.:</small></label>
 </div>
    <div id="userid_edit_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите Мат.отв." class='my_select select' name="userid" id="userid">
  	<option value=""></option>
  <?php
  $morgs=GetArrayUsers();
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
      if ($nid==$userid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid $sl>$nm</option>";
  };
  ?>
   </select>
    </div>
   </div>
  </div>
  <div class="row">
  <div class="col-md-6">
  <label class="control-label"><small>Модель картриджа:</small></label>
  <input class="input-sm form-control allwidht" type="text" placeholder="Модель картриджа" name="namek" id="namek" value="<?php echo "$namek";?>">
  <label class="control-label"><small>Колличество:</small></label>
  <input class="input-sm form-control allwidht" type="text" placeholder="Кол-во" name="coll" id="coll" value="<?php echo "$coll";?>">
  </div>

  <div class="col-md-6">
    <div class="center_all">
      <br>
  <label class="checkbox-inline">
          <input type="checkbox" name="newk" id="newk"  <?php if ($newk=="1") {echo "checked";};?>><small>Новый</small>
  </label><br><br>

  <label class="checkbox-inline">
          <input type="checkbox" name="zapr" id="zapr"  <?php if ($zapr=="1") {echo "checked";};?>><small>Заправленный</small>
      </label>
    </div>
  </div>
  </div>
   <div class="center_submit">
  	<button type="submit" id="cartridge_edit" class="btn btn-success"><?=get_lang('Edit');?></button>
   </div>
  </form>
  <?php
}
if ($mode == "dialog_cartridge_out"){
?>
  <form id="myForm" class="well form-inline" method="post">
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="cartridge_poluchatel_grp" style="display:inline;">
   <label class="control-label"><small>Получатель:</small></label>
 </div>
 <div id="cartridge_poluchatel_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите получателя" class='my_select select' name="userid" id="userid">
    <option value=""></option>
  <?php
  $morgs=GetArrayUsers();
  for ($i = 0; $i < count($morgs); $i++) {
      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
      if ($nid==$userid){$sl=" selected";} else {$sl="";};
      echo "<option value=$nid $sl>$nm</option>";
  };
  ?>
   </select>
 </div>
   <p></p>
   <div class="form-group" id="coll_grp" style="display:inline;">
      <label class="control-label" style="display:inline"><small>Колличество:</small></label>
  <input class="input-sm form-control" style="width:100px;margin: 0 auto;" placeholder="Кол-во" name="coll2" id="coll2" value="<?php echo "$coll2";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
  </div>
<div class="col-md-6">
    <label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
        <textarea class="form-control allwidht" placeholder="<?=get_lang('Comment_placeholder');?>" rows="3" name="comment" id="comment"><?php echo "$comment";?></textarea>
    </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="cartridge_out" class="btn btn-primary"><?=get_lang('Cartridge_out');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_cartridge_fast_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT * FROM print WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
if ($res1!='') {
  foreach($res1 as $myrow){
$coll=$myrow['coll'];
$newk=$myrow['newk'];
$zapr=$myrow['zapr'];
$comment=$myrow['comment'];

}
}
  ?>
  <form id="myForm" class="well form-inline" method="post">
  <div class="row">
    <div class="col-md-6">
    <label class="checkbox-inline">
            <input type="checkbox" name="newk" id="newk"  <?php if ($newk=="1") {echo "checked";};?>><b><small>Новый</small></b>
    </label><br><br>
    <label class="checkbox-inline">
            <input type="checkbox" name="zapr" id="zapr"  <?php if ($zapr=="1") {echo "checked";};?>><b><small>Заправленный</small></b>
        </label><br><br>
      <label class="control-label" style="display:inline"><small>Колличество:</small></label>
  <input class="input-sm form-control" style="width:100px;margin: 0 auto;" placeholder="Кол-во" name="coll" id="coll" value="<?php echo "$coll";?>">
  </div>
<div class="col-md-6">
    <label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
        <textarea class="form-control allwidht" placeholder="<?=get_lang('Comment_placeholder');?>" rows="4" name="comment" id="comment"><?php echo "$comment";?></textarea>
    </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="cartridge_fast" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "cartridge_uchet"){
  if ($_POST['id'] !=''){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT print_param.id,print_param.dt,users.fio AS fio,print_param.coll2 as coll2,print_param.comment as comment,print_param.active FROM print_param INNER JOIN users ON users.id=userid WHERE printid=:id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    $act = "<button type=\"button\" id=\"history_cart_delete\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>";

    $data = array($key['id'],MySQLDateToDate($key['dt']),$key['fio'],$key['coll2'],$key['comment'],$act);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "cartridge_out"){
  $id = $_POST['id'];
  $userid = $_POST['userid'];
  $coll2 = $_POST['coll2'];
  $comment = $_POST['comment'];

  $stmt = $dbConnection->prepare ('INSERT INTO print_param (id,dt,printid,userid,coll2,comment,active)
        VALUES (NULL,NOW(),:printid,:userid,:coll2,:comment,1)');
  $stmt->execute(array(':printid' => $id, ':userid' => $userid, ':coll2' => $coll2, ':comment' => $comment));

  $stmt = $dbConnection->prepare ('Update print set coll=coll-:coll2 where id=:printid');
  $stmt->execute(array(':printid' => $id,':coll2' => $coll2));


  $stmt = $dbConnection->prepare('SELECT coll as coll FROM print where id=:printid');
  $stmt->execute(array(':printid' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $coll = $row['coll'];
  if ($coll == 0){
    $stmt = $dbConnection->prepare ('Update print set newk=0, zapr=0  where id=:printid');
    $stmt->execute(array(':printid' => $id));
  }

}
if ($mode == "cartridge_add"){
  $nomeid = $_POST['nomeid'];
  $orgid = $_POST['orgid'];
  $placesid = $_POST['placesid'];
  $userid = $_POST['userid'];
  $namek = $_POST['namek'];
  $coll = $_POST['coll'];
  $newk=($_POST['newk']);
  if ($newk == "true") {$newk=1;} else {$newk=0;}
  $zapr=($_POST['zapr']);
  if ($zapr == "true") {$zapr=1;} else {$zapr=0;}
  $stmt = $dbConnection->prepare ('INSERT INTO print (id,nomeid,orgid,placesid,userid,namek,coll,newk,zapr,active) VALUES (NULL,:nomeid,:orgid,:placesid,:userid,:namek,:coll,:newk,:zapr,1)');
  $stmt->execute(array(':nomeid' => $nomeid, ':orgid' => $orgid, ':placesid' => $placesid, ':userid' => $userid, ':namek' => $namek, ':coll' => $coll, 'newk' => $newk, ':zapr' => $zapr));
}
if ($mode == "cartridge_edit"){
  $id = $_POST['id'];
  $nomeid = $_POST['nomeid'];
  $orgid = $_POST['orgid'];
  $placesid = $_POST['placesid'];
  $userid = $_POST['userid'];
  $namek = $_POST['namek'];
  $coll = $_POST['coll'];
  $newk=($_POST['newk']);
  if ($newk == "true") {$newk=1;} else {$newk=0;}
  $zapr=($_POST['zapr']);
  if ($zapr == "true") {$zapr=1;} else {$zapr=0;}
  $stmt = $dbConnection->prepare ('UPDATE print SET nomeid=:nomeid,orgid=:orgid,placesid=:placesid,userid=:userid,namek=:namek,coll=:coll,newk=:newk,zapr=:zapr WHERE id=:id');
  $stmt->execute(array(':nomeid' => $nomeid, ':orgid' => $orgid, ':placesid' => $placesid, ':userid' => $userid, ':namek' => $namek, ':coll' => $coll, 'newk' => $newk, ':zapr' => $zapr, ':id' => $id));

}
if ($mode == "cartridge_delete"){
  $id = $_POST['id'];

  $stmt = $dbConnection->prepare ('UPDATE print SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM print WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,print) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE print = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "cartridge_uchet_delete"){
  $id = $_POST['id'];

  $stmt = $dbConnection->prepare ('DELETE FROM print_param WHERE id=:id');
  $stmt->execute(array(':id' => $id));
}
if ($mode == "cartridge_fast_edit"){
  $id = $_POST['id'];
  $coll = $_POST['coll'];
  $newk=($_POST['newk']);
  if ($newk == "true") {$newk=1;} else {$newk=0;}
  $zapr=($_POST['zapr']);
  if ($zapr == "true") {$zapr=1;} else {$zapr=0;}
  $comment = $_POST['comment'];

  $stmt = $dbConnection->prepare ('UPDATE print SET coll=:coll,newk=:newk,zapr=:zapr,comment=:comment WHERE id=:id');
  $stmt->execute(array(':coll' => $coll, 'newk' => $newk, ':zapr' => $zapr, ':comment' => $comment, ':id' => $id));

}
if ($mode == "table_invoice"){
  if ($_POST['userid'] != ''){
  $userid = $_POST['userid'];

  $stmt = $dbConnection->prepare ('SELECT name as grname,res2.* FROM group_nome INNER JOIN (SELECT places.name as plname,res.* FROM places  INNER JOIN(
                SELECT name AS namenome,nome.groupid as grpid, eq . *  FROM nome INNER JOIN(SELECT users.fio AS fio, fi . * FROM users INNER JOIN(SELECT org.name AS orgname, ro . * FROM org INNER JOIN ( SELECT shtr.id as shtrid, shtr.orgid as shtr_orgid, shtr.shtr_id as shtr_id, sh . * FROM shtr INNER JOIN (
                SELECT equipment.id AS eqid,equipment.orgid AS orid, equipment.placesid AS plid, equipment.usersid AS usid, equipment.nomeid AS nid, equipment.buhname AS bn, equipment.cost AS cs, equipment.currentcost AS curc, equipment.invnum, equipment.sernum, equipment.mode, equipment.os FROM equipment
                WHERE equipment.active =1 and equipment.usersid=:userid and equipment.util=0 and equipment.sale=0)
								AS sh ON shtr.eqid = sh.eqid)
		AS ro ON org.id = ro.orid)
		AS fi ON users.id = fi.usid)
                AS eq ON nome.id = eq.nid)
                AS res ON places.id=res.plid) AS res2 ON group_nome.id=res2.grpid');
    $stmt->execute(array(':userid' => $userid));
    $res1 = $stmt->fetchAll();
    foreach($res1 as $row => $key){
      $shtrih = ($key['shtrid'])."".(str_pad(($key['shtr_orgid']),3,'0',STR_PAD_LEFT))."".(str_pad(($key['shtr_id']),7,'0',STR_PAD_LEFT));

      $data = array($key['eqid'],$key['plname'],$key['namenome'],$key['grname'],$key['sernum'],$shtrih,$key['invnum'],$key['orgname'],$key['fio'],$key['mode'],$key['os'],$key['bn']);
      $output['aaData'][] = $data;
    }
      if ($output != ''){
        echo json_encode($output);
      }
      else {
        $data = array('aaData'=>'');
        $output['aaData']=$data;
        echo json_encode($output);
      }
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }

}
if ($mode == "invoice_print"){
  ?>
  <style>
  table {
    text-align: center;
    border-collapse: collapse;
    border: 1px solid black;
    margin: auto;
    }
th {
    text-align: center; /* Выравнивание по центру */
   padding: 5px; /* Поля вокруг содержимого ячеек */
   border: 1px solid black; /* Граница вокруг ячеек */

}

td {
  text-align: left;
  padding: 5px; /* Поля вокруг содержимого ячеек */
    border: 1px solid black; /* Граница вокруг ячеек */

}
.lc{
  border: solid white;
}
.invoice_header{
  font-size: 18px;
  text-align: center;
}
.dl{
  margin-top: 50px;
}
hr {
  margin-top: 22px;
  border:0 solid #000;
  border-bottom: 1px solid #000;

}
@media print{
    table { page-break-after:auto;}
    tr    { page-break-inside:avoid;}
    td    { page-break-inside:auto;}
    thead { display:table-header-group }

}
  </style>
  <?php
  $userid=$_POST["userid"];
  $userid2=$_POST["userid2"];
  $userid3=$_POST["userid3"];

 $idmass=explode(",",$_POST['id']);

 $stmt = $dbConnection->prepare ('Select (SELECT fio FROM users where users.id = :userid) as fio, (SELECT fio from users where users.id = :userid2) as fio2, (SELECT fio from users where users.id = :userid3) as fio3');
 $stmt->execute(array(':userid' => $userid, ':userid2' => $userid2, ':userid3' => $userid3));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 $fio_pol = $row['fio'];
 $fio_pol2 = $row['fio2'];
 $fio_pol3 = $row['fio3'];
 echo "<table>";
 $rw=0;
 $g = 1;
 for ($i=0;$i<count($idmass);$i++) {
  $idm=$idmass[$i];
  $stmt = $dbConnection->prepare ('SELECT name as grname,res2.* FROM group_nome INNER JOIN (SELECT places.name as plname,res.* FROM places  INNER JOIN(
                SELECT name AS namenome,nome.groupid as grpid, eq . *  FROM nome INNER JOIN(SELECT users.fio AS fio, fi . * FROM users INNER JOIN(SELECT org.name AS orgname, ro . * FROM org INNER JOIN ( SELECT shtr.id as shtrid, shtr.orgid as shtr_orgid, shtr.shtr_id as shtr_id, sh . * FROM shtr INNER JOIN (
                SELECT equipment.id AS eqid,equipment.orgid AS orid, equipment.placesid AS plid, equipment.usersid AS usid, equipment.nomeid AS nid, equipment.buhname AS bn, equipment.cost AS cs, equipment.currentcost AS curc, equipment.invnum, equipment.sernum, equipment.mode, equipment.os FROM equipment
                WHERE equipment.id=:idm)
                AS sh ON shtr.eqid = sh.eqid)
                AS ro ON org.id = ro.orid)
                AS fi ON users.id = fi.usid)
                            AS eq ON nome.id = eq.nid)
                            AS res ON places.id=res.plid) AS res2 ON group_nome.id=res2.grpid');
  $stmt->execute(array(':idm' => $idm));
  $res1 = $stmt->fetchAll();

 if ($rw==0) {
    //  echo "<div style=\"text-align:right;\">";
    //  echo "Сдатчик $sel_plp<br><br><br>";
    //  echo "Принял $sel_plp2<br><br><br>";
    //  echo "Получатель $sel_plp3<br><br><br></div>";
     echo "<div class=\"invoice_header\">Накладная<br>на внутреннее перемещение техники</div><br>";
     echo "<thead>";
     echo "<tr>";

     echo "<th>№</th>";
     echo "<th>Помещение</th>";
     echo "<th>Наименование</th>";
     echo "<th>Группа</th>";
     echo "<th>Сер.№</th>";
     echo "<th>Штрихкод</th>";
     echo "<th>Старый Штрихкод</th>";
     echo "<th>Организация</th>";
     echo "<th>ФИО</th>";
     echo "<th>Списан</th>";
     echo "<th>ОС</th>";
     echo "<th>Бух.имя</th>";
     echo "</tr>";
     echo "</thead>";


   };

  foreach($res1 as $row){
    $shtrih = ($row['shtrid'])."".(str_pad(($row['shtr_orgid']),3,'0',STR_PAD_LEFT))."".(str_pad(($row['shtr_id']),7,'0',STR_PAD_LEFT));
  $invnum=$row['invnum'];
  $plname = $row['plname'];
  $namenome=$row['namenome'];
  $grname=$row['grname'];
  $sernum = $row['sernum'];
  $fio_sokr=nameshort($row['fio']);
  if ($row['mode'] == '1'){$mode = "checked";}else{$mode = "";};
  if ($row['os'] == '1'){$os = "checked";}else{$os = "";};

  $bn = $row['bn'];
  $orgname = $row['orgname'];
  echo "<tbody>";
  echo "<tr>";
  echo "<td>".$g++."</td>";
  echo "<td>$plname</td>";
  echo "<td>$namenome</td>";
  echo "<td>$grname</td>";
  echo "<td>$sernum</td>";
  echo "<td>$shtrih</td>";
  echo "<td>$invnum</td>";
  echo "<td>$orgname</td>";
  echo "<td>$fio_sokr</td>";
  echo "<td style = \"text-align: center;\"><input type=\"checkbox\"  disabled=\"disabled\"".$mode."></td>";
  echo "<td style = \"text-align: center;\"><input type=\"checkbox\"  disabled=\"disabled\"".$os."></td>";
  echo "<td>$bn</td>";
  echo "</tr>";
  echo "</tbody>";






  };
  $rw++;
  };
echo "</table>";

if (($userid2 != "") && ($userid3 != "")){
echo "<table class = \"lc dl\" align = \"right\">";
echo "<tr class = \"lc\"><td height=\"50\">Сдал (а)</td><td class = \"lc\"><b>$fio_pol</b></td><td>Подпись</td><td class = \"lc\" width = \"200\"><hr></hr></td><td>Дата</td><td class = \"lc\" width = \"200\"><hr></hr></tr></td>";
echo "<tr class = \"lc\"><td height=\"50\">Принял (а)</td><td class = \"lc\"><b>$fio_pol2</b></td><td>Подпись</td><td class = \"lc\" width = \"200\"><hr></hr></td><td>Дата</td><td class = \"lc\"  width = \"200\"><hr></hr></tr></td>";
echo "<tr style = \"border: solid white;\"><td height=\"50\">Получил (а)</td><td class = \"lc\"><b>$fio_pol3</b></td><td>Подпись</td><td class = \"lc\" width = \"200\"><hr></hr></td><td>Дата</td><td class = \"lc\" width = \"200\"><hr></hr></tr></td>";
echo "</table>";
}
else {
  echo "<table class = \"lc dl\" align = \"right\">";
  echo "<tr class = \"lc\"><td>Сдал (а)</td><td class = \"lc\" width = \"300\" height=\"50\"><hr></hr></td><td>Подпись</td><td class = \"lc\" width = \"200\"><hr></hr></td><td>Дата</td><td class = \"lc\" width = \"200\"><hr></hr></tr></td>";
  echo "<tr class = \"lc\"><td>Принял (а)</td><td class = \"lc\" width = \"300\" height=\"50\"><hr></hr></td><td>Подпись</td><td class = \"lc\" width = \"200\"><hr></hr></td><td>Дата</td><td class = \"lc\" width = \"200\"><hr></hr></tr></td>";
  echo "<tr style = \"border: solid white;\"><td>Получил (а)</td><td class = \"lc\" width = \"300\" height=\"50\"><hr></hr></td><td>Подпись</td><td class = \"lc\" width = \"200\"><hr></hr></td><td>Дата</td><td class = \"lc\" width = \"200\"><hr></hr></tr></td>";
  echo "</table>";
}
}
if ($mode == "table_report"){
  if (isset($_POST["userid"]))   {$userid = $_POST['userid'];} else {$userid ="null";};
  if (isset($_POST["placesid"]))   {$placesid = $_POST['placesid'];} else     {$placesid ="null";};
  if (isset($_POST["groupid"]))   {$groupid = $_POST['groupid'];} else     {$groupid ="null";};
  if (isset($_POST["orgid"]))   {$orgid = $_POST['orgid'];} else   {$orgid ="null";};
  if (isset($_POST["shtr"]))   {$shtr = $_POST['shtr'];} else   {$shtr ="";};
  if (isset($_POST["name_poisk"]))   {$name_poisk = $_POST['name_poisk'];} else   {$name_poisk ="";};
  if (isset($_POST["ser"]))   {$ser = $_POST['ser'];} else   {$ser ="";};
  if (isset($_POST["buhn"]))   {$buhn = $_POST['buhn'];} else   {$buhn ="";};
  if (isset($_POST["nakl"]))   {$nakl = $_POST['nakl'];} else   {$nakl ="";};
  if (isset($_POST["sel_rep"]))   {$sel_rep = $_POST['sel_rep'];} else         {$sel_rep ="";};
  if (isset($_POST["os"]))   {$os = $_POST['os'];} else           {$os ="";};
  if (isset($_POST["repair"]))   {$repair = $_POST['repair'];} else   {$repair ="";};
  if (isset($_POST["mode_eq"]))   {$mode_eq = $_POST['mode_eq'];} else       {$mode_eq ="";};
  if (isset($_POST["bum"]))   {$bum = $_POST['bum'];} else       {$bum ="";};
  if (isset($_POST["dtpost_report"]))   {$dtpost_report = $_POST['dtpost_report'];} else   {$dtpost_report ="";};

  $shtr_orgid = ltrim((substr($shtr,3,3)),'0');
  $shtr_id = ltrim((substr($shtr,6,7)),'0');
  $shtr_end = "200".$shtr_orgid."".$shtr_id;

  $where="";
  if ($userid!='null') {$where=$where." and equipment.usersid IN ($userid)";}
  if ($placesid!='null') {$where=$where." and equipment.placesid IN ($placesid)";}
  if ($orgid!='null') {$where=$where." and equipment.orgid IN ($orgid)";}
  if ($groupid!='null') {$where=$where." and equipment.nomeid IN (SELECT id FROM nome where groupid IN ($groupid))";}
  if (!empty ($shtr)){$where=$where." and equipment.id IN (SELECT eqid FROM shtr where concat (id,orgid,shtr_id) = '$shtr_end')";}
  if (!empty ($ser)){$where=$where." and equipment.sernum like '%$ser%'";}
  if (!empty ($buhn)){$where=$where." and equipment.buhname like'%$buhn%'";}
  if (!empty ($nakl)){$where=$where." and equipment.invoice like'%$nakl%'";}
  if ($os=='true') {$where=$where." and equipment.os=1";}
  if ($repair=='true') {$where=$where." and equipment.repair=1";}
  if ($mode_eq=='true') {$where=$where." and equipment.mode=1";}
  if ($bum=='true') {$where=$where." and equipment.bum=1";}
  if ($sel_rep=='1') {$where=$where." and equipment.util=0 and equipment.sale=0";}
  if ($sel_rep=='2') {$where=$where." and equipment.mode=0 and equipment.util=0 and equipment.sale=0";}
  if ($sel_rep=='3') {$where=$where." and equipment.mode=0  and equipment.os=0 and equipment.util=0 and equipment.sale=0";}
  if ($sel_rep=='4') {$where=$where." and equipment.bum=0 and equipment.util=0 and equipment.sale=0";}
  if ($sel_rep=='5') {$where=$where." and equipment.util=1 and equipment.sale=0";}
  if ($sel_rep=='6') {$where=$where." and equipment.util=0 and equipment.sale=1";}
  if (!empty ($dtpost_report)){$where=$where." and equipment.datepost like'%$dtpost_report%'";}

  $where_name="";
  if (!empty ($name_poisk)){$where_name=$where_name." where nome.name like '%$name_poisk%'";}

  $stmt = $dbConnection->prepare ("SELECT name as grname,res2.* FROM group_nome INNER JOIN (SELECT places.name as plname,res.* FROM places  INNER JOIN(
                SELECT nome.name AS namenome,vendor.name AS vendorname,nome.groupid as grpid, eq . *  FROM nome INNER JOIN vendor ON nome.vendorid = vendor.id INNER JOIN(SELECT users.fio AS fio, fi . * FROM users INNER JOIN (SELECT org.name AS orgname, ro . * FROM org INNER JOIN(SELECT knt.name AS kntname, kn . * FROM knt INNER JOIN ( SELECT shtr.id as shtrid, shtr.orgid as shtr_orgid, shtr.shtr_id as shtr_id, sh . * FROM shtr INNER JOIN (
                SELECT equipment.id AS eqid,equipment.orgid AS orid, equipment.placesid AS plid, equipment.usersid AS usid, equipment.nomeid AS nid,equipment.kntid AS kntid, equipment.buhname, equipment.cost AS cs, equipment.currentcost AS curc, equipment.invnum, equipment.sernum, equipment.invoice, equipment.mode,equipment.bum, equipment.comment, equipment.os,equipment.datepost,equipment.active AS eqactive, equipment.repair AS eqrepair FROM equipment
                WHERE equipment.active =1 ".$where.")
								AS sh ON shtr.eqid = sh.eqid)
		AS kn ON knt.id = kn.kntid)
		AS ro ON org.id = ro.orid)
		AS fi ON users.id = fi.usid)
                AS eq ON nome.id = eq.nid ".$where_name.")
                AS res ON places.id=res.plid) AS res2 ON group_nome.id=res2.grpid");
                $stmt->execute();
                $res1 = $stmt->fetchAll();
                foreach($res1 as $row => $key){
                  if ($key['os']==1){$os= true;} else {$os= false;};
                  if ($key['mode']==1){$mode_eq= true;} else {$mode_eq= false;};
                  if ($key['bum']==1){$bum= true;} else {$bum= false;};
                  $dtpost=MySQLDateToDate($key['datepost']);
                  $fiopol=nameshort($key['fio']);
                  $shtrih = ($key['shtrid'])."".(str_pad(($key['shtr_orgid']),3,'0',STR_PAD_LEFT))."".(str_pad(($key['shtr_id']),7,'0',STR_PAD_LEFT));

                  $data = array($key['eqid'],$key['plname'],$key['namenome'],$key['grname'],$key['vendorname'],$key['buhname'],$key['sernum'],$key['invnum'],$shtrih,$key['orgname'],$fiopol,$dtpost,$key['cs'],$mode_eq,$os,$bum,$key['kntname'],$key['invoice'],$key['comment']);
                  $output['aaData'][] = $data;
                }
                  if ($output != ''){
                    echo json_encode($output);
                  }
                  else {
                    $data = array('aaData'=>'');
                    $output['aaData']=$data;
                    echo json_encode($output);
                  }
}
if ($mode == "eq_table_move_rep"){
  if ($_POST['move_eqid'] != ''){
  $eqid = ($_POST['move_eqid']);
  $stmt = $dbConnection->prepare('SELECT mv.id as mvid, mv.eqid, nome.name,mv.nomeid,mv.dt, mv.orgname1, org.name AS orgname2, mv.place1, places.name AS place2, mv.user1, users.fio AS user2, mv.kntfrom, move.invoice as invoicefrom,move.comment as comment
            FROM move
            INNER JOIN (
            SELECT move.id, move.eqid, equipment.nomeid,move.dt AS dt, org.name AS orgname1, places.name AS place1, users.fio AS user1, knt.name as kntfrom
            FROM move
            INNER JOIN org ON org.id = orgidfrom
            INNER JOIN places ON places.id = placesidfrom
            INNER JOIN users ON users.id = useridfrom
            INNER JOIN equipment ON equipment.id = eqid
	    INNER JOIN knt ON knt.id = kntfrom
            ) AS mv ON move.id = mv.id
            INNER JOIN org ON org.id = move.orgidto
            INNER JOIN places ON places.id = placesidto
            INNER JOIN users ON users.id = useridto
            INNER JOIN nome ON nome.id = mv.nomeid WHERE move.eqid = :move_eqid');
            $stmt->execute(array(':move_eqid' => $eqid));
            $res1 = $stmt->fetchall();

            foreach($res1 as $row => $key) {
              $dt=MySQLDateTimeToDateTime($key['dt']);
              $user1 = nameshort($key["user1"]);
              $user2 = nameshort($key["user2"]);

              $data = array($key['mvid'],$dt,$key["orgname1"],$key["place1"],$user1,$key["kntfrom"],$key["invoicefrom"],$key["orgname2"],$key["place2"],$user2,$key["comment"]);
              $output['aaData'][] = $data;
            }
            if ($output != ''){
            echo json_encode($output);
          }else {
            $data = array('aaData'=>'');
            $output['aaData']=$data;
            echo json_encode($output);
          }
}
else {
  $data = array('aaData'=>'');
  $output['aaData']=$data;
  echo json_encode($output);
}
}
if ($mode == "shtrih_print"){
  $idmass=explode(",",$_POST['id']);
  echo "<table border=1>";
  $rw=0;
  for ($i=0;$i<count($idmass);$i++) {
   $idm=$idmass[$i];
   $stmt = $dbConnection->prepare ('SELECT shtr.id as shtrid, shtr.orgid as shtr_orgid, shtr.shtr_id as shtr_id, equipment.sernum as sernum, getvendorandgroup.grnomeid,equipment.id, nome.name as nomename,getvendorandgroup.groupname AS grnome, users.fio as fio FROM equipment  INNER JOIN (
 	SELECT nome.groupid AS grnomeid,nome.id AS nomeid, group_nome.name AS groupname, nome.name AS nomename
 	FROM nome
 	INNER JOIN group_nome ON nome.groupid = group_nome.id
) AS getvendorandgroup ON getvendorandgroup.nomeid = equipment.nomeid INNER JOIN nome ON nome.id=equipment.nomeid INNER JOIN users ON users.id=equipment.usersid INNER JOIN shtr ON shtr.eqid = equipment.id WHERE equipment.id=:idm');
$stmt->execute(array(':idm' => $idm));
$res1 = $stmt->fetchAll();
    if ($rw==0) {echo "<tr>";};

   foreach($res1 as $row){
     $shtrih = ($row['shtrid'])."".(str_pad(($row['shtr_orgid']),3,'0',STR_PAD_LEFT))."".(str_pad(($row['shtr_id']),7,'0',STR_PAD_LEFT));
 	$nomename=$row['nomename'];
 	$grnome=$row['grnome'];
 	$sernum=$row['sernum'];
 	$fio_sokr=nameshort($row['fio']);
 	echo "<td align=center>";
 	echo "Мат.отв.: $fio_sokr<br>";
 	echo "Группа: $grnome<br>";
 	echo "Номенклатура: $nomename<br>";
 	echo "Сер.№: $sernum<br><br>";
 echo "<img src='inc/code128.php?text=$shtrih'><br>";
 echo $shtrih;
 echo "</td>";

 	};

 	if ($rw==6) {echo "</tr>";};
 	$rw++;
 	if ($rw==7) {$rw=0;};
 	};
 echo "</table>";
}
if ($mode == "dialog_org_add"){
  ?>
  <form id="myForm_org_add" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="org_add_grp" style="display:inline;">
      <label class="control-label"><small>Наименование организации:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование организации" name="org" id="org" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
  </div>
</div>
  </div>
  <div class="center_submit">
  <button type="submit" id="add_org" class="btn btn-primary"><?=get_lang('Add');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_org_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT name FROM org WHERE id = :id');
  $stmt->execute(array(':id' => $id ));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $orgname = $row['name'];
  ?>
  <form id="myForm_org_edit" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="org_edit_grp" style="display:inline;">
      <label class="control-label"><small>Наименование организации:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование организации" name="org" id="org" value="<?php echo "$orgname";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="edit_org" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "org_table"){
  $stmt = $dbConnection->prepare ('SELECT id,name,active FROM org');
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"org_edit\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"org_del\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";

    if ($key['active']=="1") {$active="active";} else {$active="not_active";};
    $data = array($active,$key['id'],$key['name'],$act);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }

}
if ($mode == "org_add"){
  $name = ($_POST['name']);
  $stmt = $dbConnection->prepare ('INSERT INTO org (id,name,active) VALUES (null,:name,1)');
  $stmt->execute(array(':name' => $name));

}
if ($mode == "org_edit"){
  $id = $_POST['id'];
  $name = ($_POST['name']);
  $stmt = $dbConnection->prepare ('UPDATE org SET name=:name WHERE id=:id');
  $stmt->execute(array(':name' => $name, ':id' => $id));

}
if ($mode == "org_delete")
{
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE org SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM org WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,org) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE org = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "approve"){
  $stmt = $dbConnection->prepare('select count(id) as t1 from approve ');
  $stmt->execute();
  $count = $stmt->fetch(PDO::FETCH_ASSOC);
  echo $count['t1'];
}
if ($mode == "approve_users"){
  $stmt = $dbConnection->prepare ("select lastdt from users");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  $count_lt = array();
  foreach($res1 as $row) {
    $lt = $row['lastdt'];
    $d = time()-strtotime($lt);
if ($d < 20) {
    array_push($count_lt,$d);
  }
  }
  echo count($count_lt);
}
if ($mode == "places_table"){
  $stmt = $dbConnection->prepare ("SELECT id,name,comment,active FROM places");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"places_edit\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"places_del\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";
    if ($key['active']=="1") {$active="active";} else {$active="not_active";};
    $data = array($active,$key['id'],$key['name'],$key['comment'],$act);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "dialog_places_add"){
  ?>
  <form id="myForm_places_add" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="places_add_grp" style="display:inline;">
      <label class="control-label"><small>Наименование помещения:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование помещения" name="places" id="places" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<p></p>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="add_places" class="btn btn-success"><?=get_lang('Add');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_places_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT name,comment FROM places WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $placesname = $row['name'];
    $comment = $row['comment'];
  }
  ?>
  <form id="myForm_places_edit" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="places_edit_grp" style="display:inline;">
      <label class="control-label"><small>Наименование помещения:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование помещения" name="places" id="places" value="<?php echo "$placesname";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<p></p>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"><?php echo "$comment";?></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="edit_places" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "places_add"){
  $name = ($_POST['name']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ("INSERT INTO places (id,name,comment,active) VALUES (null,:name,:comment,1)");
  $stmt->execute(array(':name' => $name, ':comment' => $comment));
}
if ($mode == "places_edit"){
  $id = $_POST['id'];
  $name = ($_POST['name']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ("UPDATE places SET name=:name,comment=:comment WHERE id=:id");
  $stmt->execute(array(':name' => $name, ':comment' => $comment, ':id' => $id));
}
if ($mode == "places_delete")
{
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE places SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM places WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,places) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE places = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "places_sub_table"){
  if ($_POST['id'] !=''){
  $placesid = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT places_users.id AS plid,placesid,userid,users.login as name,users.fio AS fio, users.id as id FROM places_users INNER JOIN users ON users.id=userid WHERE placesid=:placesid and users.on_off = 1 ");
  $stmt->execute(array(':placesid' => $placesid));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){

    $data = array($key['id'],$key['fio'],$key['name']);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "users_table"){
  $uid = $_COOKIE['on_off_cookie'];

  $stmt = $dbConnection->prepare ("SELECT users.id,users.login,users.fio,users.pass,users.email,users.priv,users.active,users.on_off,users.dostup,users.lang,users.user_name FROM users WHERE on_off = :uid");
  $stmt->execute(array(':uid' => $uid));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    switch($key["priv"]){
      case 0: $priv="<span data-toggle=\"tooltip\" data-placement=\"right\" data-original-title=\"".validate_menu_lang($key['id'])."\" data-html=\"true\">Пользователь</span>";
      break;
      case 1: $priv="<span data-toggle=\"tooltip\" data-placement=\"right\" data-original-title=\"".get_lang("All_menu")."\" data-html=\"true\">Администратор</span>";
      break;
      case 2: $priv="<span data-toggle=\"tooltip\" data-placement=\"right\" data-original-title=\"".validate_menu_lang($key['id'])."\" data-html=\"true\">Опытный Пользователь</span>";
      break;
    }
    switch($key["dostup"]){
  case 0: $dostup="Доступа нет";
  break;
  case 1: $dostup="Доступ есть";
  break;
    }
    switch($key["lang"]){
  case 'ru': $lang="Русский";
  break;
  case 'en': $lang="English";
  break;
    }
    if (($key['active']=="1") && ($key['on_off']=="1")) {$active="active";} else {$active="not_active";};
    if (($key['active']=="1") && ($key['on_off']=="0")) {$active="off";};
    $s = get_user_status($key['id']);
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"users_edit\" class=\"btn btn-xs btn-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\"><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"users_profile\" class=\"btn btn-xs btn-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Profile_toggle')."\"><i class=\"fa fa-cogs\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"users_del\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";
    $data = array($active,$key['id'],$key['login'],$key['fio'],'скрыто',$key['user_name'],$key['email'],$priv,$dostup,$lang,$s,$act);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }

}
if ($mode == "dialog_users_add"){
  ?>
  <form id="myForm_users_add" class="well form-horizontal" method="post" >
    <div class="row">
      <div class="col-md-6">
        <div class="form-group" id="login_grp" style="display:inline;">
      <input placeholder="Логин" class="input-sm form-control allwidht" name="login" id="login" type="text" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
    <div class="form-group" id="pass_add_grp" style="display:inline;">
      <div class="allwidht input-group ">
        <input placeholder="Пароль" name="pass" id="pass" class="form-control input-sm" TYPE=PASSWORD data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
         <span class="input-group-btn">
        <button type = "button" id="show_pass" class="btn btn-default btn-sm allwidht">
          <i id="show" class="fa fa-eye" aria-hidden="true"></i>
        </button>
      </span>
    </div>
      </div>
    </div>
  <div class="col-md-6">
    <div class="form-group" id="fio_add_grp" style="display:inline;">
      <input placeholder="ФИО" class="input-sm form-control allwidht"  name="fio" id="fio" type="text" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
    <div class="form-group" id="email_grp" style="display:inline;">
      <input placeholder="Email" name="email" id="email" type="email" class="input-sm form-control allwidht" value="no-email@weblocal" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
  </div>
    </div>
          <div class="form-group">
              <div class="col-sm-4 text-right" ><label class="control-label"><small>Имя пользователя:</small></label></div>
              <div class="col-sm-8">
                <div class="allwidht input-group ">
                  <div id="user_name_grp" style="display:inline;">
                  <input name="user_name" id="user_name" type="text" class="input-sm form-control allwidht" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_user_name'); ?>" autocomplete="off">
                </div>
                  <span class="input-group-btn">
                    <button type = "button" id="user_name_gen" class="btn btn-default btn-sm allwidht">Генерировать</button>
                  </span>
                </div>
              </div>
            </div>
          <div class="form-group">
            <div class="col-sm-4 text-right" ><label class="control-label"><small>Права пользователя:</small></label></div>
          <div class="col-sm-8">
            <select class="my_select2 select" name="priv" id="priv">
                <option value='0'>Пользователь</option>
                <option value='1'>Администратор</option>
                <option value='2'>Опытный Пользователь</option>
            </select>
          </div>
          </div>
          <div class="form-group" id="menu_sh">
            <div class="col-sm-4 text-right" ><label class="control-label"><small>Доступ к меню:</small></label></div>
          <div class="col-sm-8">
            <select class="my_select2 select" data-placeholder="Пункты меню" multiple id="permit_menu" name="permit_menu[]">
              <?php
                $pm = explode(",",$permit_menu);
               ?>
            <option value="1-1"><?=get_lang('Menu_reports');?></option>
            <option value="1-2"><?=get_lang('Menu_invoice');?></option>
            <option value="1-3"><?=get_lang('Menu_history_moving');?></option>
            <option value="1-4"><?=get_lang('Menu_cartridge');?></option>
            <option value="1-5"><?=get_lang('Menu_license');?></option>
            <option value="1-6"><?=get_lang('Menu_equipment');?></option>
            <option value="2-1"><?=get_lang('Menu_ping');?></option>
            <option value="2-2"><?=get_lang('Menu_printer');?></option>
            <option value="3-1"><?=get_lang('Menu_news');?></option>
            <option value="3-2"><?=get_lang('Menu_eqlist');?></option>
            <option value="3-3"><?=get_lang('Menu_requisites');?></option>
            <option value="3-4"><?=get_lang('Menu_knt');?></option>
            <option value="3-5"><?=get_lang('Menu_documents');?></option>
            <option value="3-6"><?=get_lang('Menu_contact');?></option>
            <option value="3-7"><?=get_lang('Menu_calendar');?></option>
          </select>
          </div>
          </div>
            <div class="form-group">
            <div class="col-sm-4 text-right" >
            <label class="control-label"><small>Доступ в систему:</small></label>
          </div>
          <div class="col-sm-8">
            <select class="my_select2 select" name="dostup" id="dostup">
  		          <option value='0'>Выключен</option>
  		          <option value='1'>Включен</option>
            </select>
          </div>
        </div>
            <div class="form-group">
              <div class="col-sm-4 text-right" >
              <label class="control-label"><small>Язык системы:</small></label>
            </div>
            <div class="col-sm-8">
              <select class="my_select2 select" name="lang" id="lang">
    		          <option value='ru'>Русский</option>
    		          <option value='en'>English</option>
            </select>
          </div>
        </div>
   <div class="center_submit">
  	 <button type="submit" id="add_users" name="add_users" class="btn btn-success"><?=get_lang('Add');?></button>
   </div>
  </form>
  <?php
}
if ($mode == "dialog_users_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT login,pass,fio,email,priv,permit_menu,on_off,dostup,lang,user_name FROM users WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $login = $row['login'];
    $pass = $row['pass'];
    $fio = $row['fio'];
    $email = $row['email'];
    $priv = $row['priv'];
    $permit_menu = $row['permit_menu'];
    $on_off = $row['on_off'];
    $dostup = $row['dostup'];
    $user_name = $row['user_name'];
    $lang = $row['lang'];
  }
  ?>
  <form id="myForm_users_edit" class="well form-horizontal" method="post" >
    <div class="row">
      <div class="col-md-6">
        <div class="form-group" id="login_edit_grp" style="display:inline;">
      <input placeholder="Логин" class="input-sm form-control allwidht" name="login" id="login" type="text" value="<?php echo "$login";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
    <div class="form-group" id="pass_edit_grp" style="display:inline;">
      <div class="allwidht input-group ">
        <input placeholder="Пароль" name="pass" id="pass" class="form-control input-sm" TYPE=PASSWORD value="<?php echo "$pass";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
         <span class="input-group-btn">
        <button type = "button" id="show_pass" class="btn btn-default btn-sm allwidht">
          <i id="show" class="fa fa-eye" aria-hidden="true"></i>
        </button>
      </span>
      </div>
    </div>
    </div>
  <div class="col-md-6">
    <div class="form-group" id="fio_edit_grp" style="display:inline;">
      <input placeholder="ФИО" class="input-sm form-control allwidht"  name="fio" id="fio" type="text" value="<?php echo "$fio";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
    <div class="form-group" id="email_grp" style="display:inline;">
      <input placeholder="Email" name="email" id="email" type="email" class="input-sm form-control allwidht" value="<?php echo "$email";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
  </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 text-right" ><label class="control-label"><small>Имя пользователя:</small></label></div>
        <div class="col-sm-8">
          <div class="allwidht input-group ">
            <div id="user_name_grp" style="display:inline;">
            <input name="user_name" id="user_name" type="text" class="input-sm form-control allwidht" value="<?php echo "$user_name";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_user_name'); ?>" autocomplete="off">
          </div>
            <span class="input-group-btn">
              <button type = "button" id="user_name_gen" class="btn btn-default btn-sm allwidht">Генерировать</button>
            </span>
          </div>
        </div>
      </div>
    <div class="form-group">
      <div class="col-sm-4 text-right" >
            <label class="control-label"><small>Права пользователя:</small></label>
          </div>
          <div class="col-sm-8">
            <select class="my_select2 select" name="priv" id="priv">
                <option value=0 <? if ($priv==0) {echo "selected";};?>>Пользователь</option>
                <option value=1 <? if ($priv==1) {echo "selected";};?>>Администратор</option>
                <option value=2 <? if ($priv==2) {echo "selected";};?>>Опытный Пользователь</option>
            </select>
          </div>
          </div>
          <div class="form-group" id="menu_sh">
            <div class="col-sm-4 text-right" ><label class="control-label"><small>Доступ к меню:</small></label></div>
          <div class="col-sm-8">
            <select class="my_select2 select" data-placeholder="Пункты меню" multiple id="permit_menu" name="permit_menu[]">
              <?php
                $pm = explode(",",$permit_menu);
               ?>
            <option value="1-1" <?php if (in_array("1-1",$pm)) {echo "selected";} ?>><?=get_lang('Menu_reports');?></option>
            <option value="1-2" <?php if (in_array("1-2",$pm)) {echo "selected";} ?>><?=get_lang('Menu_invoice');?></option>
            <option value="1-3" <?php if (in_array("1-3",$pm)) {echo "selected";} ?>><?=get_lang('Menu_history_moving');?></option>
            <option value="1-4" <?php if (in_array("1-4",$pm)) {echo "selected";} ?>><?=get_lang('Menu_cartridge');?></option>
            <option value="1-5" <?php if (in_array("1-5",$pm)) {echo "selected";} ?>><?=get_lang('Menu_license');?></option>
            <option value="1-6" <?php if (in_array("1-6",$pm)) {echo "selected";} ?>><?=get_lang('Menu_equipment');?></option>
            <option value="2-1" <?php if (in_array("2-1",$pm)) {echo "selected";} ?>><?=get_lang('Menu_ping');?></option>
            <option value="2-2" <?php if (in_array("2-2",$pm)) {echo "selected";} ?>><?=get_lang('Menu_printer');?></option>
            <option value="3-1" <?php if (in_array("3-1",$pm)) {echo "selected";} ?>><?=get_lang('Menu_news');?></option>
            <option value="3-2" <?php if (in_array("3-2",$pm)) {echo "selected";} ?>><?=get_lang('Menu_eqlist');?></option>
            <option value="3-3" <?php if (in_array("3-3",$pm)) {echo "selected";} ?>><?=get_lang('Menu_requisites');?></option>
            <option value="3-4" <?php if (in_array("3-4",$pm)) {echo "selected";} ?>><?=get_lang('Menu_knt');?></option>
            <option value="3-5" <?php if (in_array("3-5",$pm)) {echo "selected";} ?>><?=get_lang('Menu_documents');?></option>
            <option value="3-6" <?php if (in_array("3-6",$pm)) {echo "selected";} ?>><?=get_lang('Menu_contact');?></option>
            <option value="3-7" <?php if (in_array("3-7",$pm)) {echo "selected";} ?>><?=get_lang('Menu_calendar');?></option>
          </select>
          </div>
          </div>
            <div class="form-group" id="account_grp">
              <div class="col-sm-4 text-right" >
            <label class="control-label"><small>Аккаунт:</small></label>
          </div>
            <div id="on_off_p" class="col-sm-8" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_account'); ?>">
            <select class="my_select2 select" name="on_off" id="on_off">
        		<option value=0 <? if ($on_off==0) {echo "selected";};?>>Выключен</option>
        		<option value=1 <? if ($on_off==1) {echo "selected";};?>>Включен</option>
            </select>
          </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4 text-right" >
            <label class="control-label"><small>Доступ в систему:</small></label>
          </div>
          <div class="col-sm-8">
            <select class="my_select2 select" name="dostup" id="dostup">
  		          <option value=0 <? if ($dostup==0) {echo "selected";};?>>Выключен</option>
  		          <option value=1 <? if ($dostup==1) {echo "selected";};?>>Включен</option>
            </select>
          </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4 text-right" >
              <label class="control-label"><small>Язык системы:</small></label>
            </div>
            <div class="col-sm-8">
              <select class="my_select2 select" name="lang" id="lang">
    		          <option value='ru' <? if ($lang=='ru') {echo "selected";};?>>Русский</option>
    		          <option value='en' <? if ($lang=='en') {echo "selected";};?>>English</option>
            </select>
            </div>
            </div>
   <div class="center_submit">
  	 <button type="submit" id="edit_users" name="edit_users" class="btn btn-success"><?=get_lang('Edit');?></button>
   </div>
  </form>
  <?php
}
if ($mode == "dialog_users_profile"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT users_profile.homephone AS wphone,users_profile.telephonenumber AS sphone,users_profile.emaildop AS emaildop,users_profile.birthday AS bi, users.id as usersid,users.fio as fio,users.email as email, users_profile.jpegphoto as photo, users_profile.post as post FROM users INNER JOIN users_profile ON usersid=users.id WHERE users.id = :id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $post = $row['post'];
    $mobile = $row['sphone'];
    $work_number = $row['wphone'];
    $birthday = $row['bi'];
    $emaildop = $row['emaildop'];
    $photo = $row['photo'];
    $email = $row['email'];
    $fio = $row['fio'];
  }
  $stmt = $dbConnection->prepare ('SELECT places.id as placesid FROM places_users INNER JOIN places ON places_users.placesid = places.id INNER JOIN users ON places_users.userid = users.id WHERE places.active=1 and users.id = :id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $placesid = $row['placesid'];
  }
  $photo = $photo."?".time();
  ?>
  <script type="text/javascript">
        var Avatar = "images/avatar/<?php echo "$photo";?>";
        var Fio = "<?php echo "$fio";?>";
  </script>
  <form id="myForm_edit_profile" class="well form-inline" method="post" >
<div class="row">
  <div class="col-md-4">
    <label class="control-label"><small>Кабинет</small></label>
    <select data-placeholder="Выберите помещение" class='my_select select' name="placesid" id="placesid">
   	<option value=""></option>
   <?php
   $morgs=GetArrayPlaces();
   for ($i = 0; $i < count($morgs); $i++) {
       $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
       if ($nid==$placesid){$sl=" selected";} else {$sl="";};
       echo "<option value=$nid $sl>$nm</option>";
   };
   ?>
    </select>
      <label class="control-label"><small>Дата Рождения</small></label>
            <input  placeholder="Дата Рождения" maxlenght=10 name="birthday" class="form-control input-sm allwidht" id="birthday" type="text" value="<?php echo "$birthday";?>" autocomplete="off">

    <label class="control-label"><small>Рабочий телефон</small></label>
            <input placeholder="Рабочий телефон" class="form-control input-sm allwidht" name="work_number" id="work_number" type="text" value="<?php echo "$work_number";?>" autocomplete="off">

            <div class="form-group" id="email_grp" style="display:inline;">
      <label class="control-label"><small>Основной email</small></label>
      <input placeholder="Основной email" name="email" id="email" type="email" class="form-control input-sm allwidht" value="<?php echo "$email";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    </div>
</div>
<div class="col-md-4">
  <label class="control-label"><small>Должность</small></label>
  <input placeholder="Должность" name="post" id="post" type="text" class="form-control input-sm allwidht" value="<?php echo "$post";?>" autocomplete="off">

  <label class="control-label"><small>Сотовый телефон</small></label>

  <input name="mobile" placeholder="+7 (123) 123-45-67" id="mobile" type="tel" class="form-control input-sm allwidht" value="<?php echo "$mobile";?>" autocomplete="off">


  <label class="control-label"><small>Дополнительный email</small></label>
  <input placeholder="Дополнительный email" name="emaildop" id="emaildop" type="text" class="form-control input-sm allwidht" value="<?php echo "$emaildop";?>" autocomplete="off">
</div>
<div class="col-md-4">
  <div id="img_show" class="center_all" style="margin-top:20px;">
    <img src="images/avatar/<?php echo $photo?>" class="img-circle" alt="Responsive image">
    <div style="margin-top:5px;">
      <div class="btn-group">
    <button class="btn btn-primary" type="button" id="ch_img" style="width: 75px;">Сменить</button>
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
      <li><a href="#" id="img_del_users"><?=get_lang('Delete');?></a></li>
    </ul>
  </div>
  </div>
  </div>
<div id="change_img">
<div class="imageBox">
  <div class="thumbBox"></div>
  <div class="spinner" style="display: none">Loading...</div>
</div>
<div class="action">
  <input type="file" id="file">
  <div class="btn-group btn-group-justified">
    <div class="btn-group">
      <button type="button" class="btn btn-primary" id="btn_file" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_upload');?>"><i class="fa fa-upload" aria-hidden="true"></i>
</div>
<div class="btn-group">
  <button class="btn btn-primary" type="button" id="btnZoomIn" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomin');?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
</div>
<div class="btn-group">
  <button class="btn btn-primary" type="button" id="btnZoomOut" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomout');?>"><i class="fa fa-minus" aria-hidden="true"></i></button>
</div>
<div class="btn-group">
  <button class="btn btn-primary" type="button" id="btnRotate" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_rotate');?>"><i class="fa fa-rotate-right" aria-hidden="true"></i></button>
</div>

</div>
</div>
</div>
</div>
</div>
      <div class="center_submit">
      <button type="submit" id="edit_profile" name="edit_profile" class="btn btn-success"><?=get_lang('Save');?></button>
    </div>
  </form>
  <?php
}
if ($mode == "users_add"){
  $login = $_POST['login'];
  $pass = $_POST['pass'];
  $fio = $_POST['fio'];
  $email = $_POST['email'];
  $priv = $_POST['priv'];
  $permit_menu = $_POST['permit_menu'];
  $dostup = $_POST['dostup'];
  $user_name = $_POST['user_name'];
  $lang = $_POST['lang'];
  $stmt = $dbConnection->prepare ("INSERT INTO users (id,login,fio,pass,email,priv,permit_menu,active,on_off,dostup,lang,user_name) VALUES (NULL,:login,:fio,:pass,:email,:priv,:permit_menu,1,1,:dostup,:lang,:user_name)");
  $stmt->execute(array(':login' => $login, ':fio' => $fio, ':pass' => $pass, ':email' => $email, ':priv' => $priv, ':permit_menu' => $permit_menu, 'dostup' => $dostup, ':lang' => $lang, ':user_name' => $user_name ));

  $stmt = $dbConnection->prepare('SELECT max(last_insert_id(id)) as us_id FROM users');
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $us_id = $row["us_id"];

  $stmt = $dbConnection->prepare ("INSERT INTO users_profile (id,usersid) VALUES (NULL,:us_id)");
  $stmt->execute(array(':us_id' => $us_id));
}
if ($mode == "users_edit"){
  $id = $_POST['id'];
  $login = $_POST['login'];
  $pass = $_POST['pass'];
  $fio = $_POST['fio'];
  $email = $_POST['email'];
  $priv = $_POST['priv'];
  $permit_menu = $_POST['permit_menu'];
  $dostup = $_POST['dostup'];
  $user_name = $_POST['user_name'];
  $lang = $_POST['lang'];
  $on_off = $_POST['on_off'];

  $stmt = $dbConnection->prepare ("UPDATE users SET login = :login, fio = :fio, pass = :pass, email = :email, priv = :priv, permit_menu = :permit_menu, on_off = :on_off, dostup = :dostup, lang = :lang, user_name = :user_name WHERE id = :id");
  $stmt->execute(array(':login' => $login, ':fio' => $fio, ':pass' => $pass, ':email' => $email, ':priv' => $priv, ':permit_menu' => $permit_menu, ':on_off' => $on_off, 'dostup' => $dostup, ':lang' => $lang, ':user_name' => $user_name, ':id' => $id ));
}
if ($mode == "users_delete"){
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE users SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM users WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,users) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE users = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "edit_profile_users"){
  define('UPLOAD_DIR', 'images/avatar/');
  $id = $_POST['id'];
  $post = $_POST['post'];
  $emaildop = $_POST['emaildop'];
  $birthday = $_POST['birthday'];
  $homephone = $_POST['work_number'];
  $telephonenumber = $_POST['mobile'];
  $email = $_POST['email'];
  $placesid = $_POST['placesid'];
  $img = $_POST['img'];
  $stmt = $dbConnection->prepare ('SELECT jpegphoto FROM users_profile WHERE usersid=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $photo = $row['jpegphoto'];

  if ($_POST['img'] != ''){
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  if (($photo != '') && ($photo != 'noavatar.png')){
  if (file_exists(UPLOAD_DIR . $photo)){
    $file = $photo;
  }
  else{
  $file = uniqid() . '.png';
  }
}
else {
  $file = uniqid() . '.png';
}
  $success = file_put_contents(UPLOAD_DIR . $file, $data);
  // print $success ? $file : 'Unable to save the file.';
}
else {
  if ($photo != ''){
    $file = $photo;
  }
  else {
    $file = 'noavatar.png';
  }
}
  $stmt = $dbConnection->prepare ('UPDATE users_profile, users SET users_profile.jpegphoto = :jpegphoto, users_profile.post = :post, users_profile.emaildop = :emaildop, users_profile.birthday = :birthday, users_profile.homephone = :homephone, users_profile.telephonenumber = :telephonenumber, users.email = :email WHERE users.id = users_profile.usersid AND users.id = :id');
  $stmt->execute(array(':id' => $id, ':jpegphoto' => $file, ':post' => $post, ':emaildop' => $emaildop, ':birthday' => $birthday, ':homephone' => $homephone, ':telephonenumber' => $telephonenumber, ':email' => $email));
if ($_POST['placesid'] != ''){
  $stmt2 = $dbConnection->prepare ('INSERT INTO places_users (id,placesid,userid) VALUES (null,:placesid,:userid) ON DUPLICATE KEY UPDATE placesid= :placesid2');
  $stmt2->execute(array(':placesid' => $placesid, ':placesid2' => $placesid, ':userid' => $id));
}
else {
  $stmt2 = $dbConnection->prepare ('DELETE FROM places_users WHERE userid=:userid');
  $stmt2->execute(array(':userid' => $id));
}
}
if ($mode == "check_login") {

$l=$_POST['login'];

if (validate_exist_login($l) == true) {$r['check_login_status']=true;}
else if (validate_exist_login($l) == false) {$r['check_login_status']=false;}
$row_set[] = $r;
echo json_encode($row_set);
}
if ($mode == "check_user_name") {
$un=$_POST['user_name'];

if (validate_exist_user_name($un) == true) {$r['check_user_name_status']=true;}
else if (validate_exist_user_name($un) == false) {$r['check_user_name_status']=false;}
$row_set[] = $r;
echo json_encode($row_set);
}
if ($mode == "check_account") {

$l=$_POST['login'];
if (validate_login_equipment($l) == true) {$u['check_account_status']=true;}
else if (validate_login_equipment($l) == false) {$u['check_account_status']=false;}
$row_set[] = $u;
echo json_encode($row_set);
}
if ($mode =="contact_table"){
  $stmt = $dbConnection->prepare ("SELECT users_profile.id AS usprofid,users_profile.homephone AS wphone,users_profile.telephonenumber AS sphone,users_profile.emaildop AS emaildop,users_profile.birthday AS bi,places.name AS plname, users.id as usersid,users.fio as fio,users.active as active,users.email as email,users.on_off as on_off FROM users RIGHT JOIN users_profile ON users.id=usersid INNER JOIN places_users ON users.id=userid INNER JOIN places ON places.id=placesid and users.on_off=1 and users.active=1");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    $em=(($key['email'])." ".($key['emaildop']));
  $data = array($key['usersid'],$key['plname'],$key['fio'],$key['wphone'],$key['sphone'],$em,$key['bi']);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "dialog_users_profile_cont"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT users_profile.homephone AS wphone,users_profile.telephonenumber AS sphone,users_profile.emaildop AS emaildop,users_profile.birthday AS bi,places.id AS placesid, users.id as usersid,users.fio as fio,users.email as email, users_profile.jpegphoto as photo, users_profile.post as post FROM users INNER JOIN users_profile ON usersid=users.id INNER JOIN places_users ON userid=users.id INNER JOIN places ON places.id=placesid WHERE users.id = :id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $post = $row['post'];
    $mobile = $row['sphone'];
    $work_number = $row['wphone'];
    $birthday = $row['bi'];
    $emaildop = $row['emaildop'];
    $photo = $row['photo'];
    $placesid = $row['placesid'];
    $email = $row['email'];
    $fio = $row['fio'];
  }
  $photo = $photo."?".time();
  ?>
  <style>
      .cropped>img
      {
          margin-right: 10px;
      }
  </style>
  <script type="text/javascript">
      var Avatar = "images/avatar/<?php echo "$photo";?>";
      var Fio = "<?php echo "$fio";?>";
  </script>
  <?php
  if (validate_priv($_SESSION['dilema_user_id']) == 1){
  ?>
  <script type="text/javascript">
      var Admin = true;
  </script>
  <?php
  }
  else {
    ?>
    <script type="text/javascript">
        var Admin = false;
    </script>
    <?php
  }
   ?>
  <form id="myForm_edit_profile" class="well form-inline" method="post" >
<div class="row">
  <?php
  if (validate_priv($_SESSION['dilema_user_id']) == 1) {
   ?>
  <div class="col-md-4">
    <?php
  }else{
    ?>
    <div class="col-md-6">
    <?php
  }
if (validate_priv($_SESSION['dilema_user_id']) == 1) {
     ?>
    <label class="control-label"><small>Кабинет</small></label>
    <select data-placeholder="Выберите помещение" class='my_select select' name="placesid" id="placesid">
   	<option value=""></option>
   <?php
   $morgs=GetArrayPlaces();
   for ($i = 0; $i < count($morgs); $i++) {
       $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
       if ($nid==$placesid){$sl=" selected";} else {$sl="";};
       echo "<option value=$nid $sl>$nm</option>";
   };
   ?>
    </select>
    <?php
}
     ?>
      <label class="control-label"><small>Дата Рождения</small></label>
            <input  placeholder="Дата Рождения" maxlenght=10 name="birthday" class="form-control input-sm allwidht" id="birthday" type="text" value="<?php echo "$birthday";?>" autocomplete="off">

    <label class="control-label"><small>Рабочий телефон</small></label>
            <input placeholder="Рабочий телефон" class="form-control input-sm allwidht" name="work_number" id="work_number" type="text" value="<?php echo "$work_number";?>" autocomplete="off">

            <div class="form-group" id="email_grp" style="display:inline;">
      <label class="control-label"><small>Основной email</small></label>
      <input placeholder="Основной email" name="email" id="email" type="email" class="form-control input-sm allwidht" value="<?php echo "$email";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
      </div>
</div>
<?php
if (validate_priv($_SESSION['dilema_user_id']) == 1) {
 ?>
<div class="col-md-4">
  <?php
}else{
  ?>
  <div class="col-md-6">
  <?php
}
   ?>
  <label class="control-label"><small>Должность</small></label>
  <input placeholder="Должность" name="post" id="post" type="text" class="form-control input-sm allwidht" value="<?php echo "$post";?>" autocomplete="off">

  <label class="control-label"><small>Сотовый телефон</small></label>

  <input name="mobile" id="mobile" placeholder="+7 (123) 123-45-67" type="tel" class="form-control input-sm allwidht" value="<?php echo "$mobile";?>" autocomplete="off">


  <label class="control-label"><small>Дополнительный email</small></label>
  <input placeholder="Дополнительный email" name="emaildop" id="emaildop" type="text" class="form-control input-sm allwidht" value="<?php echo "$emaildop";?>" autocomplete="off">
</div>
<?php
if (validate_priv($_SESSION['dilema_user_id']) == 1) {
 ?>
<div class="col-md-4">
  <div id="img_show"  class="center_all" style="margin-top:20px;">
    <img src="images/avatar/<?php echo $photo?>" class="img-circle" alt="Responsive image">
    <div style="margin-top:5px;">
      <div class="btn-group">
    <button class="btn btn-primary" type="button" id="ch_img" style="width: 75px;">Сменить</button>
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
      <li><a href="#" id="img_del_users_cont"><?=get_lang('Delete');?></a></li>
    </ul>
  </div>
  </div>
  </div>
<div id="change_img">
<div class="imageBox">
  <div class="thumbBox"></div>
  <div class="spinner" style="display: none">Loading...</div>
</div>
<div class="action">
  <input type="file" id="file">
  <div class="btn-group btn-group-justified">
    <div class="btn-group">
      <button type="button" class="btn btn-primary" id="btn_file" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_upload');?>"><i class="fa fa-upload" aria-hidden="true"></i>
</div>
<div class="btn-group">
  <button class="btn btn-primary" type="button" id="btnZoomIn" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomin');?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
</div>
<div class="btn-group">
  <button class="btn btn-primary" type="button" id="btnZoomOut" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_zoomout');?>"><i class="fa fa-minus" aria-hidden="true"></i></button>
</div>
<div class="btn-group">
  <button class="btn btn-primary" type="button" id="btnRotate" data-toggle="tooltip" data-placement="bottom" title="<?=get_lang('Img_rotate');?>"><i class="fa fa-rotate-right" aria-hidden="true"></i></button>
</div>

</div>
</div>
</div>
</div>
<?php
}
 ?>
</div>
      <div class="center_submit">
      <button type="submit" id="edit_profile_cont" name="edit_profile_cont" class="btn btn-success"><?=get_lang('Save');?></button>
    </div>
  </form>
  <?php
}
if ($mode == "contact_print"){
  ?>
  <style>
  body{
    -webkit-print-color-adjust: exact;
  }
  </style>
  <table  id="mytable" align="center" style="border-collapse: collapse" class="table">
  <thead>
  <tr>
  <tr>
  <th align="left"><?=get_lang('Places');?></th>
  <th align="center"><?=get_lang('Fio');?></th>
  <th align="center"><?=get_lang('Tel');?></th>
  </tr>
  </thead>
  <tbody>

  <?php
    $stmt = $dbConnection->prepare ("SELECT users_profile.id AS usprofid,users_profile.homephone AS wphone,places.name AS plname, users.id,users.fio as fio,users.on_off as on_off FROM users RIGHT JOIN users_profile ON users.id=usersid INNER JOIN places_users ON users.id=userid INNER JOIN places ON places.id=placesid where users.on_off=1 and users_profile.homephone !=' ' order by users.fio");
    $stmt->execute();
    $res1 = $stmt->fetchAll();
    foreach($res1 as $row){
      $color_table = ($color_table == '#fff')?'#f5f5f5':'#fff';

    echo "<tr bgcolor='$color_table'>";
  $pom=$row['plname'];
  $fio=$row['fio'];
  $tel=$row['wphone'];
  echo "<td align=\"left\">$pom</td>";
  echo "<td align=\"left\">$fio</td>";
  echo "<td align=\"center\">$tel</td>";
  echo "</tr>";

  	};
  ?>
  </tbody>
  </table>
  <?php
}
if ($mode == "vendors_table"){
  $stmt = $dbConnection->prepare ("SELECT id,name,comment,active FROM vendor");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    if ($key['active']=="1") {$active="active";} else {$active="not_active";};
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"vendors_edit\" class=\"btn btn-xs btn-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\"><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"vendors_del\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";
  $data = array($active,$key['id'],$key['name'],$key['comment'],$act);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "dialog_vendors_add"){
  ?>
  <form id="myForm_vendors_add" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="vendors_grp" style="display:inline;">
      <label class="control-label"><small>Наименование производителя:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование производителя" name="vendors" id="vendors" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<p></p>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="add_vendors" class="btn btn-success"><?=get_lang('Add');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_vendors_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT name,comment FROM vendor WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $vendor_name = $row['name'];
    $comment = $row['comment'];
  }
  ?>
  <form id="myForm_vendors_edit" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="vendors_grp" style="display:inline;">
      <label class="control-label"><small>Наименование производителя:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование производителя" name="vendors" id="vendors" value="<?php echo "$vendor_name";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<p></p>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"><?php echo "$comment";?></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="edit_vendors" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "vendors_add"){
  $vendor_name = ($_POST['vendors']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ("INSERT INTO vendor (id,name,comment,active) VALUES (null,:name,:comment,1)");
  $stmt->execute(array(':name' => $vendor_name, ':comment' => $comment));
}
if ($mode == "vendors_edit"){
  $id = $_POST['id'];
  $vendor_name = ($_POST['vendors']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ("UPDATE vendor SET name=:name,comment=:comment WHERE id=:id");
  $stmt->execute(array(':name' => $vendor_name, ':comment' => $comment, ':id' => $id));
}
if ($mode == "vendors_delete"){
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE vendor SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM vendor WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,vendor) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE vendor = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "nome_table"){
  $stmt = $dbConnection->prepare ("SELECT nome.id as nomeid,group_nome.name as groupname,vendor.name as vendorname,nome.name as nomename,nome.active as nomeactive FROM nome INNER JOIN group_nome ON group_nome.id=nome.groupid INNER JOIN vendor ON nome.vendorid=vendor.id");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    if ($key['nomeactive']=="1") {$active="active";} else {$active="not_active";};
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"nome_edit\" class=\"btn btn-xs btn-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\"><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"nome_del\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";
  $data = array($active,$key['nomeid'],$key['groupname'],$key['vendorname'],$key['nomename'],$act);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "dialog_nome_add"){
  ?>
  <form id='myForm_nome_add' class="well form-inline" method="post">
  <div class="row">
  <div class="col-md-6">
    <div class="form-group" id="group_grp" style="display:inline;">
   <label class="control-label"><small>Группа:</small></label>
 </div>
    <div id="group_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите группу" class="my_select select" name="groupid" id="groupid">
  	<option value=""></option>
    <?php
                  $morgs=GetArrayGroup();
                  for ($i = 0; $i < count($morgs); $i++) {
                      $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                      if ($nid==$groupid){$sl=" selected";} else {$sl="";};
                      echo "<option value=$nid $sl>$nm</option>";
                  };
              ?>
   </select>
 </div>
  </div>
  <div class="col-md-6">
    <div class="form-group" id="vendors_grp" style="display:inline;">
   <label class="control-label"><small>Производитель:</small></label>
 </div>
    <div id="vendors_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
   <select data-placeholder="Выберите производителя" class="my_select select" name="vendorid" id="vendorid">
  	<option value=""></option>
    <?php
       $morgs=GetArrayVendor();
       for ($i = 0; $i < count($morgs); $i++) {
           $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
           if ($nid==$vendorid){$sl=" selected";} else {$sl="";};
           echo "<option value=$nid $sl>$nm</option>";
       };
   ?>
   </select>
 </div>
   </div>
  </div>
<p></p>
<div class="form-group" id="namenome_grp" style="display:inline;">
  <label class="control-label"><small><?=get_lang('Namenome');?>:</small></label>
  <input class="form-control input-sm allwidht" type="text"  placeholder="Введите наименование номенклатуры" name="namenome" id="namenome" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>

   <div class="center_submit">
  	<button type="submit" class="btn btn-success" id="add_nome"><?=get_lang('Add');?></button>
   </div>
  </form>
  <?php
}
if ($mode == "dialog_nome_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT * FROM nome WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow){
          $groupid=$myrow['groupid'];
          $vendorid=$myrow['vendorid'];
          $name=htmlspecialchars($myrow['name']);
};
  ?>
  <form id='myForm_nome_edit' class="well form-inline" method="post">
    <div class="row">
    <div class="col-md-6">
      <div class="form-group" id="group_grp" style="display:inline;">
     <label class="control-label"><small>Группа:</small></label>
   </div>
      <div id="group_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
     <select data-placeholder="Выберите группу" class="my_select select" name="groupid" id="groupid">
    	<option value=""></option>
      <?php
                    $morgs=GetArrayGroup();
                    for ($i = 0; $i < count($morgs); $i++) {
                        $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                        if ($nid==$groupid){$sl=" selected";} else {$sl="";};
                        echo "<option value=$nid $sl>$nm</option>";
                    };
                ?>
     </select>
   </div>
    </div>
    <div class="col-md-6">
      <div class="form-group" id="vendors_grp" style="display:inline;">
     <label class="control-label"><small>Производитель:</small></label>
   </div>
      <div id="vendors_p" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="top" data-content="<?= get_lang('Toggle_title_select'); ?>">
     <select data-placeholder="Выберите производителя" class="my_select select" name="vendorid" id="vendorid">
    	<option value=""></option>
      <?php
         $morgs=GetArrayVendor();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
             if ($nid==$vendorid){$sl=" selected";} else {$sl="";};
             echo "<option value=$nid $sl>$nm</option>";
         };
     ?>
     </select>
   </div>
     </div>
    </div>
<p></p>
<div class="form-group" id="namenome_grp" style="display:inline;">
  <label class="control-label"><small><?=get_lang('Namenome');?>:</small></label>
  <input class="form-control input-sm allwidht" type="text"  placeholder="Введите наименование номенклатуры" name="namenome" id="namenome" value="<?php echo "$name";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>

   <div class="center_submit">
  	<button type="submit" class="btn btn-success" id="edit_nome"><?=get_lang('Edit');?></button>
   </div>
  </form>
  <?php
}
if ($mode == "nome_add"){
  $vendorid = ($_POST['vendorid']);
  $groupid = ($_POST['groupid']);
  $namenome = ($_POST['namenome']);
  $stmt = $dbConnection->prepare ("INSERT INTO nome (id,groupid,vendorid,name,active) VALUES (NULL,:groupid,:vendorid,:namenome,1)");
  $stmt->execute(array(':groupid' => $groupid, ':vendorid' => $vendorid, ':namenome' => $namenome));
}
if ($mode == "nome_edit"){
  $id = $_POST['id'];
  $vendorid = ($_POST['vendorid']);
  $groupid = ($_POST['groupid']);
  $namenome = ($_POST['namenome']);
  $stmt = $dbConnection->prepare ("UPDATE nome SET groupid=:groupid,vendorid=:vendorid,name=:namenome WHERE id=:id");
  $stmt->execute(array(':groupid' => $groupid, ':vendorid' => $vendorid, ':namenome' => $namenome, ':id' => $id));
}
if ($mode == "nome_delete"){
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE nome SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM nome WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,nome) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE nome = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "equipment_photo"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT photo FROM equipment WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $photo = $row['photo'];
  echo $photo;
}
if ($mode == "edit_profile_to_user") {
  define('UPLOAD_DIR', 'images/avatar/');
    $l=($_POST['login']);
    $m=($_POST['mail']);
    $m_d=($_POST['mail_d']);
    $id=($_POST['id']);
    $lang=($_POST['lang']);
      $img = $_POST['img'];
      $stmt = $dbConnection->prepare ('SELECT jpegphoto FROM users_profile WHERE usersid=:id');
      $stmt->execute(array(':id' => $id));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $photo = $row['jpegphoto'];
      if ($_POST['img'] != ''){
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      if (($photo != '') && ($photo != 'noavatar.png')){
      if (file_exists(UPLOAD_DIR . $photo)){
        $file = $photo;
      }
      else{
      $file = uniqid() . '.png';
      }
    }
    else {
      $file = uniqid() . '.png';
    }
      $success = file_put_contents(UPLOAD_DIR . $file, $data);
      // print $success ? $file : 'Unable to save the file.';
    }
    else {
      if ($photo != ''){
        $file = $photo;
      }
      else {
        $file = 'noavatar.png';
      }
    }
    $ec=0;
    if (!validate_alphanumeric_underscore($l)) { $ec=1;}
    if (!validate_email($m)) {$ec=1;}
    if (!validate_exist_mail($m)) {$ec=1;}

    if ($ec == 0) {
        $stmt = $dbConnection->prepare('update users set login=:l, email=:m, lang=:lang where id=:id');
        $stmt->execute(array(':id' => $id,':l' => $l,':m' => $m,':lang' => $lang));

        $stmt = $dbConnection->prepare('update users_profile set emaildop=:m_d, jpegphoto=:jpegphoto where usersid=:id');
        $stmt->execute(array(':id' => $id, ':m_d' => $m_d, ':jpegphoto' => $file));

        ?>
        <div class="alert alert-success">
            <?=get_lang('PROFILE_msg_ok');?>
        </div>
    <?php
    }
    if ($ec == 1) {
        ?>
        <div class="alert alert-danger">
            <?=get_lang('PROFILE_msg_error');?>
        </div>
    <?php
    }
}
if ($mode == "delete_profile_img_to_user"){
  $id = $_POST['id'];
  $file = 'noavatar.png';
  $stmt = $dbConnection->prepare ('SELECT jpegphoto FROM users_profile WHERE usersid=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $photo = $row['jpegphoto'];
  if ($photo != $file){
unlink(realpath(dirname(__FILE__))."/images/avatar/".$photo);
  $stmt = $dbConnection->prepare('update users_profile set jpegphoto=:jpegphoto where usersid=:id');
  $stmt->execute(array(':id' => $id, ':jpegphoto' => $file));
  ?>
  <div class="alert alert-success">
      <?=get_lang('PROFILE_msg_img_delete');?>
  </div>
  <?php
}
}
if ($mode == "show_img"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT jpegphoto FROM users_profile WHERE usersid=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $photo = $row['jpegphoto'];
  echo $photo;
}
if ($mode == "show_img_eq"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ('SELECT photo FROM equipment WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $photo = $row['photo'];
  echo $photo;
}
if ($mode == "delete_profile_img"){
  $id = $_POST['id'];
  $file = 'noavatar.png';
  $stmt = $dbConnection->prepare ('SELECT jpegphoto FROM users_profile WHERE usersid=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $photo = $row['jpegphoto'];
  if ($photo != $file){
unlink(realpath(dirname(__FILE__))."/images/avatar/".$photo);
  $stmt = $dbConnection->prepare('update users_profile set jpegphoto=:jpegphoto where usersid=:id');
  $stmt->execute(array(':id' => $id, ':jpegphoto' => $file));
}
}
if ($mode == "delete_equipment_img"){
  $id = $_POST['id'];
  $file = 'noimage.png';
  $stmt = $dbConnection->prepare ('SELECT photo FROM equipment WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $photo = $row['photo'];
  if ($photo != $file){
  unlink(realpath(dirname(__FILE__))."/images/equipment/".$photo);
  $stmt = $dbConnection->prepare('update equipment set photo=:photo where id=:id');
  $stmt->execute(array(':id' => $id, ':photo' => $file));
}
}
if ($mode == "edit_profile_pass") {
    $p_old=($_POST['old_pass']);
    $p_new=($_POST['new_pass']);
    $p_new2=($_POST['new_pass2']);
    $id=($_POST['id']);




    $stmt = $dbConnection->prepare('select pass from users where id=:id');
    $stmt->execute(array(':id' => $id));
    $total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);


    $pass_orig=$total_ticket['pass'];

    $ec=0;

    if ($pass_orig <> $p_old) {
        $ec=1;
        $text=get_lang('PROFILE_msg_pass_err');
    }

    if ($p_new <> $p_new2) {
        $ec=1;
        $text=get_lang('PROFILE_msg_pass_err2');
    }

    if (strlen($p_new) < 3) {
        $ec=1;
        $text=get_lang('PROFILE_msg_pass_err3');
    }




    if ($ec == 0) {


        $stmt = $dbConnection->prepare('update users set pass=:p_new where id=:id');
        $stmt->execute(array(':id' => $id,':p_new' => $p_new));

        session_destroy();
        unset($_SESSION);
        session_unset();
        setcookie('authhash_usid', "");
        setcookie('authhash_uscode', "");
        setcookie('cookieorgid', "");
        setcookie('lang_cookie', "");
        setcookie('on_off_cookie', "");
        unset($_COOKIE['authhash_usid']);
        unset($_COOKIE['authhash_uscode']);
        unset($_COOKIE['cookieorgid']);
        unset($_COOKIE['lang_cookie']);
        unset($_COOKIE['on_off_cookie']);


        ?>
        <div class="alert alert-success">
            <?=get_lang('PROFILE_msg_pass_ok');?>
        </div>
    <?php
    }
    if ($ec == 1) {
        ?>
        <div class="alert alert-danger">
            <?=get_lang('PROFILE_msg_te');?> <?=$text;?>
        </div>
    <?php
    }
}
if ($mode == "requisites_table"){
  $stmt = $dbConnection->prepare ("SELECT id,name,INN,KPP,ind,tel,address,active FROM requisites");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    if ($key['active']=="1") {$active="active";} else {$active="not_active";};

  $data = array($active,$key['id'],$key['name'],$key['INN'],$key['KPP'],$key['ind'],$key['tel'],$key['address']);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "requisites_files_table"){
  if ($_POST['id'] !=''){
  $idrequisites = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT * FROM files_requisites WHERE idrequisites = :id ");
  $stmt->execute(array(':id' => $idrequisites));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    $filename=$key['filename'];
    $userfreandlyfilename=$key['userfreandlyfilename'];
    $dt=MySQLDateToDate($key['dt']);
    $id_requisites = $key['id'];
    $file = "<a target=_blank href=".$CONF['hostname']."sys/download.php?step=requisites&id=".$id_requisites.">".$userfreandlyfilename."</a>";
    $data = array($key['id'],$dt,$file);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "requisites_add"){
  $name = ($_POST['name']);
  $inn = ($_POST['inn']);
  $kpp = ($_POST['kpp']);
  $ind = ($_POST['index']);
  $tel = ($_POST['tel']);
  $address = ($_POST['address']);

  $stmt = $dbConnection->prepare ("INSERT INTO requisites (id,name,INN,KPP,ind,tel,address,active) VALUES (null,:name,:inn,:kpp,:ind,:tel,:address,1)");
  $stmt->execute(array(':name' => $name, ':inn' => $inn, ':kpp' => $kpp, ':ind' => $ind, ':tel' => $tel, ':address' => $address));

}
if ($mode == "requisites_edit"){
  $id = $_POST['id'];
  $name = ($_POST['name']);
  $inn = ($_POST['inn']);
  $kpp = ($_POST['kpp']);
  $ind = ($_POST['index']);
  $tel = ($_POST['tel']);
  $address = ($_POST['address']);

  $stmt = $dbConnection->prepare ("UPDATE requisites SET name=:name,address=:address,INN=:inn,KPP=:kpp,ind=:ind,tel=:tel WHERE id=:id");
  $stmt->execute(array(':name' => $name, ':inn' => $inn, ':kpp' => $kpp, ':ind' => $ind, ':tel' => $tel, ':address' => $address, ':id' => $id));

}
if ($mode == "requisites_file_delete"){
  $id = $_POST['id'];
  $id = explode(",",$id);
foreach ($id as $ids) {
  $stmt = $dbConnection->prepare('SELECT filename, file_ext FROM files_requisites WHERE id = :id');
      $stmt->execute(array(':id'=> $ids));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


                  $stmt = $dbConnection->prepare("delete FROM files_requisites where id=:id");
                  $stmt->execute(array(':id'=> $ids));
  unlink(realpath(dirname(__FILE__))."/files/requisites/".$row['filename'].".".$row['file_ext']);
}
}
if ($mode == "dialog_requisites_add"){
  ?>
  <form id="myForm_requisites_add" class="well form-inline" method="post">
  <div class="row">
    <div class="col-md-6">
        <div class="form-group" id="name_org_grp" style="display:inline;">
      <label class="control-label"><small>Имя:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Имя организации" name="name_org" id="name_org" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<label class="control-label"><small>Инн:</small></label>
<input class="input-sm form-control allwidht" placeholder="Инн" name="inn" id="inn" autocomplete="off">
<label class="control-label"><small>Кпп:</small></label>
<input class="input-sm form-control allwidht" placeholder="Кпп" name="kpp" id="kpp" autocomplete="off">
</div>
<div class="col-md-6">
  <label class="control-label"><small>Индекс:</small></label>
<input class="input-sm form-control allwidht" placeholder="Индекс" name="index" id="index" autocomplete="off">
<label class="control-label"><small>Телефон:</small></label>
<input class="input-sm form-control allwidht" placeholder="Телефон" name="tel" id="tel" autocomplete="off">
<label class="control-label"><small>Адрес:</small></label>
<input class="input-sm form-control allwidht" placeholder="Адрес организации" name="address" id="address" autocomplete="off">
</div>
  </div>
  <div class="center_submit">
  <button type="submit" id="add_requisites" class="btn btn-success"><?=get_lang('Add');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_requisites_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT id,name,INN,KPP,ind,tel,address FROM requisites WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $name = htmlspecialchars($row['name']);
    $inn = $row['INN'];
    $kpp = $row['KPP'];
    $index = $row['ind'];
    $tel = $row['tel'];
    $address = $row['address'];

  }
  ?>
  <form id="myForm_requisites_edit" class="well form-inline" method="post">
  <div class="row">
    <div class="col-md-6">
        <div class="form-group" id="name_org_grp" style="display:inline;">
      <label class="control-label"><small>Имя:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Имя организации" value="<?php echo "$name";?>" name="name_org" id="name_org" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<label class="control-label"><small>Инн:</small></label>
<input class="input-sm form-control allwidht" placeholder="Инн" value="<?php echo "$inn";?>" name="inn" id="inn" autocomplete="off">
<label class="control-label"><small>Кпп:</small></label>
<input class="input-sm form-control allwidht" placeholder="Кпп" value="<?php echo "$kpp";?>" name="kpp" id="kpp" autocomplete="off">
</div>
<div class="col-md-6">
  <label class="control-label"><small>Индекс:</small></label>
<input class="input-sm form-control allwidht" placeholder="Индекс" name="index" value="<?php echo "$index";?>" id="index" autocomplete="off">
<label class="control-label"><small>Телефон:</small></label>
<input class="input-sm form-control allwidht" placeholder="Телефон" name="tel" value="<?php echo "$tel";?>" id="tel" autocomplete="off">
<label class="control-label"><small>Адрес:</small></label>
<input class="input-sm form-control allwidht" placeholder="Адрес организации" value="<?php echo "$address";?>" name="address" id="address" autocomplete="off">
</div>
  </div>
  <div class="center_submit">
  <button type="submit" id="edit_requisites" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "requisites_delete"){
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE requisites SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM requisites WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,requisites) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE requisites = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "knt_table"){
  $stmt = $dbConnection->prepare ("SELECT id,name,INN,KPP,comment,active FROM knt");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    if ($key['active']=="1") {$active="active";} else {$active="not_active";};

  $data = array($active,$key['id'],$key['name'],$key['INN'],$key['KPP'],$key['comment']);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "knt_files_table"){
  if ($_POST['id'] !=''){
  $idrequisites = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT * FROM files_contractor WHERE idcontract = :id ");
  $stmt->execute(array(':id' => $idrequisites));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    $filename=$key['filename'];
    $userfreandlyfilename=$key['userfreandlyfilename'];
    $id_contractor = $key['id'];
    $file = "<a target=_blank href=".$CONF['hostname']."sys/download.php?step=contractor&id=".$id_contractor.">".$userfreandlyfilename."</a>";
    $data = array($key['id'],$file);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "knt_add"){
  $name = ($_POST['name']);
  $inn = ($_POST['inn']);
  $kpp = ($_POST['kpp']);
  $comment = ($_POST['comment']);

  $stmt = $dbConnection->prepare ("INSERT INTO knt (id,name,INN,KPP,comment,active) VALUES (null,:name,:inn,:kpp,:comment,1)");
  $stmt->execute(array(':name' => $name, ':inn' => $inn, ':kpp' => $kpp, ':comment' => $comment));

}
if ($mode == "knt_edit"){
  $id = $_POST['id'];
  $name = ($_POST['name']);
  $inn = ($_POST['inn']);
  $kpp = ($_POST['kpp']);
  $comment = ($_POST['comment']);

  $stmt = $dbConnection->prepare ("UPDATE knt SET name=:name,INN=:inn,KPP=:kpp,comment=:comment WHERE id=:id");
  $stmt->execute(array(':name' => $name, ':inn' => $inn, ':kpp' => $kpp, ':comment' => $comment, ':id' => $id));


}
if ($mode == "knt_file_delete"){
  $id = $_POST['id'];
  $id = explode(",",$id);
foreach ($id as $ids) {
  $stmt = $dbConnection->prepare('SELECT filename, file_ext FROM files_contractor WHERE id = :id');
      $stmt->execute(array(':id'=> $ids));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


                  $stmt = $dbConnection->prepare("delete FROM files_contractor where id=:id");
                  $stmt->execute(array(':id'=> $ids));
  unlink(realpath(dirname(__FILE__))."/files/contractor/".$row['filename'].".".$row['file_ext']);
}
}
if ($mode == "dialog_knt_add"){
  ?>
  <form id="myForm_requisites_add" class="well form-horizontal" method="post">
  <div class="row">
        <div class="form-group" id="name_knt_grp">
          <div class="col-sm-4 text-right">
      <label class="control-label"><small>Имя:</small></label>
    </div>
    <div class="col-sm-6">
  <input class="input-sm form-control allwidht" placeholder="Имя организации" name="name_knt" id="name_knt" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
</div>
<div class="form-group">
<div class="col-sm-4 text-right">
<label class="control-label"><small>Инн:</small></label>
</div>
<div class="col-sm-6">
<input class="input-sm form-control allwidht" placeholder="Инн" name="inn_knt" id="inn_knt" autocomplete="off">
</div>
</div>
<div class="form-group">
<div class="col-sm-4 text-right">
<label class="control-label"><small>Кпп:</small></label>
</div>
<div class="col-sm-6">
<input class="input-sm form-control allwidht" placeholder="Кпп" name="kpp_knt" id="kpp_knt" autocomplete="off">
</div>
</div>
<div class="form-group">
<div class="col-sm-4 text-right">
<label class="control-label"><small><?= get_lang('Comment');?>:</small></label>
</div>
<div class="col-sm-6">
  <textarea class="form-control allwidht" rows="4" name="comment" placeholder="<?=get_lang('Comment_placeholder');?>" id="comment"></textarea>
</div>
</div>
</div>
  <div class="center_submit">
  <button type="submit" id="add_knt" class="btn btn-success"><?=get_lang('Add');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_knt_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT name,INN,KPP,comment FROM knt WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $name = htmlspecialchars($row['name']);
    $inn = $row['INN'];
    $kpp = $row['KPP'];
    $comment = htmlspecialchars($row['comment']);

  }
  ?>
  <form id="myForm_knt_edit" class="well form-horizontal" method="post">
    <div class="row">
          <div class="form-group" id="name_knt_grp">
            <div class="col-sm-4 text-right">
        <label class="control-label"><small>Имя:</small></label>
      </div>
      <div class="col-sm-6">
    <input class="input-sm form-control allwidht" placeholder="Имя организации" name="name_knt" id="name_knt" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off" value="<?php echo "$name";?>">
  </div>
  </div>
  <div class="form-group">
  <div class="col-sm-4 text-right">
  <label class="control-label"><small>Инн:</small></label>
  </div>
  <div class="col-sm-6">
  <input class="input-sm form-control allwidht" placeholder="Инн" name="inn_knt" id="inn_knt" autocomplete="off" value="<?php echo "$inn";?>">
  </div>
  </div>
  <div class="form-group">
  <div class="col-sm-4 text-right">
  <label class="control-label"><small>Кпп:</small></label>
  </div>
  <div class="col-sm-6">
  <input class="input-sm form-control allwidht" placeholder="Кпп" name="kpp_knt" id="kpp_knt" autocomplete="off" value="<?php echo "$kpp";?>">
  </div>
  </div>
  <div class="form-group">
  <div class="col-sm-4 text-right">
  <label class="control-label"><small><?= get_lang('Comment');?>:</small></label>
  </div>
  <div class="col-sm-6">
    <textarea class="form-control allwidht" rows="4" name="comment" placeholder="<?=get_lang('Comment_placeholder');?>" id="comment"><?php echo "$comment";?></textarea>
  </div>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="edit_knt" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "knt_delete"){
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE knt SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM knt WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,knt) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE knt = :id');
  $stmt->execute(array(':id' => $id));
}
}
if ($mode == "dialog_eq_param_add"){
  ?>
  <style>
  .typeahead {
    width: 230px;
    max-height: 200px;
    overflow-y: auto;
  }
  </style>
  <form id="myForm_eq_param_add" class="well form-inline" method="post">
    <div class="row">
      <div class="col-md-12">
        <button type="button" id="add_input" class="btn btn-primary"><?= get_lang('Add_row_param')?></button>
      </div>
      <div class="col-md-12">
  <div class="input_fields_wrap">
  </div>
</div>
</div>
<div class="center_submit">
<button type="submit" id="add_param" class="btn btn-success"><?=get_lang('Add');?></button>
</div>
</form>
  <?php
}
if ($mode == "eq_param_add"){
  $total_input = $_POST['total_input'];
  $id = $_POST['id'];
    for ($g = 1; $g <= $total_input; $g++){
      $eq_param_gr = $_POST['eq_param_gr_'.$g];
      $eq_param_name = $_POST['eq_param_name_'.$g];
      $eq_param_comment = $_POST['eq_param_comment_'.$g];
      // var_dump($eq_param_gr);
      // var_dump($eq_param_name);
      $stmt = $dbConnection->prepare ('INSERT INTO eq_param (id,eqid,pname,param,comment) VALUES (NULL,:eqid,:eq_param_gr,:eq_param_name,:comment)');
      $stmt->execute(array(':eqid' => $id, ':eq_param_gr' => $eq_param_gr, ':eq_param_name' => $eq_param_name, ':comment' => $eq_param_comment));
    }
}
if ($mode == "show_input"){
  $total_input = $_POST['total_input'];
  ?>
  <div class="rows_add">
    <div class="form-group" id="eq_param_gr_grp_<?php echo $total_input?>">
    <input type="text" class="form-control input-sm" name="eq_param_gr_<?php echo $total_input?>" id="eq_param_gr" data-provide="typeahead" autocomplete="off" placeholder="Параметр" style="width:230px;margin: 0 auto;" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>"/>
  </div>
  <div class="form-group" id="eq_param_name_grp_<?php echo $total_input?>">
    <input type="text" class="form-control input-sm" name="eq_param_name_<?php echo $total_input?>" placeholder="Наименование" style="width:230px;margin: 0 auto;" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>"/>
  </div>
  <div class="form-group" id="eq_param_comment_grp_<?php echo $total_input?>">
    <input type="text" class="form-control input-sm" name="eq_param_comment_<?php echo $total_input?>" placeholder="Комментарий" style="width:230px;margin: 0 auto;" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title'); ?>"/>
  </div>
    <button type="button" id="remove_field" class="btn_del btn btn-sm btn-primary" name="remove_field" data-toggle="tooltip" data-placement="bottom" title="<?= get_lang('Delete_toggle')?>"><i class="fa fa-remove fa-fw" aria-hidden="true"></i></button>
  </div>
  <?php
}
if ($mode == "eqparam_show"){
  if (isset($_POST['query'])) {
    $query = $_POST['query'];
  $stmt = $dbConnection->prepare('SELECT pname FROM eq_param group by pname');
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  $array  = array();
  foreach($res1 as $row) {

    $array[]=$row['pname'];

  }
  echo json_encode($array);
  }
}
if ($mode == "param_delete"){
  $id=$_POST["id"];

  $stmt = $dbConnection->prepare ('DELETE FROM eq_param WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  echo "ok";
}
if ($mode == "dialog_eq_param_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT pname,param,comment FROM eq_param WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $pname = htmlspecialchars($row['pname']);
    $param = htmlspecialchars($row['param']);
    $comment = htmlspecialchars($row['comment']);

  }
  ?>
  <style>
  .typeahead {
    width: 230px;
    max-height: 200px;
    overflow-y: auto;
  }
  </style>
  <form id="myForm_eq_param_add" class="well form-inline" method="post">
    <div class="row">
      <div class="col-md-12">
        <div class="center_all">
        <div class="form-group" id="eq_param_gr_grp">
        <input type="text" class="form-control input-sm" name="eq_param_gr" id="eq_param_gr" data-provide="typeahead" autocomplete="off" placeholder="Параметр" style="width:230px;margin: 0 auto;" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" value="<?php echo "$pname";?>"/>
      </div>
      <div class="form-group" id="eq_param_name_grp">
        <input type="text" class="form-control input-sm" name="eq_param_name" id="eq_param_name" placeholder="Наименование" style="width:230px;margin: 0 auto;" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>" value="<?php echo "$param";?>"/>
      </div>
      <div class="form-group" id="eq_param_comment_grp">
        <input type="text" class="form-control input-sm" name="eq_param_comment" id="eq_param_comment" placeholder="Комментарий" style="width:230px;margin: 0 auto;" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title'); ?>" value="<?php echo "$comment";?>"/>
      </div>
    </div>
</div>
</div>
<div class="center_submit">
<button type="submit" id="edit_param" class="btn btn-success"><?=get_lang('Edit');?></button>
</div>
</form>
  <?php
}
if ($mode == "eq_param_edit"){
  $id = $_POST['id'];
  $eq_param_gr = ($_POST['eq_param_gr']);
  $eq_param_name = ($_POST['eq_param_name']);
  $eq_param_comment = ($_POST['eq_param_comment']);

  $stmt = $dbConnection->prepare ('UPDATE eq_param SET pname = :pname, param = :param, comment = :comment WHERE id = :id');
  $stmt->execute(array(':id' => $id, ':param' => $eq_param_name, ':pname' => $eq_param_gr, ':comment' => $eq_param_comment));
}
if ($mode == "group_nome_table"){
  $stmt = $dbConnection->prepare ("SELECT id,name,comment,active FROM group_nome");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    if ($key['active']=="1") {$active="active";} else {$active="not_active";};
    $act = "<div class=\"btn-group btn-action\"><button type=\"button\" id=\"group_nome_edit\" class=\"btn btn-xs btn-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Edit_toggle')."\"><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></button><button type=\"button\" id=\"group_nome_del\" class=\"btn btn-xs btn-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_lang('Delete_toggle')."\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button></div>";
  $data = array($active,$key['id'],$key['name'],$key['comment'],$act);
  $output['aaData'][] = $data;
}
  if ($output != ''){
    echo json_encode($output);
  }
  else {
    $data = array('aaData'=>'');
    $output['aaData']=$data;
    echo json_encode($output);
  }
}
if ($mode == "dialog_group_nome_add"){
  ?>
  <form id="myForm_group_nome_add" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="group_grp" style="display:inline;">
      <label class="control-label"><small>Наименование группы:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование группы" name="group" id="group" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<p></p>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="add_group_nome" class="btn btn-success"><?=get_lang('Add');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_group_nome_edit"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT name,comment FROM group_nome WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $vendor_name = $row['name'];
    $comment = $row['comment'];
  }
  ?>
  <form id="myForm_group_nome_edit" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="group_grp" style="display:inline;">
      <label class="control-label"><small>Наименование группы:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование группы" name="group" id="group" value="<?php echo "$vendor_name";?>" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<p></p>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"><?php echo "$comment";?></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="edit_group_nome" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "group_nome_add"){
  $name = ($_POST['group']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ("INSERT INTO group_nome (id,name,comment,active) VALUES (null,:name,:comment,1)");
  $stmt->execute(array(':name' => $name, ':comment' => $comment));
}
if ($mode == "group_nome_edit"){
  $id = $_POST['id'];
  $name = ($_POST['group']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ("UPDATE group_nome SET name=:name,comment=:comment WHERE id=:id");
  $stmt->execute(array(':name' => $name, ':comment' => $comment, ':id' => $id));
}
if ($mode == "group_nome_delete"){
  $id = $_POST['id'];
	$stmt = $dbConnection->prepare ('UPDATE group_nome SET active=not active WHERE id=:id');
  $stmt->execute(array(':id' => $id));

  $stmt = $dbConnection->prepare ('SELECT active FROM group_nome WHERE id=:id');
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $active = $row['active'];
  if ($active == '0'){
  $stmt = $dbConnection->prepare ('INSERT INTO approve (id,group_nome) VALUES (NULL,:id)');
  $stmt->execute(array(':id' => $id));
}
else {
  $stmt = $dbConnection->prepare ('DELETE FROM approve WHERE group_nome = :id');
  $stmt->execute(array(':id' => $id));
}

}
if ($mode == "check_update") {
    $uid=$_SESSION['dilema_user_id'];
    // $ip_addr = $_SERVER["REMOTE_ADDR"];
    // $ip = vsprintf("%03d.%03d.%03d.%03d", explode(".", $ip_addr));

$stmt = $dbConnection->prepare('update users set lastdt=now() where id=:cid');
$stmt->execute(array(':cid' => $uid ));

  echo 'ok';
 }
if ($mode == "select_print"){
  ?>
  <style>
  .chosen-single, .chosen-container-single{
    text-align:left !important;
  }
  </style>
  <select data-placeholder="Быстрый переход к принтеру" style="width:230px;" class='my_select' name="printid_fast" id="printid_fast">
  <option value=""></option>
  <?php
  $cartridge = get_conf_param('what_cartridge');
  $stmt= $dbConnection->prepare("SELECT * FROM nome WHERE active=1 and groupid IN (".$cartridge.") order by name;");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow)
    {$vl=$myrow['id'];
      echo "<option value=$vl";
      if ($myrow["id"]==$nomeid){echo " selected";};
      $nm=$myrow['name'];
      echo ">$nm</option>";
    };
    ?>
  </select>
  <?php
}
if ($mode == "select_group"){
  ?>
  <style>
  .chosen-single, .chosen-container-single{
    text-align:left !important;
  }
  </style>
  <select data-placeholder="Быстрый переход к группе" style="width:200px;" class="my_select" name="groupid_fast" id="groupid_fast">
  <option value=""></option>
   <?php
                 $morgs=GetArrayGroup();
                 for ($i = 0; $i < count($morgs); $i++) {
                     $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
                     if ($nid==$groupid_fast){$sl=" selected";} else {$sl="";};
                     echo "<option value=$nid $sl>$nm</option>";
                 };
             ?>
  </select>
  <?php
}
if ($mode == "select_org"){
  ?>
  <lable><?=get_lang('Select_org');?>: <label>
  <select class='my_select' style="width:200px;" name="org_equipment" id="org_equipment">
  <?php
      $stmt = $dbConnection->prepare("SELECT * FROM org WHERE active=1 order by name;");
      $stmt->execute();
      $res1 = $stmt->fetchAll();
      foreach($res1 as $myrow) {
          echo "<option value=".$myrow["id"];
          if ($myrow["id"]==$_COOKIE['cookieorgid']){echo " selected";};
          echo ">$myrow[name]</option>";
         };
  ?>
  </select>
  <?php
}
if ($mode == "calendar_birthday"){
  $day = $_COOKIE['date'];
  $day_f = explode("-",$day);
  $events = array();
  $stmt = $dbConnection->prepare("SELECT users.fio as fio, users.id as id, users_profile.birthday as birthday FROM users INNER JOIN users_profile ON users.id = users_profile.usersid  WHERE users_profile.birthday !=' ' and users.on_off = 1");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow) {
    $e = array();
    $bi_st = explode(".",$myrow['birthday']);
    if ($bi_st[2] <= $day_f[0]){
    $yearBegin = date("Y",strtotime($day_f[0].'-1 year'));
    $yearEnd = date("Y",strtotime($day_f[0].'+1 year'));
    $years = range($yearBegin, $yearEnd, 1);
    foreach ($years as $year) {
    $bi = DateToMySQLDateBirthday($myrow['birthday']);
    // $test = '<i class="fa fa-birthday-cake"></i>&nbsp;';
    $e['id_bi'] = $myrow['id'];
    $e['title'] = $myrow['fio'];
    $e['start'] = $year."-".$bi." 00:00:00";
    $e['end'] = $year."-".$bi." 23:59:00";
    $e['description'] = "birthday";
    // $e['allDay'] = false;
    array_push($events, $e);
  }
  }
  }
  echo json_encode($events);
}
if ($mode == "calendar_antivirus"){
  $user_id=$_SESSION['dilema_user_id'];
  $permit_users_license = get_conf_param('permit_users_license');
  $permit = explode(",",$permit_users_license);
  foreach ($permit as $permit_id) {
    if ($user_id == $permit_id){
      $priv_license="yes";
    }
  }
  if ((validate_priv($_SESSION['dilema_user_id']) == 1) || ($priv_license == "yes")){
  $events = array();
  $stmt = $dbConnection->prepare("SELECT org.id as id,org.name as name,license.antivirus as antivirus FROM license INNER JOIN org ON org.id = license.organti  WHERE license.active = 1 GROUP BY license.antivirus");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow) {
    $e = array();
    $e['id_anti'] = $myrow['id'];
    $e['title'] = get_lang('End_license')." ".$myrow['name'];
    $e['start'] = $myrow['antivirus']." 00:00:00";
    $e['end'] = $myrow['antivirus']." 23:59:00";
    $e['description'] = "antivirus";
    // $e['allDay'] = false;
    array_push($events, $e);
  }
  echo json_encode($events);
}
}
if ($mode == "documents_table"){
  $stmt = $dbConnection->prepare ("SELECT * FROM files_documents");
  $stmt->execute();
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row => $key){
    $filename=$key['filename'];
    $userfreandlyfilename=$key['userfreandlyfilename'];
    $id_documents = $key['id'];
    $file = "<a target=_blank href=".$CONF['hostname']."sys/download.php?step=documents&id=".$id_documents.">".$userfreandlyfilename."</a>";
    $data = array($key['id'],$file);
    $output['aaData'][] = $data;
  }
    if ($output != ''){
      echo json_encode($output);
    }
    else {
      $data = array('aaData'=>'');
      $output['aaData']=$data;
      echo json_encode($output);
    }
}
if ($mode == "documents_file_delete"){
  $id = $_POST['id'];
  $id = explode(",",$id);
foreach ($id as $ids) {
  $stmt = $dbConnection->prepare('SELECT filename, file_ext FROM files_documents WHERE id = :id');
      $stmt->execute(array(':id'=> $ids));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


                  $stmt = $dbConnection->prepare("delete FROM files_documents where id=:id");
                  $stmt->execute(array(':id'=> $ids));
  unlink(realpath(dirname(__FILE__))."/files/documents/".$row['filename'].".".$row['file_ext']);
}
}
if ($mode == "drag_event"){
  $id = $_POST['id'];
  $event_start = $_POST["event_start"];
  $event_end = $_POST["event_end"];
  $stmt = $dbConnection->prepare ('UPDATE calendar SET event_start=:event_start, event_end=:event_end WHERE id=:id');
  $stmt->execute(array(':event_start' => $event_start, ':event_end' => $event_end, ':id' => $id));
}
if ($mode == "dialog_event_add"){
  ?>
  <form id="myForm_event_add" class="well form-inline" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="event_grp" style="display:inline;">
      <label class="control-label"><small>Наименование события:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование события" name="event_name" id="event_name" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
</div>
<p></p>
<p></p>
<div class="form-group" id="event_date" style="display:inline;">
<label class="control-label" style="display:inline;"><small>Продолжительность события:</small></label>
<div class="input-daterange input-group" id="datepicker">
    <input class="input-sm form-control" type="text" placeholder="Дата начала" name="event_start" id="event_start" readonly='true' data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
    <span class="input-group-addon">по</span>
    <input class="input-sm form-control" type="text" placeholder="Дата окончания" name="event_end" id="event_end" readonly='true' data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off">
  </div>
</div>
<p></p>
</div>
<div class="col-md-6 center_all">
  <label class="control-label" style="display:inline; "><small><?=get_lang('Remind');?></small></label>
</div>
<div class="col-md-6 center_all">
  <label class="control-label" style="display:inline;"><small><?=get_lang('Repeat');?></small></label>
</div>
<div>
<select data-placeholder="<?=get_lang('Cal_place');?>" class="my_select form-control input-sm" id="remind" name="remind" style="width: 49% !important;">
          <option value="0"></option>

              <option  value="3">За день</option>
              <option  value="2">За 1 неделю</option>
              <option  value="1">За месяц</option>

</select>
&nbsp;
<select data-placeholder="<?=get_lang('Cal_place');?>" class="my_select form-control input-sm" id="event_repeat" name="event_repeat" style="width: 49% !important;">
          <option value="0"></option>

              <option  value="3">Каждую неделю</option>
              <option  value="2">Каждый месяц</option>
              <option  value="1">Каждый год</option>

</select>
</div>
<br>
<div class="input-group col-sm-12">
  <span class="events form-control" style="background-color:#b8e77d; color:#333;text-align:center;"><?=get_lang('Event_example');?></span>
  <span class="input-group-addon" style="width:50px;" id="color-event" val="#b8e77d"><?=get_lang('Color_event');?></span>
  <span class="input-group-addon" style="width:50px;" id="color-event-text" val="#333"><?=get_lang('Color_text');?></span>
</div>
<div class="center_all">
<br>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="event_add" class="btn btn-success"><?=get_lang('Add');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "dialog_event_edit_del"){
  $id = $_POST['id'];
  $stmt = $dbConnection->prepare ("SELECT event_name,event_start,event_end,comment,remind,event_repeat,color,textcolor FROM calendar WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row){
    $event_name = $row['event_name'];
    $event_start = MySQLDateTimeToDateCal($row['event_start']);
    $event_end = MySQLDateTimeToDateCal($row['event_end']);
    $remind = $row['remind'];
    $event_repeat =$row['event_repeat'];
    $comment = $row['comment'];
    $color = $row['color'];
    $textcolor = $row['textcolor'];

  }
  ?>
  <form id="myForm_event_edit" class="well form-horizontale" method="post">
  <div class="row">
      <div class="center_all">
        <div class="form-group" id="event_grp" style="display:inline;">
      <label class="control-label"><small>Наименование события:</small></label>
  <input class="input-sm form-control allwidht" placeholder="Наименование события" name="event_name" id="event_name" data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="left" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off" value="<?php echo "$event_name";?>">
</div>
<p></p>
<div class="form-group" id="event_date" style="display:inline;">
<label class="control-label" style="display:inline;"><small>Продолжительность события:</small></label>
<div class="input-daterange input-group" id="datepicker">
    <input class="input-sm form-control" type="text" placeholder="Дата начала" name="event_start" id="event_start" readonly='true' data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="bottom" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off" value="<?php echo "$event_start";?>">
    <span class="input-group-addon">по</span>
    <input class="input-sm form-control" type="text" placeholder="Дата окончания" name="event_end" id="event_end" readonly='true' data-toggle="popover" data-html="true" data-trigger="manual" data-container="body" data-placement="right" data-content="<?= get_lang('Toggle_title'); ?>" autocomplete="off" value="<?php echo "$event_end";?>">
  </div>
</div>
</div>
<p></p>
<div class="col-md-6 center_all">
  <label class="control-label" style="display:inline; "><small><?=get_lang('Remind');?></small></label>
</div>
<div class="col-md-6 center_all">
  <label class="control-label" style="display:inline;"><small><?=get_lang('Repeat');?></small></label>
</div>
<div>
<select data-placeholder="<?=get_lang('Cal_place');?>" class="my_select form-control input-sm" id="remind" name="remind" style="width: 49% !important;">
          <option value="0"></option>

              <option  value="3" <? if ($remind==3) {echo "selected";};?>>За день</option>
              <option  value="2" <? if ($remind==2) {echo "selected";};?>>За неделю</option>
              <option  value="1" <? if ($remind==1) {echo "selected";};?>>За месяц</option>

</select>
&nbsp;
<select data-placeholder="<?=get_lang('Cal_place');?>" class="my_select form-control input-sm" id="event_repeat" name="event_repeat" style="width: 49% !important;">
          <option value="0"></option>

              <option  value="3" <? if ($event_repeat==3) {echo "selected";};?>>Каждую неделю</option>
              <option  value="2" <? if ($event_repeat==2) {echo "selected";};?>>Каждый месяц</option>
              <option  value="1" <? if ($event_repeat==1) {echo "selected";};?>>Каждый год</option>

</select>
</div>
<br>
<div class="input-group col-sm-12">
  <span class="events form-control" style="background-color:<?=$color;?>; color:<?=$textcolor;?>;text-align:center;"><?=get_lang('Event_example');?></span>
  <span class="input-group-addon" style="width:50px;" id="color-event" val="<?=$color;?>"><?=get_lang('Color_event');?></span>
  <span class="input-group-addon" style="width:50px;" id="color-event-text" val="<?=$textcolor;?>"><?=get_lang('Color_text');?></span>
</div>
<div class="center_all">
<br>
<label class="control-label"><small><?=get_lang('Comment');?>:</small></label>
    <textarea class="form-control allwidht" rows="2" placeholder="<?=get_lang('Comment_placeholder');?>" name="comment" id="comment"><?php echo "$comment";?></textarea>
  </div>
  </div>
  <div class="center_submit">
  <button type="submit" id="event_del" class="btn btn-danger"><?=get_lang('Delete');?></button>
  <button type="submit" id="event_edit" class="btn btn-success"><?=get_lang('Edit');?></button>
  </div>
  </form>
  <?php
}
if ($mode == "event_add"){
  $usid=$_SESSION['dilema_user_id'];
  $event_name = ($_POST['event_name']);
  $event_start = DateToMySQLDateTimeCalStart($_POST['event_start']);
  $event_end = DateToMySQLDateTimeCalEnd($_POST['event_end']);
  $remind = ($_POST['remind']);
  $event_repeat = ($_POST['event_repeat']);
  $color = ($_POST['color-event']);
  $textcolor = ($_POST['color-event-text']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ('INSERT INTO calendar (id,usersid,event_name,event_start,event_end,comment,remind, event_repeat, color, textcolor) VALUES (NULL,:id,:event_name,:event_start,:event_end,:comment,:remind,:event_repeat,:color,:textcolor)');
  $stmt->execute(array(':id' => $usid, ':event_name' => $event_name, ':event_start' => $event_start, ':event_end' => $event_end, ':comment' => $comment, ':remind' => $remind, ':event_repeat' => $event_repeat, ':color' => $color, ':textcolor' => $textcolor));
}
if ($mode == "event_edit"){
  $id=($_POST['id']);
  $event_name = ($_POST['event_name']);
  $event_start = DateToMySQLDateTimeCalStart($_POST['event_start']);
  $event_end = DateToMySQLDateTimeCalEnd($_POST['event_end']);
  $remind = ($_POST['remind']);
  $event_repeat = ($_POST['event_repeat']);
  $color = ($_POST['color-event']);
  $textcolor = ($_POST['color-event-text']);
  $comment = ($_POST['comment']);
  $stmt = $dbConnection->prepare ('UPDATE calendar SET event_name=:event_name, event_start=:event_start, event_end=:event_end, comment=:comment, remind=:remind, event_repeat=:event_repeat, color=:color, textcolor=:textcolor WHERE id=:id');
  $stmt->execute(array(':id' => $id, ':event_name' => $event_name, ':event_start' => $event_start, ':event_end' => $event_end, ':comment' => $comment, ':remind' => $remind, ':event_repeat' => $event_repeat, ':color' => $color, ':textcolor' => $textcolor));
}
if ($mode == "event_del"){
  $id=($_POST['id']);
  $stmt = $dbConnection->prepare ('DELETE FROM calendar WHERE id=:id');
  $stmt->execute(array(':id' => $id));
}
if ($mode == "calendar_users_event"){
  $usid=$_SESSION['dilema_user_id'];
  $day = $_COOKIE['date'];
  $day_f = explode("-",$day);
  $events = array();
  $stmt = $dbConnection->prepare("SELECT id,usersid,event_name,event_start,event_end,event_repeat, color, textcolor FROM calendar WHERE usersid=:usid");
  $stmt->execute(array(':usid' => $usid));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $myrow) {
    $e = array();
    if($myrow['event_repeat'] == '1'){
    $yearBegin = MySQLDateTimeToDateYear($myrow['event_start']);
    $yearEnd = date("Y",strtotime('+5 year'));
    $years = range($yearBegin, $yearEnd, 1);
    foreach ($years as $year) {
    $e['id_us_ev'] = $myrow['id'];
    $e['title'] = $myrow['event_name'];
    $ev_st = MySQLYearDateTimeToDateTime($myrow['event_start']);
    $ev_end = MySQLYearDateTimeToDateTime($myrow['event_end']);
    $e['start'] = $year."-".$ev_st;
    $e['end'] = $year."-".$ev_end;
    $e['description'] = "users_event";
    $e['color'] = $myrow['color'];
    $e['textColor'] = $myrow['textcolor'];
    // $e['allDay'] = true;
    array_push($events, $e);
  }
}
else if($myrow['event_repeat'] == '2'){
$v = date("L", mktime(0,0,0, 7,7, $day_f[0]));
$monthBegin = new DateTime(MySQLDateTimeToDateNoTime($myrow['event_start']));
$monthBegin->modify('first day of this month');
$interval_month = new DateInterval('P1M');
$month_st = MySQLDateTimeToDateNoTime($myrow['event_start']);
$month_end = MySQLDateTimeToDateNoTime($myrow['event_end']);
$difference_m = count_week_days(strtotime($month_st),strtotime($month_end));
$monthEnd = new DateTime (date('Y-m-d', strtotime($day.'+2 month')));
$period_month = new DatePeriod($monthBegin,$interval_month,$monthEnd);
foreach ($period_month as $monthh) {
  $month = $monthh->format('Y-m');
  $month2 = $monthh->format('m');
  $ev_st1 = explode("-", $myrow['event_start']);
  $ev_st2 = explode(" ", $ev_st1[2]);
  $ev_st3 = explode(":", $ev_st2[1]);
  $ev_end1 = explode("-", $myrow['event_end']);
  $ev_end2 = explode(" ", $ev_end1[2]);
  $ev_end3 = explode(":", $ev_end2[1]);
if ($v != '1'){
if (($month2 == '02') && ($ev_st2[0] == '30')){
$ev_st = $month."-28"." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
else if (($month2 == '02') && ($ev_st2[0] == '31')){
$ev_st = $month."-28"." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
else if (($month2 == '02') && ($ev_st2[0] == '29')){
$ev_st = $month."-28"." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
else if ((($month2 == '04')||($month2 == '06')||($month2 == '04')||($month2 == '09')||($month2 == '11'))&&($ev_st2[0] == '31')){
$ev_st = $month."-30"." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
else{
$ev_st = $month."-".$ev_st2[0]." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
}
if ($v != '0'){
if (($month2 == '02') && ($ev_st2[0] == '30')){
$ev_st = $month."-29"." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
else if (($month2 == '02') && ($ev_st2[0] == '31')){
$ev_st = $month."-29"." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
else if ((($month2 == '04')||($month2 == '06')||($month2 == '04')||($month2 == '09')||($month2 == '11'))&&($ev_st2[0] == '31')){
$ev_st = $month."-30"." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
else{
$ev_st = $month."-".$ev_st2[0]." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
}
}
$ev_end_day = new DateTime($ev_st);
$ev_end_day->modify("+".$difference_m."day");
$ev_end = $ev_end_day->format('Y-m-d')." ".$ev_end3[0].":".$ev_end3[1].":".$ev_end3[2];
$e['id_us_ev'] = $myrow['id'];
$e['title'] = $myrow['event_name'];
$e['start'] = $ev_st;
$e['end'] = $ev_end;
$e['description'] = "users_event";
$e['color'] = $myrow['color'];
$e['textColor'] = $myrow['textcolor'];
array_push($events, $e);
}
}
else if($myrow['event_repeat'] == '3'){
$weekBegin_st = MySQLDateTimeToDateNoTime($myrow['event_start']);
$weekBegin_end = MySQLDateTimeToDateNoTime($myrow['event_end']);
$difference_w = count_week_days(strtotime($weekBegin_st),strtotime($weekBegin_end));
$weekEnd = new DateTime(date('Y-m-d',strtotime('+5 year')));
$interval_week = new DateInterval('P7D');
$period_week = new DatePeriod(new DateTime($weekBegin_st),$interval_week,$weekEnd);
foreach ($period_week as $weeks) {
$ev_st1 = explode("-", $myrow['event_start']);
$ev_st2 = explode(" ", $ev_st1[2]);
$ev_st3 = explode(":", $ev_st2[1]);
$ev_st=$weeks->format('Y-m-d')." ".$ev_st3[0].":".$ev_st3[1].":".$ev_st3[2];
$en = clone $weeks;
$en->modify("+".$difference_w."day");
$ev_end1 = explode("-", $myrow['event_end']);
$ev_end2 = explode(" ", $ev_end1[2]);
$ev_end3 = explode(":", $ev_end2[1]);
$ev_end=$en->format('Y-m-d')." ".$ev_end3[0].":".$ev_end3[1].":".$ev_end3[2];
$e['id_us_ev'] = $myrow['id'];
$e['title'] = $myrow['event_name'];
$e['start'] = $ev_st;
$e['end'] = $ev_end;
$e['description'] = "users_event";
$e['color'] = $myrow['color'];
$e['textColor'] = $myrow['textcolor'];
array_push($events, $e);
}
}
else if($myrow['event_repeat'] == '0'){
  $e['id_us_ev'] = $myrow['id'];
  $e['title'] = $myrow['event_name'];
  $e['start'] = $myrow['event_start'];
  $e['end'] = $myrow['event_end'];
  $e['description'] = "users_event";
  $e['color'] = $myrow['color'];
  $e['textColor'] = $myrow['textcolor'];

  // $e['allDay'] = true;
  array_push($events, $e);
}
}
// else{
//   $e['id_us_ev'] = $myrow['id'];
//   $e['title'] = $myrow['event_name'];
//   $e['start'] = $myrow['event_start'];
//   $e['end'] = $myrow['event_end'];
//   $e['description'] = "users_event";
//   // $e['allDay'] = true;
//   array_push($events, $e);
// }
// }
// var_dump($events);
  echo json_encode($events);
}
if ($mode == "create_news") {

    ?>
    <form class="form-horizontal" role="form">

                <div class="form-group">

                    <label for="t" class="col-sm-1 control-label"><small><?=get_lang('News_subject');?>: </small></label>

                    <div class="col-sm-11">


                        <input  type="text" name="t" class="form-control input-sm" id="t" placeholder="<?=get_lang('News_subject');?>">

                    </div>

                </div>
            <div class="form-group">

                <div class="col-sm-12">

                    <div id="summernote_news"></div>

                </div>
                <div class="col-md-12"><hr></div>
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <button id="do_create_news" class="btn btn-success" type="submit"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?=get_lang('News_create');?></button>
                        </div>
                        <div class="btn-group">
                            <a href="news" class="btn btn-default" type="submit"><i class="fa fa-reply" aria-hidden="true"></i> <?=get_lang('News_back');?></a>
                        </div>
                    </div>

                </div>
    </form>
<?php

}
if ($mode == "do_create_news") {


    $t=($_POST['t']);
    $user_id_z=$_SESSION['dilema_user_id'];

    $hn=md5(time());
    $message=($_POST['msg']);
    $message = str_replace("\r\n", "\n", $message);
    $message = str_replace("\r", "\n", $message);
    $message = str_replace("&nbsp;", " ", $message);
    $stmt = $dbConnection->prepare('insert into news (hashname, user_init_id, dt, title,message) values
(:hn,:user_id_z, now(), :t,:message)');
    $stmt->execute(array(':hn' => $hn, ':user_id_z'=>$user_id_z, ':t'=>$t, ':message'=>$message));
}
if ($mode == "list_news") {
    $user_id=$_SESSION['dilema_user_id'];
    $priv = validate_priv($user_id);
    $permit_users_news = get_conf_param('permit_users_news');
    $permit = explode(",",$permit_users_news);
    foreach ($permit as $permit_id) {
    if ($user_id == $permit_id){
      $priv_h="yes";
    }
    }
    $page=($_POST['page']);
    $perpage='5';
    $start_pos = ($page - 1) * $perpage;

    $stmt = $dbConnection->prepare('SELECT
  id, user_init_id, dt, title, message, hashname
  from news
  order by dt desc limit :start_pos, :perpage');
    $stmt->execute(array(':start_pos'=>$start_pos,':perpage'=>$perpage));
    $result = $stmt->fetchAll();

    if(empty($result)) {

        ?>
        <div class="jumbotron">
            <p>                </p><h3><center><?=get_lang('News_no_records');?></center></h3><p></p>

        </div>
    <?php
    }
    else if(!empty($result)){

foreach($result as $row)
{
                ?>

                <h5 style=" margin-bottom: 5px; "><i class="fa fa-file-text-o" aria-hidden="true"></i> <a href="news?h=<?=$row['hashname'];?>"><?=$row['title'];?></a> <small>(<?=get_lang('News_author');?>: <?=nameshort(name_of_user_ret($row['user_init_id']));?>)
                  <?php if (($priv_h== "yes") || ($priv == 1)) { echo "
    <div class=\"btn-group\">
    <button id=\"edit_news\" value=\"".$row['hashname']."\" type=\"button\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>
    <button id=\"del_news\" value=\"".$row['hashname']."\"type=\"button\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>
    </div>
    "; } ?></small></h5>
                <p style=" margin-bottom: 30px; "><small><?=cutstr_news_ret(strip_tags($row['message']));?>
                    </small>

                </p>
                <hr>

            <?php
        }
    }
}
if ($mode == "edit_news") {
    $hn=($_POST['hn']);

    $stmt = $dbConnection->prepare('select id, user_init_id, dt, title, message, hashname from news where hashname=:hn');
    $stmt->execute(array(':hn' => $hn));
    $news = $stmt->fetch(PDO::FETCH_ASSOC);

    ?>
    <form class="form-horizontal" role="form">

        <div class="">
            <div class="">
                <div class="form-group">

                    <label for="t" class="col-sm-2 control-label"><small><?=get_lang('News_subject');?>: </small></label>

                    <div class="col-sm-10">

                        <input  type="text" name="t" class="form-control input-sm" id="t" placeholder="<?=get_lang('News_subject');?>" value="<?=$news['title'];?>">

                    </div>

                </div></div>
            <div class="form-group">

                <div class="col-sm-12">

                    <div id="summernote_news"><?=$news['message'];?></div>

                </div>
                <div class="col-md-12"><hr></div>
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <button id="do_save_news" value="<?=$hn?>" class="btn btn-success" type="submit"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?=get_lang('News_save');?></button>
                        </div>
                        <div class="btn-group">
                            <a href="news" class="btn btn-default" type="submit"><i class="fa fa-reply" aria-hidden="true"></i> <?=get_lang('News_back');?></a>
                        </div>
                    </div>


                </div>
    </form>
<?php

}
if ($mode == "do_save_news") {
    $hn=($_POST['hn']);

    $t=($_POST['t']);
    $user_id_z=$_SESSION['dilema_user_id'];

    $message=($_POST['msg']);
    $message = str_replace("\r\n", "\n", $message);
    $message = str_replace("\r", "\n", $message);
    $message = str_replace("&nbsp;", " ", $message);

    $stmt = $dbConnection->prepare('update news set user_init_id=:user_id_z, dt=now(), title=:t, message=:message where hashname=:hn');
    $stmt->execute(array(':hn' => $hn, ':user_id_z'=>$user_id_z, ':t'=>$t, ':message'=>$message));


}
if ($mode == "del_news") {
    $hn=($_POST['hn']);

    $stmt = $dbConnection->prepare('delete from news where hashname=:hn');
    $stmt->execute(array(':hn' => $hn));

}
if ($mode == "news_list_content_previous"){
  $dt_p = ($_POST['dt_p']);
  $stmt = $dbConnection->prepare('SELECT
        id, user_init_id, dt, title, message, hashname
        from news
        where dt = (SELECT max(dt) from news where dt < :dt_p)');
  $stmt->execute(array(':dt_p' => $dt_p));
  $result = $stmt->fetchAll();
  ?>
  <table class="table table-hover" style="margin-bottom: 0px;" id="">
      <?php
          foreach ($result as $row) {
            $stmt = $dbConnection->prepare('SELECT
                  count(*) as count, dt
                  from news
                  where dt < :dt_r');
            $stmt->execute(array(':dt_r' => $row['dt']));
            $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
            $dt = $row['dt'];
            $count = $row2['count'];
            if ($count == 0){
            ?>
            <input type="hidden" id="previous_d" value="disabled">
            <?php
          }
                  ?>
                  <tr><td><small><i class="fa fa-file-text-o" aria-hidden="true"></i> </small><a href="news?h=<?= $row['hashname']; ?>"><small><?= cutstr_news2_ret($row['title']); ?></small></a></td><td><small style="float:right;" class="text-muted">(<?= get_lang('News_author'); ?>: <?= nameshort(name_of_user_ret($row['user_init_id'])); ?>)<br>(<?= get_lang('News_date'); ?>: <?= ($row['dt']); ?>)</small></td></tr>
                  <tr>
                  <td colspan="2"><small><i class="fa fa-file-text-o" aria-hidden="true"></i> </small><small><?= cutstr_news_home_ret(strip_tags($row['message'])); ?></small></td>
                  </tr>
                  <input type="hidden" id="news_dt" value="<?php echo $dt; ?>">
              <?php
      }
      ?>
  </table>
  <?php
}
if ($mode == "news_list_content_next"){
  $dt_n = ($_POST['dt_n']);
  $stmt = $dbConnection->prepare('SELECT
        id, user_init_id, dt, title, message, hashname
        from news
        where dt = (SELECT min(dt) from news where dt > :dt_n)');
  $stmt->execute(array(':dt_n' => $dt_n));
  $result = $stmt->fetchAll();
  ?>
  <table class="table table-hover" style="margin-bottom: 0px;" id="">
      <?php
          foreach ($result as $row) {
            $stmt = $dbConnection->prepare('SELECT
                  count(*) as count, dt
                  from news
                  where dt > :dt_r');
            $stmt->execute(array(':dt_r' => $row['dt']));
            $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
            $dt = $row['dt'];
            $count = $row2['count'];
            if ($count == 0){
            ?>
            <input type="hidden" id="next_d" value="disabled">
            <?php
          }
                  ?>
                  <tr><td><small><i class="fa fa-file-text-o" aria-hidden="true"></i> </small><a href="news?h=<?= $row['hashname']; ?>"><small><?= cutstr_news2_ret($row['title']); ?></small></a></td><td><small style="float:right;" class="text-muted">(<?= get_lang('News_author'); ?>: <?= nameshort(name_of_user_ret($row['user_init_id'])); ?>)<br>(<?= get_lang('News_date'); ?>: <?= ($row['dt']); ?>)</small></td></tr>
                  <tr>
                  <td colspan="2"><small><i class="fa fa-file-text-o" aria-hidden="true"></i> </small><small><?= cutstr_news_home_ret(strip_tags($row['message'])); ?></small></td>
                  </tr>
                  <input type="hidden" id="news_dt" value="<?php echo $dt; ?>">
              <?php
      }
      ?>
  </table>
  <?php
}
if ($mode == "conf_test_mail") {

if (get_conf_param('mail_type') == "sendmail") {
$mail = new PHPMailer(true);
$mail->IsSendmail(); // telling the class to use SendMail transport
try {
$mail->AddReplyTo($CONF_MAIL['from'], $CONF['name_of_firm']);
$mail->AddAddress($CONF['mail'], 'admin at');
$mail->SetFrom($CONF_MAIL['from'], $CONF['name_of_firm']);
$mail->Subject = 'test message';
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
$mail->MsgHTML('Test message via sendmail');
$mail->Send();
echo "Message Sent OK<p></p>\n";
} catch (phpmailerException $e) {
echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
echo $e->getMessage(); //Boring error messages from anything else!
}
}
else if (get_conf_param('mail_type') == "SMTP") {
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SMTP
try {
$mail->SMTPDebug = 2; // enables SMTP debug information (for testing)
$mail->SMTPAuth = $CONF_MAIL['auth']; // enable SMTP authentication
if (get_conf_param('mail_auth_type') != "none")
{
$mail->SMTPSecure = $CONF_MAIL['auth_type'];
}
$mail->Host = $CONF_MAIL['host'];
$mail->Port = $CONF_MAIL['port'];
$mail->Username = $CONF_MAIL['username'];
$mail->Password = $CONF_MAIL['password'];


$mail->AddReplyTo($CONF_MAIL['from'], $CONF['name_of_firm']);
$mail->AddAddress($CONF['mail'], 'admin at');
$mail->SetFrom($CONF_MAIL['from'], $CONF['name_of_firm']);
$mail->Subject = 'test message via smtp';
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
$mail->MsgHTML("test message");
$mail->Send();
echo "Message Sent OK<p></p>\n";
} catch (phpmailerException $e) {
echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
echo $e->getMessage(); //Boring error messages from anything else!
}
}
}
}
}
?>
