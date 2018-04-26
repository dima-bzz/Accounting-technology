<?php
$time_start = microtime(true);
session_start();
include_once("config.php");
if (isset($CONF_DB)) {
include_once("functions.php");

if (isset($_GET['logout'])) {

  session_destroy();
  unset($_SESSION);
  session_unset();
  setcookie('authhash_usid', "");
  setcookie('authhash_uscode', "");
  setcookie('cookie_eq_util', "");
  setcookie('cookie_eq_sale', "");
  setcookie('on_off_cookie', "");
  unset($_COOKIE['authhash_usid']);
  unset($_COOKIE['authhash_uscode']);
  unset($_COOKIE['cookie_eq_util']);
  unset($_COOKIE['cookie_eq_sale']);
  unset($_COOKIE['on_off_cookie']);

  header("Location: ".$CONF['hostname']);
  // ТУТ УДАЛИТЬ КУКИ


}

$rq=0;
if (isset($_POST['login']) && isset($_POST['password']))
{

    $rq=1;
    $req_url=$_POST['req_url'];
//echo $rm;
    $rm=$_POST['remember_me'];

    $login = ($_POST['login']);
    $password = $_POST['password'];

    $stmt = $dbConnection->prepare('SELECT id,login,fio,on_off from users where login=:login AND pass=:pass AND on_off=1 AND dostup=1');
    $stmt->execute(array(':login' => $login, ':pass' => $password));

    if ($stmt -> rowCount() == 1) {
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);


		// session_regenerate_id(true);
        UpdateLastdt($row['id']);
        $_SESSION['dilema_user_id'] = $row['id'];
        $_SESSION['dilena_user_login'] = $row['login'];
        $_SESSION['dilema_user_fio'] = $row['fio'];
        $_SESSION['dilema_org'] = get_conf_param('default_org');
        $_SESSION['dilema_date'] = date('Y-m-d');
        setcookie ('on_off_cookie',$row['on_off']);
        setcookie('cookie_eq_util','0');
        setcookie('cookie_eq_sale','0');
        $_SESSION['us_code'] = $password;
        if (isset($_POST['remember_me'])){

        $rm=$_POST['remember_me'];
        if ($rm == "1") {

            setcookie('authhash_usid', $_SESSION['dilema_user_id'], time()+60*60*24*7);
            setcookie('authhash_uscode', $_SESSION['us_code'], time()+60*60*24*7);
            setcookie('cookie_eq_util', '0', time()+60*60*24*7);
            setcookie('cookie_eq_sale', '0', time()+60*60*24*7);
            setcookie ('on_off_cookie',$row['on_off'], time()+60*60*24*7);

          }
        }
    }
    else {
        $va='error';
    }
}

if (isset($_SESSION['dilema_user_id']) && isset($_SESSION['us_code'])){

  $permit = validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code']);

}
else if (isset($_COOKIE['authhash_usid']) && isset($_COOKIE['authhash_uscode'])){

  if (!isset($_SESSION['dilema_user_id']) && !isset($_SESSION['us_code'])){
                 $user_id=$_COOKIE['authhash_usid'];
                 $input=$_COOKIE['authhash_uscode'];
                 $_SESSION['us_code']=$input;
                 $_SESSION['dilema_user_id']=$user_id;
                 $_SESSION['dilema_org'] = get_conf_param('default_org');
                 $_SESSION['dilema_date'] = date('Y-m-d');
   }

  $permit = validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code']);

}
else{

      session_destroy();
      unset($_SESSION);
      session_unset();
      setcookie('authhash_usid', "");
      setcookie('authhash_uscode', "");
      setcookie('cookie_eq_util', "");
      setcookie('cookie_eq_sale', "");
      setcookie('on_off_cookie', "");
      unset($_COOKIE['authhash_usid']);
      unset($_COOKIE['authhash_uscode']);
      unset($_COOKIE['cookie_eq_util']);
      unset($_COOKIE['cookie_eq_sale']);
      unset($_COOKIE['on_off_cookie']);

    $permit = false;
}
if($permit){
$url = parse_url($CONF['hostname']);

if ($rq==1) { header("Location: http://".$url['host'].(isset($url['port']) ? ":".$url['port'] : "").$req_url);}
if ($rq==0) {

    if (!isset($_GET['page'])) {
  include("inc/header.php");
    include("inc/menus.php");
    include("inc/home.php");
  include("inc/footer.php");
}

if (isset($_GET['page'])) {


switch($_GET['page']) {
case 'report': 	include('inc/report.php');		break;
case 'eq_list': 	include('inc/eq_list.php');	break;
case 'eq_mat': 	include('inc/eq_mat.php');	break;
case 'cartridge': include('inc/cartridge.php');	break;
case 'contact': 	include('inc/contact.php');	break;
case 'equipment': 	include('inc/equipment.php');	break;
case 'group': include('inc/group.php');	break;
case 'invoice': 	include('inc/invoice.php');	break;
case 'knt': 	include('inc/knt.php');	break;
case 'license': 	include('inc/license.php');	break;
case 'moving': include('inc/moving.php');	break;
case 'nome': 	include('inc/nome.php');	break;
case 'org': 	include('inc/org.php');	break;
case 'perf': 	include('inc/perf.php');	break;
case 'ping': 	include('inc/ping.php');	break;
case 'print':include('inc/print.php');break;
case 'profile':include('inc/profile.php');	break;
case 'requisites': include('inc/requisites.php'); break;
case 'places': include('inc/places.php'); break;
case 'users': include('inc/users.php');	break;
case 'vendors': include('inc/vendors.php');	break;
case 'delete': include('inc/delete.php');	break;
case 'calendar': include('inc/calendar.php');	break;
case 'documents': include('inc/documents.php');	break;
case 'news': include('inc/news.php');	break;
default: include('404.php');
}
}
}

}
else {
include("inc/header.php");
include 'inc/auth.php';
}
} else {
    include "sys/install.php";
}
 ?>