
<?php

include_once("header.php");


?>
<style type="text/css">
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        max-width: 360px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
.text-muted {
	color: #777;
    }

    .form-control {
display: block;
width: 100%;
color: #555;
}
</style>
<div class="container" id='main_login'>
<form class="form-signin" action="<?=$CONF['hostname']?>index.php" method="post" autocomplete="off">
    <center>
	<img src="<?=$CONF['hostname']?>images/logo128.png">
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
        <?php if (isset($va) == 'error') { ?>
            <div class="alert alert-danger">
                <center><?=get_lang('error_auth');?></center>
            </div> <?php } ?>
            <input type="hidden" name="req_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
  <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;<?=get_lang('log_in');?></button>
  <?php

   if ($CONF['first_login'] == "true") { ?>
  <small>
      <center style=" margin-bottom: -20px; "><br><a href="#" id="show_activate_form"><?=get_lang('first_in_auth');?></a>
      </center>
  </small>
<?php } ?>


</form>
</div>
<script src="<?=$CONF['hostname']?>js/jquery-1.12.4.min.js"></script>
<script src="<?=$CONF['hostname']?>js/bootstrap.js"></script>
<script>
    $(document).ready(function() {
        $("#main_login").hide().fadeIn(500);
        $('body').on('click', 'a#show_activate_form', function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?=$CONF['hostname']?>actions.php",
                data: "mode=activate_login_form",
                success: function(html){
                    //alert(html);
                    $(".form-signin").hide().html(html).fadeIn(500);



                    $('body').on('click', 'button#do_activate', function(event) {
                        event.preventDefault();
                        var m=$("#mailadress").val();
                        $.ajax({
                            type: "POST",
                            url: "<?=$CONF['hostname']?>actions.php",
                            data: "mode=activate_login"+
                                "&mailadress="+m,
                            success: function(html){
                                //alert(html);
                                $(".form-signin").hide().html(html).fadeIn(500);
                            }
                        });





                    });




                }
            });



        });



    });
</script>