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
            <div class="col-md-6"> <h3><i class="fa fa-sitemap" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_ping');?></h3>
            </div>
   </div>
    </div>
   <div class="row">
     <div class="col-md-12">
       <div class="panel panel-default">
       <div class="panel-heading">
<div class="row">
  <div class="col-md-8">
  <div class="col-md-4">
    <label class="control-label"><small><?=get_lang('Orgname')?>:</small></label>
  <select data-placeholder="Выберите организацию" class='my_select select' name=sorgid id=sorgid>
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
    <div class="col-md-4">

  <label class="control-label"><small><?=get_lang('Matname')?>:</small></label>
<select data-placeholder="Выберите Мат.отв." class='my_select select' name=suserid id=suserid>
      <option value=""></option>
      <?php
      $morgs=GetArrayUsers_Ping_Test();
      for ($i = 0; $i < count($morgs); $i++) {
          $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
          if ($nid==$userid){$sl=" selected";} else {$sl="";};
          echo "<option value=$nid $sl>$nm</option>";
      };
      ?>
    </select>
</div>
<div class="col-md-4">
<label class="control-label"><small><?=get_lang('Places')?>:</small></label>
<select data-placeholder="Выберите помещение" class='my_select select' name=splaces id=splaces>
       <option value=""></option>
       <?php
       $morgs=GetArrayPlaces_Ping_Test();
       for ($i = 0; $i < count($morgs); $i++) {
           $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
           if ($nid==$placesid){$sl=" selected";} else {$sl="";};
           echo "<option value=$nid $sl>$nm</option>";
       };
       ?>
    </select>
  </div>

    <div class="col-md-4">
      <button type="submit" id="test_ping" class="btn btn-primary allwidht" name="test_ping" style="margin-top: 10px;"><i class="fa fa-hand-o-up" aria-hidden="true"></i>&nbsp;<?=get_lang('Test_ping')?></button>
  </div>
</div>
</div>
</div>

<div class="panel-body">
  <div id="ping_show">
<table  id="ping" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
<thead>
<tr>
<th class="center_header"><?=get_lang('Status')?></th>
<th class="center_header"><?=get_lang('Ip_name')?></th>
<th class="center_header"><?=get_lang('Namenome')?></th>
<th class="center_header"><?=get_lang('Group')?></th>
<th class="center_header"><?=get_lang('Where')?></th>
<th class="center_header"><?=get_lang('Matname')?></th>
</tr>
</thead>
</table>
</div>
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
