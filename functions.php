<?php
include_once("config.php");
define("DIR_ROOT", __DIR__);
define("DS", DIRECTORY_SEPARATOR);
include_once('sys/Parsedown.php');
require 'library/HTMLPurifier.auto.php';
date_default_timezone_set('Europe/Moscow');
$dbConnection = new PDO(
    'mysql:host='.$CONF_DB['host'].';dbname='.$CONF_DB['db_name'],
    $CONF_DB['username'],
    $CONF_DB['password'],
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);
$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$CONF = array (
'title_header'	=> get_conf_param('title_header'),
'hostname'	=> get_conf_param('hostname'),
'mail'	=> get_conf_param('mail'),
'name_of_firm'	=> get_conf_param('name_of_firm'),
'fix_subj'	=> get_conf_param('fix_subj'),
'first_login'	=> get_conf_param('first_login'),
'file_types' => get_conf_param('file_types'),
'file_types_img' => get_conf_param('file_types'),
'file_size' => get_conf_param('file_size'),
'permit_users_knt' => get_conf_param('permit_users_knt'),
'permit_users_req' => get_conf_param('permit_users_req'),
'permit_users_cont' => get_conf_param('permit_users_cont'),
'permit_users_documents' => get_conf_param('permit_users_documents'),
'permit_users_news' => get_conf_param('permit_users_news'),
'permit_users_license' => get_conf_param('permit_users_license'),
'default_org' => get_conf_param('default_org')
);

if ($CONF_AT['debug_mode'] == true) {
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
}

function get_user_lang(){
    global $dbConnection;


    $mid=$_SESSION['dilema_user_id'];
    $stmt = $dbConnection->prepare('SELECT lang from users where id=:mid');
    $stmt->execute(array(':mid' => $mid));
    $max = $stmt->fetch(PDO::FETCH_NUM);

    $max_id=$max[0];
    $length = strlen(utf8_decode($max_id));
    if (($length < 1) || $max_id == "0") {$ress='ru';} else {$ress=$max_id;}
    return $ress;
}

// $lang=get_user_lang();
// switch ($lang) {
//     case 'ua':
//         $lang_file = 'lang.ua.php';
//         break;
//
//     case 'ru':
//         $lang_file = 'lang.ru.php';
//         break;
//
//     case 'en':
//         $lang_file = 'lang.en.php';
//         break;
//
//     default:
//         $lang_file = 'lang.ru.php';
//
// }
//
// include_once 'lang/'.$lang_file;

function get_lang($in){

  $lang2 = get_user_lang();
  switch ($lang2) {
      case 'ru':
          $lang_file2 = (DIR_ROOT . DS . "lang" . DS ."lang-ru.json");
          break;

      case 'en':
          $lang_file2 = (DIR_ROOT . DS . "lang" . DS ."lang-en.json");
          break;

      default:
          $lang_file2 = (DIR_ROOT . DS . "lang" . DS ."lang-ru.json");

  }
  $file = file_get_contents($lang_file2);
  $json = json_decode($file);
  if (isset($json->$in)){
  return $json->$in;
  }else {
  return 'undefined';
}
}
function make_html($in, $type) {



 $Parsedown = new Parsedown();
 $text=$Parsedown->text($in);

$text=str_replace("\n", "<br />", $text);
$config = HTMLPurifier_Config::createDefault();



$config->set('Core.Encoding', 'UTF-8');
$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
$config->set('Cache.DefinitionImpl', null);
$config->set('AutoFormat.RemoveEmpty',false);
$config->set('AutoFormat.AutoParagraph',true);
//$config->set('URI.DisableExternal', true);
if ($type == "no") {
$config->set('HTML.ForbiddenElements', array( 'p' ) );
}

$purifier = new HTMLPurifier($config);
$def = $config->getHTMLDefinition(true);
$def->addElement('ul', 'List', 'Optional: List | li', 'Common', array());
$def->addElement('ol', 'List', 'Optional: List | li', 'Common', array());
// here, the javascript command is stripped off
$content = $purifier->purify($text);

return $content;

}
function GetRandomId($in) // результат - случайная строка из цифр длинной n
{
  $id="";
  for ($i = 1; $i <= $in; $i++)
  {
    $id=$id.chr(rand(48,56));
  }
    return $id;
}
function UpdateLastdt($in){ // обновляем данные о последнем посещении
		global $dbConnection;
		$lastdt=date( 'Y-m-d H:i:s');
  		$stmt = $dbConnection->prepare ("UPDATE users SET lastdt=:lastdt WHERE id=:in");
      $stmt->execute(array(':in' => $in, ':lastdt' => $lastdt));
    }
function get_conf_param($in) {
 global $dbConnection;
 $stmt = $dbConnection->prepare('SELECT value FROM perf where param=:in');
 $stmt->execute(array(':in' => $in));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);

return $row['value'];

}
function cutstr_news2_ret($input) {

    $result = implode(array_slice(explode('<br>',wordwrap($input,50,'<br>',false)),0,1));
    $r=$result;
    if($result!=$input)$r.='...';
    return $r;
}
function get_user_status($in) {
	    global $dbConnection;

    $stmt = $dbConnection->prepare('select lastdt from users where id=:in');
    $stmt->execute(array(':in' => $in));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$lt=$row['lastdt'];
        $d = time()-strtotime($lt);
	if ($d > 20) {
	$lt_tooltip="";
	if ($lt != '0000-00-00 00:00:00') {$lt_tooltip=get_lang('stats_last_time')."<br>".$lt;}
  else{$lt_tooltip=get_lang('stats_last_time')."<br>".get_lang('login_never');}
  $res="<span data-toggle=\"tooltip\" data-placement=\"bottom\" class=\"label label-default\" data-original-title=\"".$lt_tooltip."\" data-html=\"true\"><i class=\"fa fa-thumbs-down\"></i> offline</span>";}
	else {$res="<span class=\"label label-success\"><i class=\"fa fa-thumbs-up\"></i> online</span>";}

	return $res;
}

function update_val_by_key($key,$val) {
 global $dbConnection;
$stmt = $dbConnection->prepare('update perf set value=:value where param=:param');
$stmt->execute(array(':value' => $val,':param' => $key));
return true;

}
function validate_alphanumeric_underscore($str)
{
    return preg_match('/^[a-zA-Z0-9_\.-]+$/',$str);
}
function validate_email($str)
{
    return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$str);
}
function validate_exist_mail($str) {
    global $dbConnection;
    $uid=$_SESSION['dilema_user_id'];
    $email_all = "no-email@holding.lan.zt";

    $stmt = $dbConnection->prepare('SELECT count(email) as n from users where email=:str and id != :uid and email != :email_all');
    $stmt->execute(array(':str' => $str,':uid' => $uid, ':email_all' => $email_all));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['n'] > 0) {$r=false;}
    else if ($row['n'] == 0) {$r=true;}

    return $r;
}
function nameshort($name) {
    $nameshort = preg_replace('/(\w+) (\w)\w+ (\w)\w+/iu', '$1 $2. $3.', $name);
    return $nameshort;
}
function cutstr_news_ret($input) {

    $result = implode(array_slice(explode('<br>',wordwrap($input,500,'<br>',false)),0,1));
    $r=$result;
    if($result!=$input)$r.='...';
    return $r;
}
function cutstr_news_home_ret($input) {

    $result = implode(array_slice(explode('<br>',wordwrap($input,300,'<br>',false)),0,1));
    $r=$result;
    if($result!=$input)$r.='...';
    return $r;
}
function get_news(){
  global $dbConnection;

  $stmt = $dbConnection->prepare('SELECT
        id, user_init_id, title, dt, message, hashname
        from news
        order by dt desc
        limit 1');
  $stmt->execute();
  $result = $stmt->fetchAll();
  ?>
  <table class="table" style="margin-bottom: 0px;" id="">
      <?php

      if (empty($result)) {
          ?>
          <div id="" class="well well-large well-transparent lead">
              <center>
                  <?= get_lang('News_no_records'); ?>
              </center>
          </div>
      <?php
      } else if (!empty($result)) {
          foreach ($result as $row) {
            $dt = $row['dt'];
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
                  <tr><td><small><i class="fa fa-file-text-o"></i> </small><a href="news?h=<?= $row['hashname']; ?>"><small><?= cutstr_news2_ret($row['title']); ?></small></a></td><td><small style="float:right;" class="text-muted">(<?= get_lang('News_author'); ?>: <?= nameshort(name_of_user_ret($row['user_init_id'])); ?>)<br>(<?= get_lang('News_date'); ?>: <?= ($row['dt']); ?>)</small></td></tr>
                  <tr>
                  <td colspan="2"><small><i class="fa fa-file-text-o"></i> </small><small><?= cutstr_news_home_ret(strip_tags($row['message'])); ?></small></td>
                  </tr>
                  <input type="hidden" id="news_dt" value="<?php echo $dt; ?>">
              <?php
              }
      }
      ?>
  </table>
  <?php
}
// на выходе - массив из папок в укзанной папке
function GetArrayFilesInDir($dir)
{
	$includes_dir = opendir("$dir");
	$files = array();
	while (($inc_file = readdir($includes_dir)) != false) {
        if (($inc_file!='.') and ($inc_file!='..')) {
            $files[] = $inc_file;
        }
    }
    closedir($includes_dir);
    sort($files);
    return $files;
}

// Преобразует дату типа dd.mm.2012 в формат MySQL 2012-01-01 00:00:00
function DateToMySQLDateTime2($dt)
{
   $str_exp = explode(".", $dt);
   $str_exp2 = explode(" ", $str_exp[2]);
   $dtt=$str_exp2[0]."-".$str_exp[1]."-".$str_exp[0]." ".$str_exp2[1].":00";
   return $dtt;
};
// Преобразует дату типа dd.mm.2012 в формат MySQL 2012-01-01 00:00:00
function DateToMySQLDateTimeCalStart($dt)
{
   $str_exp = explode(".", $dt);
   $str_exp2 = explode(" ", $str_exp[2]);
   $dtt=$str_exp2[0]."-".$str_exp[1]."-".$str_exp[0]." ".$str_exp2[1]."00:00:00";
   return $dtt;
};
// Преобразует дату типа dd.mm.2012 в формат MySQL 2012-01-01 23:59:00
function DateToMySQLDateTimeCalEnd($dt)
{
   $str_exp = explode(".", $dt);
   $str_exp2 = explode(" ", $str_exp[2]);
   $dtt=$str_exp2[0]."-".$str_exp[1]."-".$str_exp[0]." ".$str_exp2[1]."23:59:00";
   return $dtt;
};
//День рождение
function DateToMySQLDateBirthday($dt)
{
   $str_exp = explode(".", $dt);
   $dtt=$str_exp[1]."-".$str_exp[0];

   return $dtt;
};

// Преобразует дату MySQL 2012-01-01 00:00:00 в dd.mm.2012 00:00:00
function MySQLDateTimeToDateTime($dt)
{

   $str1 = explode("-", $dt);
   $str2 = explode(" ", $str1[2]);
   $str3 = explode(":", $str2[1]);
   $dtt=$str2[0].".".$str1[1].".".$str1[0]." ".$str3[0].":".$str3[1];
   return $dtt;
};
// Преобразует дату MySQL 2012-01-01 00:00:00 в dd.mm.2012 00:00:00
function MySQLYearDateTimeToDateTime($dt)
{

   $str1 = explode("-", $dt);
   $dtt=$str1[1]."-".$str1[2];
   return $dtt;
};

// Преобразует дату MySQL 2012-01-01 в dd.mm.2012
function MySQLDateToDate($dt)
{

   $str1 = explode("-", $dt);
   $dtt=$str1[2].".".$str1[1].".".$str1[0];
   return $dtt;
};
// Преобразует дату MySQL 2012-01-01 00:00:00 в dd.mm.2012
function MySQLDateTimeToDateCal($dt)
{
   $str = explode(" ",$dt);
   $str1 = explode("-", $str[0]);
   $dtt=$str1[2].".".$str1[1].".".$str1[0];
   return $dtt;
};
// Преобразует дату MySQL 2012-01-01 00:00:00 в mm.2012
function MySQLDateTimeToDateRemindMonth($dt)
{
   $str = explode(" ",$dt);
   $str1 = explode("-", $str[0]);
   $dtt=$str1[1].".".$str1[0];
   return $dtt;
};
// Преобразует дату MySQL 2012-01-01 00:00:00 в mm
function MySQLDateTimeToDateMonth($dt)
{
   $str = explode(" ",$dt);
   $str1 = explode("-", $str[0]);
   $dtt=$str1[1];
   return $dtt;
};
// Преобразует дату MySQL 2012-01-01 00:00:00 в dd
function MySQLDateTimeToDateDay($dt)
{
   $str = explode(" ",$dt);
   $str1 = explode("-", $str[0]);
   $dtt=$str1[2];
   return $dtt;
};
// Преобразует дату MySQL 2012-01-01 00:00:00 в YYYY
function MySQLDateTimeToDateYear($dt)
{
   $str = explode(" ",$dt);
   $str1 = explode("-", $str[0]);
   $dtt=$str1[0];
   return $dtt;
};
// Преобразует дату MySQL 2012-01-01 00:00:00 в 2012-01-01
function MySQLDateTimeToDateNoTime($dt)
{
   $str = explode(" ",$dt);
   $str1 = explode("-", $str[0]);
   $dtt=$str1[0]."-".$str1[1]."-".$str1[2];
   return $dtt;
};
function MySQLDateToMonth($dt)
{
   $str1 = explode("-", $dt);
   $dtt=$str1[1].".".$str1[0];
   return $dtt;
};
// Преобразует дату MySQL 2012-01 в mm.2012
function MySQLDateTimeToDateTimeNoTime($dt)
{

   $str1 = explode("-", $dt);
   $str2 = explode(" ", $str1[2]);
   $dtt=$str2[0].".".$str1[1].".".$str1[0];
  //         echo "!$dtt!";
   return $dtt;
};
//Возврат кол-ва дней
function count_week_days($__date_from, $__date_to) {
   $total_days_count = $__date_to > $__date_from ? round(($__date_to - $__date_from)/(24*3600)) : 0;
   return $total_days_count;
}
// function dateRange($first) {
//   $dates = array();
//   $weekEnd = new DateTime(date('Y-m-d',strtotime('+1 year')));
//   $interval_week = new DateInterval('P7D');
//   $period_week = new DatePeriod(new DateTime($first),$interval_week,$weekEnd);
//   foreach ($period_week as $weeks) {
//     $format = $weeks->format('Y-m-d');
//         $dates[] = $format;
//   }
//                 return $dates;
//         }
function name_of_user_ret($input) {
    global $dbConnection;


    $stmt = $dbConnection->prepare('SELECT fio FROM users where id=:input');
    $stmt->execute(array(':input' => $input));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);


    return($fio['fio']);
}
function randomhash() {
    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 24; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
function validate_priv($user_id) {
    global $dbConnection;

    $stmt = $dbConnection->prepare('SELECT priv from users where id=:user_id LIMIT 1');
    $stmt->execute(array(':user_id' => $user_id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $priv=$row['priv'];

    // if ($admin == "1") {return true;}
    // else {return false;}
    return $priv;

}

function validate_user($user_id, $input) {

    global $dbConnection;

    if (!isset($_SESSION['us_code'])) {

        if (isset($_COOKIE['authhash_uscode'])) {

            $user_id=$_COOKIE['authhash_usid'];
            $input=$_COOKIE['authhash_uscode'];
            $_SESSION['us_code']=$input;
            $_SESSION['dilema_user_id']=$user_id;

        }


    }


    $stmt = $dbConnection->prepare('SELECT pass,login,fio from users where id=:user_id LIMIT 1');
    $stmt->execute(array(':user_id' => $user_id));


    if ($stmt -> rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);







        //$row = mysql_fetch_assoc($sql);
        $dbpass=$row['pass'];
        $_SESSION['dilema_user_login'] = $row['login'];
        $_SESSION['dilema_user_fio'] = $row['fio'];
        //$_SESSION['helpdesk_sort_prio'] == "none";
        if ($dbpass == $input) {return true;}
        else { return false;}
    }
}
function get_myname(){
    $uid=$_SESSION['dilema_user_id'];
    $nu=name_of_user_ret($uid);
    $length = strlen(utf8_decode($nu));

    if ($length > 2) {$n=explode(" ", name_of_user_ret($uid)); $t=$n[1]." ".$n[2];}
    else if ($length <= 2) {$t="";}
    //$n=explode(" ", name_of_user_ret($uid));
    return $t;
}
function get_avatar(){
  global $dbConnection;
  $uid=$_SESSION['dilema_user_id'];
  $stmt = $dbConnection->prepare('SELECT jpegphoto from users_profile where usersid=:user_id');
  $stmt->execute(array(':user_id' => $uid));
  $ava = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($ava['jpegphoto'] != ''){return ($ava['jpegphoto']."?".time());}
  else {return ('noavatar.png?'.time());}
}
function validate_exist_login($str) {
global $dbConnection;
$uid=$_SESSION['dilema_user_id'];

$stmt = $dbConnection->prepare('SELECT count(login) as n from users where login=:str');
$stmt->execute(array(':str' => $str));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row['n'] > 0) {$r=false;}
else if ($row['n'] == 0) {$r=true;}

return $r;
}
function validate_exist_user_name($str) {
global $dbConnection;
$uid=$_SESSION['dilema_user_id'];

$stmt = $dbConnection->prepare('SELECT count(user_name) as un from users where user_name=:str');
$stmt->execute(array(':str' => $str));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row['un'] > 0) {$r=false;}
else if ($row['un'] == 0) {$r=true;}

return $r;
}
function validate_login_equipment($str) {
global $dbConnection;

$stmt = $dbConnection->prepare('SELECT count(usersid) as u from equipment where usersid=:str and util=0 and sale=0');
$stmt->execute(array(':str' => $str));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row['u'] > 0) {$u=false;}
else if ($row['u'] == 0) {$u=true;}

return $u;
}
function GetArrayKnt(){ // Возврат - массив активных контрагентов
		global $dbConnection;
		$cnt=0;
		$mOrgs = array();
  		$stmt = $dbConnection->prepare('SELECT * FROM knt WHERE active=1 order by name');
      $stmt->execute();
      $res1 = $stmt->fetchAll();
  		if ($res1!='') {
        foreach($res1 as $myrow) {
				   $mOrgs[$cnt]["id"]=$myrow["id"];
				   $mOrgs[$cnt]["name"]=$myrow["name"];
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
				   $cnt++;
				  };
				return $mOrgs;
                    }
};

function GetArrayOrg(){ // Возврат - массив активных организаций
		global $dbConnection;
		$cnt=0;
		$mOrgs = array();
  		$stmt = $dbConnection->prepare('SELECT * FROM org WHERE active=1 order by name');
      $stmt->execute();
      $res1 = $stmt->fetchAll();
  		if ($res1!='') {
        foreach($res1 as $myrow) {
				   $mOrgs[$cnt]["id"]=$myrow["id"];
				   $mOrgs[$cnt]["name"]=$myrow["name"];
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
				   $cnt++;
				  };
				return $mOrgs;
                    }
};

function GetArrayPlaces(){ // Возврат - массив активных помещений
		global $dbConnection;
		$cnt=0;
		$mOrgs = array();
  		$stmt = $dbConnection->prepare('SELECT * FROM places WHERE active=1 order by name');
      $stmt->execute();
      $res1 = $stmt->fetchAll();
  		if ($res1!='') {
        foreach($res1 as $myrow) {
				   $mOrgs[$cnt]["id"]=$myrow["id"];
				   $mOrgs[$cnt]["name"]=$myrow["name"];
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
				   $cnt++;
				  };
				return $mOrgs;
                    }
};

function GetArrayUsers(){ // Возврат - массив активных пользователей
		global $dbConnection;
		$cnt=0;
		$mOrgs = array();
  		$stmt = $dbConnection->prepare('SELECT * FROM users WHERE active=1 and on_off=1 order by fio');
      $stmt->execute();
      $res1 = $stmt->fetchAll();
  		if ($res1!='') {
        foreach($res1 as $myrow) {
				   $mOrgs[$cnt]["id"]=$myrow["id"];
				   $mOrgs[$cnt]["fio"]= nameshort($myrow["fio"]);
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
				   $cnt++;
				  };
				return $mOrgs;
                    }
};

function GetArrayGroup(){ // Возврат - массив групп номенклатуры..
global $dbConnection;
$cnt=0;
$mOrgs = array();
 $stmt = $dbConnection->prepare('SELECT * FROM group_nome WHERE active=1 ORDER BY name');
 $stmt->execute();
 $res1 = $stmt->fetchAll();
 foreach($res1 as $myrow) {
  $mOrgs[$cnt]["id"]=$myrow["id"];
   $mOrgs[$cnt]["name"]=$myrow["name"];
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
  $cnt++;
 };
return $mOrgs;

};

function GetArrayVendor(){ // Возврат - массив производителей..
global $dbConnection;
$cnt=0;
$mOrgs = array();
 $stmt = $dbConnection->prepare('SELECT * FROM vendor WHERE active=1 ORDER BY name');
 $stmt->execute();
 $res1 = $stmt->fetchAll();
 foreach($res1 as $myrow) {
  $mOrgs[$cnt]["id"]=$myrow["id"];
   $mOrgs[$cnt]["name"]=$myrow["name"];
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
  $cnt++;
 };
return $mOrgs;

};

function GetArrayGroup_vendor($in){ // Возврат - массив производителей по группе..
echo "Vendor\n";
echo "ID=".var_dump($in)."\n";
global $dbConnection;
$cnt=0;
$mOrgs = array();
$stmt = $dbConnection->prepare('SELECT gr.*, ven.* FROM group_nome as gr INNER JOIN nome as nom ON gr.id=nom.groupid INNER JOIN vendor as ven ON nom.vendorid=ven.id WHERE gr.id=:in and ven.active=1 group by ven.name order by ven.name');
$stmt->execute(array(':in' => $in));
$res1 = $stmt->fetchAll();
foreach($res1 as $myrow) {

   $mOrgs[$cnt]["id"]=$myrow["id"];
   $mOrgs[$cnt]["name"]=$myrow["name"];
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
   $cnt++;
  };
return $mOrgs;
};

function GetArrayVendor_nome($in,$in2){ // Возврат - массив номенклатуры..
echo "Nome\n";
echo "ID=".var_dump($in,$in2)."\n";
global $dbConnection;
$cnt=0;
$mOrgs = array();
$stmt = $dbConnection->prepare('SELECT gr.*, nom.* FROM nome as nom INNER JOIN group_nome as gr ON gr.id=nom.groupid INNER JOIN vendor as ven ON nom.vendorid =ven.id WHERE gr.id = :in and ven.id = :in2  and nom.active=1 order by nom.name');
$stmt->execute(array(':in' => $in, ':in2' => $in2));
$res1 = $stmt->fetchAll();
foreach($res1 as $myrow) {
   $mOrgs[$cnt]["id"]=$myrow["id"];
   $mOrgs[$cnt]["name"]=$myrow["name"];
                                   $mOrgs[$cnt]["active"]=$myrow["active"];
   $cnt++;
  };
return $mOrgs;
};
function GetArrayNome_users($in){ // Возврат - массив активных контрагентов
		echo "INVOICE\n";
		echo "ID=".var_dump($in)."\n";
    global $dbConnection;
		$cnt=0;
		$mOrgs = array();
		$stmt = $dbConnection->prepare('SELECT nome.name as name, nome.id as nomeid, equipment.id as id FROM equipment INNER JOIN nome ON equipment.nomeid = nome.id WHERE equipment.usersid = :in and nome.groupid IN (1,8,15,22,27) and equipment.util=0 and equipment.sale=0 order by nome.name');
    $stmt->execute(array(':in' => $in));
    $res1 = $stmt->fetchAll();
    foreach($res1 as $myrow) {
				   $mOrgs[$cnt]["id"]=$myrow["id"];
				   $mOrgs[$cnt]["name"]=$myrow["name"];
				   $cnt++;
				  };
				return $mOrgs;

};
function lang_delete($in){
  switch ($in) {
    case 'org':
      $name = get_lang('Menu_org');
      break;
      case 'equipment':
        $name = get_lang('Menu_equipment');
        break;
        case 'print':
          $name = get_lang('Menu_cartridge');
          break;
          case 'print_param':
            $name = get_lang('Print_param');
            break;
            case 'eq_param':
              $name = get_lang('Equipment_param');
              break;
              case 'move':
                $name = get_lang('Equipment_move');
                break;
                case 'repair':
                  $name = get_lang('Equipment_repair_title');
                  break;
                  case 'shtr':
                    $name = get_lang('Shtr');
                    break;
                    case 'places':
                      $name = get_lang('Menu_places');
                      break;
                      case 'places_users':
                        $name = get_lang('Places_users');
                        break;
                        case 'users':
                          $name = get_lang('Menu_users');
                          break;
                          case 'users_profile':
                            $name = get_lang('Users_profile');
                            break;
                            case 'nome':
                              $name = get_lang('Menu_nome');
                              break;
                              case 'group_nome':
                                $name = get_lang('Menu_group_nome');
                                break;
                                case 'vendor':
                                  $name = get_lang('Menu_vendor');
                                  break;
                                  case 'group_param':
                                    $name = get_lang('Group_param');
                                    break;
                                    case 'requisites':
                                      $name = get_lang('Requisites');
                                      break;
                                      case 'files_requisites':
                                        $name = get_lang('Requisites_files');
                                        break;
                                        case 'knt':
                                          $name = get_lang('Knt');
                                          break;
                                          case 'files_contractor':
                                            $name = get_lang('Knt_files');
                                            break;
  }
  return $name;
}
function lang_is_delete($in){
  switch ($in) {
    case 'no':
      $name = get_lang('No');
      break;
      case 'yes':
        $name = get_lang('Yes');
        break;
  }
  return $name;
}
function get_count_delete() {
global $dbConnection;

            $stmt = $dbConnection->prepare('select count(id) as t1 from approve ');
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $row['t1'];
            if ($count != '0'){
              return $count;
            }
}
function show_date()
{
$day=date('j');
$mounth=date('m');
$year=date('Y');
$data=array('01'=>get_lang('January'),'02'=>get_lang('February'),'03'=>get_lang('March'),'04'=>get_lang('April'),'05'=>get_lang('May'),'06'=>get_lang('June'),'07'=>get_lang('July'),'08'=>get_lang('August'),'09'=>get_lang('September'),'10'=>get_lang('October'),'11'=>get_lang('November'),'12'=>get_lang('December'));
foreach ($data as $key=>$value)
{
if ($key==$mounth) echo "<b>".get_lang('Today')." - $day $value $year ".get_lang('G')."</font></b>";
}
}
function show_date_tomorrow()
{
$day=date("j",strtotime("+1 day"));
$mounth=date('m',strtotime("+1 day"));
$data=array('01'=>get_lang('January'),'02'=>get_lang('February'),'03'=>get_lang('March'),'04'=>get_lang('April'),'05'=>get_lang('May'),'06'=>get_lang('June'),'07'=>get_lang('July'),'08'=>get_lang('August'),'09'=>get_lang('September'),'10'=>get_lang('October'),'11'=>get_lang('November'),'12'=>get_lang('December'));
foreach ($data as $key=>$value)
{
  if ($key==$mounth) $d = "$day $value";
  }
  return $d;
}
function show_date_after_tomorrow()
{
$day=date("j",strtotime("+2 day"));
$mounth=date('m',strtotime("+2 day"));
$data=array('01'=>get_lang('January'),'02'=>get_lang('February'),'03'=>get_lang('March'),'04'=>get_lang('April'),'05'=>get_lang('May'),'06'=>get_lang('June'),'07'=>get_lang('July'),'08'=>get_lang('August'),'09'=>get_lang('September'),'10'=>get_lang('October'),'11'=>get_lang('November'),'12'=>get_lang('December'));
foreach ($data as $key=>$value)
{
if ($key==$mounth) $d = "$day $value";
}
return $d;
}
class Tequipment
{
    var $id;            // уникальный идентификатор
    var $orgid;         // какой организации принадлежит
    var $placesid;      // в каком помещении
    var $usersid;       // какому пользователю принадлежит
    var $nomeid;        // связь со справочником номенклатуры
    var $tmcname;       // наименование ТМЦ из справочника номенклатуры
    var $buhname;       // имя по "бухгалтерии"
    var $datepost;      // дата прихода
    var $dtendgar;      // дата гарантии
    var $cost;          // стоимость прихода
    var $currentcost;   // текущая стоимость
    var $sernum;        // серийный номер
    var $invnum;        // инвентарный номер
    var $invoice;       // номер накладной
    var $bum;           // на бумаге
    var $os;            // основные средства? 1 - да, 0 - нет
    var $mode;          // списано?  1 - да, 0 - нет
    var $comment;       // комментарий к ТМЦ
    var $photo;         // файл с фото
    var $repair;        // в ремонте?   1 - да, 0 - нет
    var $active;        // помечено на удаление?  1 - да, 0 - нет
    var $ip;            // Ip адрес
    var $kntid;        // поставщик

function GetById($in){ // обновляем профиль работника с текущими данными (все что заполнено)
	global $dbConnection;
	$stmt = $dbConnection->prepare ('SELECT equipment.comment,equipment.ip,equipment.photo,equipment.nomeid,getvendorandgroup.grnomeid,equipment.id AS eqid,equipment.orgid AS eqorgid, org.name AS orgname, getvendorandgroup.vendorname AS vname,
            getvendorandgroup.groupname AS grnome,places.id as placesid,knt.id as kntid, places.name AS placesname, users.login AS userslogin, users.id AS usersid,
            getvendorandgroup.nomename AS nomename, buhname, sernum, invnum, invoice, datepost,dtendgar, cost, currentcost, os, equipment.mode AS eqmode,bum,equipment.comment AS eqcomment, equipment.active AS eqactive,equipment.repair AS eqrepair
	FROM equipment
	INNER JOIN (
	SELECT nome.groupid AS grnomeid,nome.id AS nomeid, vendor.name AS vendorname, group_nome.name AS groupname, nome.name AS nomename
	FROM nome
	INNER JOIN group_nome ON nome.groupid = group_nome.id
	INNER JOIN vendor ON nome.vendorid = vendor.id
	) AS getvendorandgroup ON getvendorandgroup.nomeid = equipment.nomeid
	INNER JOIN org ON org.id = equipment.orgid
	INNER JOIN places ON places.id = equipment.placesid
	INNER JOIN users ON users.id = equipment.usersid
        LEFT JOIN knt ON knt.id = equipment.kntid WHERE equipment.id IN (:in)');
        $stmt->execute(array(':in' => $in));
        $res1 = $stmt->fetchAll();
          		if ($res1!=''){
        foreach($res1 as $myrow) {
                        $this->id=$myrow["eqid"];
                        $this->orgid=$myrow["eqorgid"];
                        $this->placesid=$myrow["placesid"];
                        $this->usersid=$myrow["usersid"];
                        $this->nomeid=$myrow["nomeid"];
                        $this->buhname=$myrow["buhname"];
                        $this->datepost=$myrow["datepost"];
                        $this->dtendgar=$myrow["dtendgar"];
                        $this->cost=$myrow["cost"];
                        $this->currentcost=$myrow["currentcost"];
                        $this->sernum=$myrow["sernum"];
                        $this->invnum=$myrow["invnum"];
                        $this->invoice=$myrow["invoice"];
                        $this->os=$myrow["os"];
                        $this->mode=$myrow["eqmode"];
                        $this->bum=$myrow["bum"];
                        $this->comment=$myrow["comment"];
                        $this->photo=$myrow["photo"];
                        $this->repair=$myrow["eqrepair"];
                        $this->active=$myrow["eqactive"];
                        $this->ip=$myrow["ip"];
                        $this->tmcname=$myrow["nomename"];
                        $this->kntid=$myrow["kntid"];
                };};
              }
            };
 ?>