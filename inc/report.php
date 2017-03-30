<?php
session_start();
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");
  if ((in_array('1-1', explode(",",validate_menu($_SESSION['dilema_user_id'])))) || (validate_priv($_SESSION['dilema_user_id']) == 1)){
 ?>
 <div class="container-fluid">
   <div class="page-header" style="margin-top: -15px;">
   <div class="row">
            <div class="col-md-6"> <h3><i class="fa fa-binoculars" aria-hidden="true"></i>&nbsp;<?=get_lang('Menu_reports');?></h3>
            </div>
   </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading">
          <div class="form-inline">
          <div class="row">
          <div class="col-md-12">
          <div class="col-md-3">
            <label class="control-label"><small>Название отчета:</small></label>
              <select class="my_select select" name="sel_rep" id="sel_rep">
                  <option value=1>Наличие ТМЦ</option>
                  <option value=2>Наличие ТМЦ - только не списанное</option>
                  <option value=3>Наличие ТМЦ - только не ОС и не списанное</option>
                  <option value=4>Наличие ТМЦ - только не на бумаге</option>
                  <option value=5>Утилизированное ТМЦ</option>
                  <option value=6>Проданное ТМЦ</option>

              </select>
              <label class="control-label" style="margin-top: 5px;"><small><?=get_lang('Matname');?>:</small></label>
<select data-placeholder="Выберите Мат.отв." class='my_select select' multiple name="userid" id="userid">
<option value=""></option>
<?php
$morgs=GetArrayUsers();
for ($i = 0; $i < count($morgs); $i++) {
 $nid=$morgs[$i]["id"];$nm=$morgs[$i]["fio"];
 // if ($nid==$userid){$sl=" selected";} else {$sl="";};
 // echo "<option value=$nid $sl>$nm</option>";
 echo "<option value=$nid>$nm</option>";
};
?>
</select>
<button type="submit" id="clear_user" class="btn btn-danger btn-xs allwidht" name="clear_user" style="margin-top: 5px;"><i class="fa fa-eraser" aria-hidden="true"></i>&nbsp;<?=get_lang('Clear_select');?></button>
    <input type="checkbox" name="us" id="us" hidden="hidden">
            </div>

          <div class="col-md-3">
          <label class="control-label"><small><?=get_lang('Orgname');?>:</small></label>
          <select data-placeholder="Выберите организацию" class='my_select select' multiple name="orgid" id="orgid">
           <option value=""></option>
         <?php
         $morgs=GetArrayOrg();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
            //  if ($nid==$orgid){$sl=" selected";} else {$sl="";};
            //  echo "<option value=$nid $sl>$nm</option>";
             echo "<option value=$nid $sl>$nm</option>";
         };
         ?>
          </select>
          <button type="submit" id="clear_org" class="btn btn-danger btn-xs allwidht" name="clear_org" style="margin-top: 5px; margin-bottom: 5px;"><i class="fa fa-eraser" aria-hidden="true"></i>&nbsp;<?=get_lang('Clear_select');?></button>
          <label class="checkbox-inline">
  <input type="checkbox" name="os" id="os" value="1"><b><small>Основные</small></b>
</label><br>
<label class="checkbox-inline">
  <input type="checkbox" name="mode" id="mode" value="1"><b><small>Списано</small></b>
</label>
  <input type="checkbox" name="gr" id="gr" hidden="hidden"><br>
<label class="checkbox-inline">
  <input type="checkbox" name="bum" id="bum" value="1"><b><small>На Бумаге</small></b>
</label>
</div>

<div class="col-md-3">
  <label class="control-label"><small><?=get_lang('Places');?>:</small></label>
          <select data-placeholder="Выберите помещение" class='my_select select' multiple name="placesid" id="placesid">
           <option value=""></option>
         <?php
         $morgs=GetArrayPlaces();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
            //  if ($nid==$placesid){$sl=" selected";} else {$sl="";};
            //  echo "<option value=$nid $sl>$nm</option>";
             echo "<option value=$nid $sl>$nm</option>";
         };
         ?>
       </select>
       <button type="submit" id="clear_places" class="btn btn-danger btn-xs allwidht" name="clear_places" style="margin-top: 5px; margin-bottom: 5px;"><i class="fa fa-eraser" aria-hidden="true"></i>&nbsp;<?=get_lang('Clear_select');?></button>
       <label class="checkbox-inline">
  <input type="checkbox" name="repair" id="repair" value="1"><b><small>В ремонте</small></b>
</label><br>
<label class="control-label" style="margin-top: 5px;"><small>Год:</small></label>
<p><input class="form-control input-sm allwidht" name="dtpost_report" id="dtpost_report" readonly='true' maxlength="4" type="text" autocomplete="off"></p>
</div>
<div class="col-md-3">
  <label class="control-label"><small><?=get_lang('Group');?>:</small></label>
          <select data-placeholder="Выберите группу" class='my_select select' multiple name="groupid" id="groupid">
           <option value=""></option>
         <?php
         $morgs=GetArrayGroup();
         for ($i = 0; $i < count($morgs); $i++) {
             $nid=$morgs[$i]["id"];$nm=$morgs[$i]["name"];
            //  if ($nid==$placesid){$sl=" selected";} else {$sl="";};
            //  echo "<option value=$nid $sl>$nm</option>";
             echo "<option value=$nid $sl>$nm</option>";
         };
         ?>
       </select>
              <button type="submit" id="clear_group" class="btn btn-danger btn-xs allwidht" name="clear_group" style="margin-top: 5px; margin-bottom: 5px;"><i class="fa fa-eraser" aria-hidden="true"></i>&nbsp;<?=get_lang('Clear_select');?></button>
     </div>
</div>
</div>
<div class="row">
  <div class="col-md-8">
  <div class="col-md-4">
<div id="view-source">
<label class="control-label view-source"><small>Дополнительный поиск <i class="fa fa-plus" aria-hidden="true"></i></small></label>
</div>
</div>
</div>
  <div class="col-md-12">
	<div class="dop">
		<br>
			<div class="col-md-2" style="width: 16%">
		<label class="control-label"><small>Поиск по наименованию:</small></label>
	  <textarea class="form-control input-sm" id="name_poisk" cols="20" rows="2" name="name_poisk" type="text" placeholder="Введите наименование" on data-toggle="tooltip" data-placement="bottom" title="Можно ввести только часть наименования."></textarea>
		</div>
			<div class="col-md-2" style="width: 16%">
		<label class="control-label"><small>Поиск по штрихкоду:</small></label>
	  <textarea pattern="\d{13}" class="form-control input-sm" id="shtr" cols="20" rows="2" name="shtr" type="text" placeholder="Введите штрихкод" data-toggle="tooltip" data-placement="bottom" title="Вводить только полностью."></textarea>
		</div>
			<div class="col-md-2" style="width: 16%">
		<label class="control-label"><small>Поиск по серийному номеру:</small></label>
	  <textarea class="form-control input-sm" id="ser" cols="20" rows="2" name="ser"  type="text" placeholder="Введите серийный номер" data-toggle="tooltip" data-placement="bottom" title="Можно ввести часть серийного номера, но желательно вводить полностью."></textarea>
		</div>
			<div class="col-md-2" style="width: 16%">
		<label class="control-label"><small>Поиск по бух.имени:</small></label>
	  <textarea class="form-control input-sm" id="buhn" cols="20" rows="2" name="buhn" type="text" placeholder="Введите бух.имя" data-toggle="tooltip" data-placement="bottom" title="Можно ввести только часть имени по бухгалтерии."></textarea>
		</div>
			<div class="col-md-2" style="width: 16%">
		<label class="control-label"><small>Поиск по номеру накладной:</small></label>
	  <textarea class="form-control input-sm" id="nakl" cols="20" rows="2" name="nakl" type="text" placeholder="Введите номер накладной" data-toggle="tooltip" data-placement="bottom" title="Можно ввести только номер накладной."></textarea>
		</div>
		</div>
</div>
  <div class="col-md-8">
<div class="col-md-4">
  <button type="submit" id="report_table" class="btn btn-primary allwidht" name="report_table" style="margin-top: 10px;"><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;<?=get_lang('Sfrom');?></button>
</div>
</div>
</div>
</div>
        </div>
   <div class="panel-body">
     <div id="report_show">
     <table id="report" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
         <thead>
           <tr>
             <th class="center_header"><?=get_lang('Id')?></th>
             <th class="center_header"><?=get_lang('Places')?></th>
             <th class="center_header"><?=get_lang('Namenome')?></th>
             <th class="center_header"><?=get_lang('Group')?></th>
             <th class="center_header"><?=get_lang('Vendor')?></th>
             <th class="center_header"><?=get_lang('Buhname')?></th>
             <th class="center_header"><?=get_lang('Sernum')?></th>
             <th class="center_header"><?=get_lang('Oldshtrih')?></th>
             <th class="center_header"><?=get_lang('Shtrih')?></th>
             <th class="center_header"><?=get_lang('Orgname')?></th>
             <th class="center_header"><?=get_lang('Matname')?></th>
             <th class="center_header"><?=get_lang('Dateprihod')?></th>
             <th class="center_header"><?=get_lang('Cost')?></th>
             <th class="center_header"><?=get_lang('Spisan')?></th>
             <th class="center_header"><?=get_lang('Os')?></th>
             <th class="center_header"><?=get_lang('Bum')?></th>
             <th class="center_header"><?=get_lang('Kntname')?></th>
             <th class="center_header"><?=get_lang('Invoice')?></th>
             <th class="center_header"><?=get_lang('Comment')?></th>
           </tr>
         </thead>
     </table>
   </div>
   </div>
 </div>
 <div id="report_move_show">
 <div class="panel panel-default">
 <div class="panel-heading">
   <i class="fa fa-random" aria-hidden="true"></i>&nbsp;<?=get_lang('Equipment_move');?>

 </div>
<div class="panel-body">
 <table id="report_move_show_rep" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
     <thead>
       <tr>
         <th rowspan="2" class="center_header"><?=get_lang('Id')?></th>
         <th rowspan="2" class="center_header"><?=get_lang('Date')?></th>
         <th colspan="5" class="center_header"><?=get_lang('From')?></th>
         <th colspan="3" class="center_header"><?=get_lang('To')?></th>
         <th rowspan="2" class="center_header"><?=get_lang('Comment')?></th>
       </tr>
       <tr>
         <th class="center_header"><?=get_lang('Orgname')?></th>
         <th class="center_header"><?=get_lang('Places')?></th>
         <th class="center_header"><?=get_lang('Matname')?></th>
         <th class="center_header"><?=get_lang('Kntname')?></th>
         <th class="center_header"><?=get_lang('Invoice')?></th>
         <th class="center_header"><?=get_lang('Orgname')?></th>
         <th class="center_header"><?=get_lang('Places')?></th>
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
