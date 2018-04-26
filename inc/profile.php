<?php
if(!isset($_SESSION))
{
        session_start();
}
if (validate_user($_SESSION['dilema_user_id'], $_SESSION['us_code'])) {
include("header.php");
include("menus.php");

$usid=$_SESSION['dilema_user_id'];



	$stmt = $dbConnection->prepare('SELECT users.fio, users.pass, users.login, users.email, users.lang, users_profile.emaildop, users_profile.jpegphoto from users INNER JOIN users_profile ON users_profile.usersid = users.id where users.id=:usid');
	$stmt->execute(array(':usid'=>$usid));
	$res1 = $stmt->fetchAll();

foreach($res1 as $row) {

$fio=$row['fio'];
$login=$row['login'];
$pass=$row['pass'];
$email=$row['email'];
$emaildop = $row['emaildop'];
$get_lang=$row['lang'];
$photo = $row['jpegphoto'];

if ($get_lang == "en") 	 {$status_get_lang_en="selected";}
else if ($get_lang == "ru") {$status_get_lang_ru="selected";}

}
$photo_new = $photo."?".time();
?>

<div class="container">
<div class="page-header" style="margin-top: -15px;">
          <h3 ><center><?=get_lang('P_title');?></center></h3>
 </div>


<div class="row">



      <div class="col-md-offset-2 col-md-8">
      <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-user" aria-hidden="true"></i> <?=get_lang('P_main');?></div>
      <div class="panel-body">
      <form class="form-horizontal" role="form">
      <div class="form-group">
      <div class="col-sm-4 text-right"><strong ><small><?=get_lang('Fio');?></small></strong></div>
      <div class="col-sm-8"><small><?=$fio;?></small></div>
      </div>
      <div class="form-group">
        <div class="col-sm-4" style="height:140px;display:flex;align-items:center;justify-content:flex-end;"><strong ><small><?=get_lang('Img');?></small></strong></div>
        <div class="col-sm-8" style="display:flex;align-items:center;justify-content:flex-start;">
          <div id="img_show">
            <img src="images/avatar/<?php echo $photo_new?>" class="img-circle">
            <div style="margin-top:5px;">
              <div class="btn-group">
            <button class="btn btn-primary" type="button" id="ch_img" style="width: 75px;">Сменить</button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" style="min-width: 98px !important;" role="menu">
              <li style="width:100px;"><a href="#" id="img_del"><?=get_lang('Delete');?></a></li>
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
      <hr>
      <div class="form-group">
    <label for="login" class="col-sm-4 control-label"><?=get_lang('Login');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="login" type="" class="form-control input-sm" id="login" placeholder="<?=get_lang('Login');?>" value="<?=$login;?>">
        </div>
  </div>
    <div class="form-group">
    <label for="mail" class="col-sm-4 control-label"><?=get_lang('E-mail_O');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="mail" type="text" class="form-control input-sm" id="mail" placeholder="<?=get_lang('E-mail_O');?>" value="<?=$email;?>">
        </div>
  </div>
  <div class="form-group">
  <label for="mail" class="col-sm-4 control-label"><?=get_lang('E-mail_D');?></label>
      <div class="col-sm-8">
  <input autocomplete="off" name="mail" type="text" class="form-control input-sm" id="mail_d" placeholder="<?=get_lang('E-mail_D');?>" value="<?=$emaildop;?>">
      </div>
</div>

          <div class="form-group">
    <label for="get_lang" class="col-sm-4 control-label"><?=get_lang('Lang');?></label>
        <div class="col-sm-8">
    <select data-placeholder="<?=get_lang('Lang');?>" class="my_select form-control input-sm" id="lang" name="lang">
                    <option value="0"></option>

                        <option <?=$status_get_lang_en;?> value="en">English</option>
                        <option <?=$status_get_lang_ru;?> value="ru">Русский</option>
</select>
        </div>
  </div>


    <div class="col-md-offset-3 col-md-6">
<center>
    <button type="submit" id="edit_profile_user" value="<?=$usid?>" class="btn btn-success"><?=get_lang('Save');?></button>
</center>
</div>
      </form>





      </div>

      </div>
      <div id="m_info"></div>
      <div class="panel panel-danger">
      <div class="panel-heading"><i class="fa fa-key" aria-hidden="true"></i> <?=get_lang('P_passedit');?></div>
      <div class="panel-body">
      <form class="form-horizontal" role="form">

              <div class="form-group">
    <label for="old_pass" class="col-sm-4 control-label"><?=get_lang('P_pass_old');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="old_pass" type="password" class="form-control input-sm" id="old_pass" placeholder="<?=get_lang('P_pass_old2');?>">
        </div>
  </div>


        <div class="form-group">
    <label for="new_pass" class="col-sm-4 control-label"><?=get_lang('P_pass_new');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="new_pass" type="password" class="form-control input-sm" id="new_pass" placeholder="<?=get_lang('P_pass_new2');?>">
        </div>
  </div>

          <div class="form-group">
    <label for="new_pass2" class="col-sm-4 control-label"><?=get_lang('P_pass_new_re');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="new_pass2" type="password" class="form-control input-sm" id="new_pass2" placeholder="<?=get_lang('P_pass_new_re2');?>">
        </div>
  </div>
  <div class="col-md-offset-3 col-md-6">
<center>
    <button type="submit" id="edit_profile_pass" value="<?=$usid?>" class="btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> <?=get_lang('P_do_edit_pass');?></button>
</center>
</div>


      </form>

      </div>
      </div>
<div id="p_info"></div>


      </div>




</div>




<br>
</div>
<?php
include("footer.php");
?>
<script type="text/javascript">
	var ava_refresh = "images/avatar/<?php echo "$photo";?>";
  var Avatar = "images/avatar/<?php echo "$photo_new";?>";

var options =
{
    thumbBox: '.thumbBox',
    spinner: '.spinner',
    imgSrc: Avatar
}
window.cropper = $('.imageBox').cropbox(options);
$('#file').on('change', function(){
	var fileExtension = ['<?=str_replace(",", "','", get_conf_param('file_types_img'))?>'];
	if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) !== -1){
    var reader = new FileReader();
    reader.onload = function(e) {
        options.imgSrc = e.target.result;
        cropper = $('.imageBox').cropbox(options);
    }
    reader.readAsDataURL(this.files[0]);
    this.files = [];
    check_er.save = true;
	}
	else {
		BootstrapDialog.alert({
		title: '<?= get_lang("Er_title")?>',
		message: '<?= get_lang("Er_msg_type")?>'  + '(' + fileExtension +')',
		type: BootstrapDialog.TYPE_WARNING,
		draggable: true,
		callback: function() {
			$('#file').val(null);
			}
		});
	}
})
$('#btnZoomIn').on('click', function(){
    cropper.zoomIn();
})
$('#btnZoomOut').on('click', function(){
    cropper.zoomOut();
})
$('#btnRotate').on('click', function(){
    cropper.rotate();
})
$('#btn_file').on('click', function(){
    $('#file').click();
})
</script>
<?php
}
else {
    include 'auth.php';
}
 ?>
