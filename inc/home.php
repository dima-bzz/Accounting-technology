<div class="container-fluid">
<div class="row">

<div class="col-md-12">
            <div class="alert alert-info alert-dismissable"><i class="fa fa-feed"></i>&nbsp;<?=get_myname() .get_lang('Privet_msg');?>
            </div>

</div>
<!-- ///////////////////////////Поиск котактов////////////////////// -->
<style>
.typeahead {
  width: 100%;
  position: absolute;
  max-height: 100px;
  overflow-y: auto;
}
</style>
<div class="col-md-4">
    <div class="panel panel-default">
    <div class="panel-heading">
      <a href="contact"><i class="fa fa-child"></i>&nbsp;<?=get_lang('Contact');?></a>
  	</div>
    <div class="panel-body">
      <div class="form-group">
<div class="input-group ">
<input type="text" class="form-control search_button" name="search" id="search_box"  data-provide="typeahead" autocomplete="off" placeholder="<?=get_lang('Contact_info');?>">
<span class="input-group-btn">
<button type = "button" id="users_online" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="<?=get_lang('Users_online');?>" data-html="true">
 <i class="fa fa-thumbs-up"></i>
</button>
<button type = "button" id="users_offline" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="<?=get_lang('Users_offline');?>" data-html="true">
 <i class="fa fa-thumbs-down"></i>
</button>
<button type = "button" id="input_empty" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="<?=get_lang('Clear_select');?>" data-html="true">
 <i class="fa fa-eraser"></i>
</button>
</span>
</div>
</div>
			<div id="results"></div>
</div>
</div>
<br>
<div class="panel panel-default">
<div class="panel-heading">
  <a href="news"><i class="fa fa-newspaper-o"></i>&nbsp;<?=get_lang('News');?></a>
</div>
<div class="panel-body">
<div id="news_home_content">
  <?php
  get_news();
   ?>
</div>
<?php
$res = $dbConnection->prepare("SELECT count(*) from news ");
$res->execute();
$count = $res->fetch(PDO::FETCH_NUM);
$count=$count[0];
if ($count <> 0){
 ?>
<ul class="pager">
  <li class="previous"><a id="previous">Предыдущая</a></li>
  <li class="next"><a id="next">Следующая</a></li>
</ul>
<?php
}
 ?>
</div>
</div>
</div>
<!-- ///////////////////////////Информация для пользоваетля////////////////////// -->
<div class="col-md-8">
  <div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-smile-o"></i>&nbsp;<?=get_lang('Info');?>
  </div>
  <div style="max-height: 375px;scroll-behavior: initial;overflow-y: auto;">
  <div class="panel-body" id="inf">
  <!-- <div class="well"> -->
    <?php
    show_date();
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
    $users_coll = "&nbsp;&nbsp;&nbsp;<b>".get_lang('Users_coll')." <span id=\"count_update\">".count($count_lt)."</span></b>";
    echo $users_coll;
     ?>
    <div id="time"></div>
    <hr hidden>
<?php
    $year = date("Y");
    $date_today = date("d.m");
    $date_today2 = date("d.m",strtotime("+1 day"));
    $date_today3 = date("d.m",strtotime("+2 day"));

    $bd_list = array(array(),array(),array());
    $bd_dates= array("<span class=\"text-danger\"><strong>Сегодня отмечает свой день рождения:</strong></span>", "<span class=\"text-success\"><strong>Завтра ".show_date_tomorrow()." отмечает свой день рождения:</strong></span>", "<span class=\"text-primary\"><strong>Послезавтра ".show_date_after_tomorrow()." отмечает свой день рождения:</strong></span>");


    $stmt = $dbConnection->prepare ("select users_profile.birthday, users.fio from users_profile INNER JOIN users ON users.id = users_profile.usersid where users_profile.birthday !=' ' and users.on_off = 1 order by users_profile.birthday asc");
    $stmt->execute();
    $res1 = $stmt->fetchAll();
    foreach($res1 as $row) {
                      $bi = substr($row['birthday'], 0, strripos($row['birthday'],'.'));
                      $bi_year = substr($row['birthday'], -4,strripos($row['birthday'],'.'));
                      $fio=$row['fio'];
                      $birthday=$row['birthday'];
                      $god=$year-$bi_year;
                      if ($bi==$date_today){
                        array_push($bd_list[0], "<span class=\"text-danger\"><i class=\"fa fa-birthday-cake\"></i><i>&nbsp; ".$fio."</i></span>");
                      };
                      if ($bi==$date_today2){
                        array_push($bd_list[1], "<span class=\"text-success\"><i class=\"fa fa-birthday-cake\"></i><i>&nbsp; ".$fio."</i></span>");
                      }
                      if ($bi==$date_today3){
                        array_push($bd_list[2], "<span class=\"text-primary\"><i class=\"fa fa-birthday-cake\"></i><i>&nbsp; ".$fio."</i></span>");
                      }

                     };
    for($i=0;$i<=2;$i++) {
      if (sizeof($bd_list[$i])>0) {echo "<br>".$bd_dates[$i];}
      foreach ($bd_list[$i] as $fio_d) {
        echo "<br>".$fio_d;
      }
    }
    if (sizeof($fio_d)>0) {echo "<br>";}
//////////////////////////
  $day_event = date("d.m.Y");
  $remind_month = date("m.Y",strtotime("+1 month"));
  $remind_month2 = date("m.Y");
  $remind_day = date("d.m.Y",strtotime("+1 day"));
  $event_list = array(array(),array(),array(),array());
  $event_dates= array("<span class=\"text-warning\"><strong>Спиоск дел на сегодня:</strong></span>", "<span class=\"text-warning\"><strong>Список дел на завтра:</strong></span>", "<span class=\"text-warning\"><strong>Список дел на неделю:</strong></span>", "<span class=\"text-warning\"><strong>Список дел на следущий месяц (а так же текущий):</strong></span>");
  $usid=$_SESSION['dilema_user_id'];
  $stmt = $dbConnection->prepare("select event_name, event_start, remind,event_repeat FROM calendar WHERE usersid=:usid");
  $stmt->execute(array(':usid' => $usid));
  $res1 = $stmt->fetchAll();
  foreach($res1 as $row) {
    $event_name=$row['event_name'];
    $remind=$row['remind'];
    $event_start=MySQLDateTimeToDateCal($row['event_start']);
    $event_month = MySQLDateTimeToDateRemindMonth($row['event_start']);
    // $event_day = MySQLDateTimeToDateRemindDay($row['event_start']);
    $remind_weeks = count_week_days(strtotime($day_event),strtotime($event_start));

      if ($row['event_repeat'] == '1'){
        $yearBegin = MySQLDateTimeToDateYear($row['event_start']);
        $yearEnd = date("Y",strtotime('+1 year'));
        $years = range($yearBegin, $yearEnd, 1);
        foreach ($years as $year) {
                $ev_day1 = explode("-", $row['event_start']);
                $ev_day2 = explode(" ", $ev_day1[2]);
                $ev_day = $ev_day2[0].".".$ev_day1[1].".".$year;
                $ev_month = $ev_day1[1].".".$year;
          $remind_year = count_week_days(strtotime($day_event),strtotime($ev_day));
          if ($day_event==$ev_day){
          array_push($event_list[0], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
        }
        if ($remind == '3'){
            if ($remind_day==$ev_day){
            array_push($event_list[1], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
          }
        }
          if ($remind == '2'){
            if ($remind_year != '0' && $remind_year <= '7'){
            array_push($event_list[2], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$ev_day."</a>");
          }
        }
          if ($remind == '1'){
            if (($ev_month==$remind_month) or ($ev_month==$remind_month2) && ($ev_day != $day_event) && ($remind_year != '0')){
            array_push($event_list[3], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$ev_day."</a>");
          }
        }
      }
    }

    if ($row['event_repeat'] == '2'){
      $v = date("L", mktime(0,0,0, 7,7, date('Y')));
      $monthBegin = new DateTime(MySQLDateTimeToDateCal($row['event_start']));
      $monthBegin->modify('first day of this month');
      $interval_month = new DateInterval('P1M');
      $monthEnd = new DateTime (date('d.m.Y', strtotime('+2 month')));
      $period_month = new DatePeriod($monthBegin,$interval_month,$monthEnd);
      foreach ($period_month as $monthh) {
        $month = $monthh->format('m.Y');
        $month_m = $monthh->format('m');
        $ev_day1 = explode("-", $row['event_start']);
        $ev_day2 = explode(" ", $ev_day1[2]);
      if ($v != '1'){
      if (($month_m == '02') && ($ev_day2[0] == '30')){
      $ev_day = "28.".$month;
      }
      else if (($month-m == '02') && ($ev_day2[0] == '31')){
      $ev_day = "28.".$month;
      }
      else if (($month-m == '02') && ($ev_day2[0] == '29')){
      $ev_day = "28.".$month;
      }
      else if ((($month-m == '04')||($month-m == '06')||($month-m == '04')||($month-m == '09')||($month-m == '11'))&&($ev_day2[0] == '31')){
      $ev_day = "30.".$month;
      }
      else{
      $ev_day = $ev_day2[0].".".$month;
      }
      }
      if ($v != '0'){
      if (($month-m == '02') && ($ev_day2[0] == '30')){
      $ev_day = "29.".$month;
      }
      else if (($month-m == '02') && ($ev_day2[0] == '31')){
      $ev_day = "29.".$month;
      }
      else if ((($month-m == '04')||($month-m == '06')||($month-m == '04')||($month-m == '09')||($month-m == '11'))&&($ev_day2[0] == '31')){
      $ev_day = "30.".$month;
      }
      else{
      $ev_day = $ev_day2[0].".".$month;
      }
      }
      $remind_month_c = count_week_days(strtotime($day_event),strtotime($ev_day));
        if ($day_event==$ev_day){
        array_push($event_list[0], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
      }
      if ($remind == '3'){
          if ($remind_day==$ev_day){
          array_push($event_list[1], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
        }
      }
        if ($remind == '2'){
          if ($remind_month_c != '0' && $remind_month_c <= '7'){
          array_push($event_list[2], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$ev_day."</a>");
        }
      }
        if ($remind == '1'){
          if (($month==$remind_month) or ($month==$remind_month2) && ($ev_day != $day_event) && ($remind_month_c != '0')){
          array_push($event_list[3], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$ev_day."</a>");
        }
      }
    }
  }
  if ($row['event_repeat'] == '3'){
    $eventStart=MySQLDateTimeToDateCal($row['event_start']);
    $eventEnd = new DateTime(date('d.m.Y',strtotime('+2 month')));
    $interval_week = new DateInterval('P7D');
    $period_week = new DatePeriod(new DateTime($eventStart),$interval_week,$eventEnd);
    foreach ($period_week as $weeks) {
      $week= $weeks->format('d.m.Y');
      $week_m = $weeks->format('m.Y');
      $remind_week = count_week_days(strtotime($day_event),strtotime($week));
      // echo $remind_week.">>>".$week.">>>>".$event_name."<br>";
      if ($day_event==$week){
      array_push($event_list[0], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
    }
    if ($remind == '3'){
        if ($remind_day==$week){
        array_push($event_list[1], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
      }
    }
      if ($remind == '2'){
        if ($remind_week != '0' && $remind_week <= '7'){
        array_push($event_list[2], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$week."</a>");
      }
    }
      if ($remind == '1'){
        if (($week_m==$remind_month) or ($week_m==$remind_month2) && ($week != $day_event) && ($week>$day_event)){
        array_push($event_list[3], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$week."</a>");
      }
    }
  }
}
if ($row['event_repeat'] == '0'){
      if ($event_start==$day_event){
      array_push($event_list[0], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
    }
    if ($remind == '3'){
      if ($event_start==$remind_day){
      array_push($event_list[1], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name."</a>");
    }
  }
    if ($remind == '2'){
      if ($remind_weeks != '0' && $remind_weeks <= '7'){
      array_push($event_list[2], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$event_start."</a>");
    }
  }
    if ($remind == '1'){
      if (($event_month==$remind_month) or ($event_month==$remind_month2) && ($event_start != $day_event) && ($event_start>$day_event)){
      array_push($event_list[3], "<span class=\"text-warning\"><i class=\"fa fa-bell\"></i>&nbsp; <a href=\"calendar\"style=\"text-decoration:underline; color:#8a6d3b;\">".$event_name." - ".$event_start."</a>");
    }
  }
  }
}
  for($i=0;$i<=3;$i++) {
    if (sizeof($event_list[$i]) > 0 ) {echo "<br>".$event_dates[$i];}
    foreach ($event_list[$i] as $eve){
      echo "<br>".$eve;
    }
  }
  if (sizeof($eve) > 0 ) {echo "<br>";};
//////////////////////////
    $user_id=$_SESSION['dilema_user_id'];
    $permit_users_license = get_conf_param('permit_users_license');
    $permit = explode(",",$permit_users_license);
    foreach ($permit as $permit_id) {
      if ($user_id == $permit_id){
        $priv_license="yes";
      }
    }
    if ((validate_priv($_SESSION['dilema_user_id']) == 1) || ($priv_license == 'yes')) {
      $month = date("m.Y");
      $month2 = date("m.Y",strtotime("+1 month"));
      $month3 = date("m.Y",strtotime("-1 month"));
      $license_list = array();
      $i=1;

      $stmt = $dbConnection->prepare("select count(*) as count, license.antivirus, org.name from license INNER JOIN org ON org.id = license.organti group by license.antivirus,license.organti");
      $stmt->execute();
      $res1 = $stmt->fetchAll();
      foreach($res1 as $row) {
        $orgname=$row['name'];
         $count = $row['count'];
        $anti_date=MySQLDateToDate($row['antivirus']);
        $anti_month = MySQLDateToMonth($row['antivirus']);
        if ((($anti_month==$month)or($anti_month==$month2)or($anti_month==$month3))&&($count != 0)){
          if (validate_priv($_SESSION['dilema_user_id']) == 1){
          array_push($license_list, "<br><span class=\"text-info\"><strong>".$i.". ".$orgname." - ".$anti_date."</strong>&nbsp;<a href=\"license?org=".$orgname."\"style=\"text-decoration:underline; color:#31708f;\">осталось обновить компьютеров: ".$count."</a></span>");
    }
    if ($priv_license == 'yes') {
          array_push($license_list, "<br><span class=\"text-info\"><strong>".$i.". ".$orgname." - ".$anti_date."</strong></span>");
    }
    $i++;
        }
      };
      if (sizeof($license_list) > 0 ) {
        echo "<span class=\"text-info\"><br>Список организаций у которых скоро закончится лицензия на антивирус:</span>";
        foreach ($license_list as $org){
          echo $org;
        }
      }
    };
    ?>
</div>
</div>
</div>
</div>
<div class="col-md-12">
	<div class="panel panel-default">
  <div class="panel-heading">
    <a href="eq_mat"><i class="fa fa-list-ol"></i>&nbsp; <?=get_lang('Eqmat');?></a>
	</div>
<div class="panel-body">
<table id="eq_mat" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="center_table"><?=get_lang('Id')?></th>
      <th class="center_table"><?=get_lang('Places')?></th>
      <th class="center_table"><?=get_lang('Namenome')?></th>
      <th class="center_table"><?=get_lang('Group')?></th>
      <th class="center_table"><?=get_lang('Sernum')?></th>
      <th class="center_table"><?=get_lang('Shtrih')?></th>
      <th class="center_table"><?=get_lang('Orgname')?></th>
      <th class="center_table"><?=get_lang('Matname')?></th>
      <th class="center_table"><?=get_lang('Os')?></th>
      <th class="center_table"><?=get_lang('Spisan')?></th>
      <th class="center_table"><?=get_lang('Buhname')?></th>
    </tr>
    <thead>
    </table>


<script>

</script>
</div>
</div>
</div>
      </div>
    </div>