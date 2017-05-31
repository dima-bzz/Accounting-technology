<?php

$time_end = microtime(true);
$time = round(($time_end - $time_start) * 1000)/1000;
?>

      <div id="footer" style="padding-bottom: 70px;">
          <div class="container" style="padding: 20px;">
            <div class="col-md-8">
              <p class="text-muted credit">
                <small>
                <i class="fa fa-copyright" aria-hidden="true"></i> 2014-2017, Designed by <a href="https://github.com/dima-bzz/" target="blank">DM</a>. Собрано за <?php echo "$time";?> сек.
                </small>
              </p>
            </div>
                </div>
      </div>
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
      <script type="text/javascript">
          var MyHOSTNAME = "<?php echo $CONF['hostname']; ?>";
          var userid = "<?php echo $_SESSION['dilema_user_id']; ?>";
          var lang = "<?php echo get_user_lang(); ?>";
      </script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/jquery-1.12.4.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/jquery.cookie.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/bootstrap3-typeahead.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/bootstrap.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/bootstrap-dialog.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/jquery.dataTables.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/dataTables.bootstrap.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/jszip.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/pdfmake.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/vfs_fonts.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/dataTables.responsive.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/bootstrap-datepicker.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>lang/bootstrap-datepicker.ru.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/bootstrap-paginator.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/bootstrap-colorpicker.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/jquery.noty.packaged.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/ion.sound.js'></script>



      <script type='text/javascript' src='<?=$CONF['hostname']?>js/dataTables.scroller.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/dataTables.select.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/dataTables.buttons.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/buttons.bootstrap.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/buttons.html5.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/buttons.print.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/buttons.colVis.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/date-de.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/ip-address.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/moment.min.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/fullcalendar.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>lang/ru.js'></script>
      <script type='text/javascript' src="<?=$CONF['hostname']?>js/summernote.js"></script>
      <script type='text/javascript' src="<?=$CONF['hostname']?>js/summernote-ru-Ru.js"></script>
      <script type='text/javascript' src="<?=$CONF['hostname']?>js/jquery.zeninput.js"></script>
      <script type='text/javascript' src="<?=$CONF['hostname']?>js/jquery.i18n.js"></script>
      <script type='text/javascript' src="<?=$CONF['hostname']?>js/jquery.i18n.messagestore.js"></script>





      <script type='text/javascript' src='<?=$CONF['hostname']?>js/chosen.jquery.js' ></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/jquery.maskedinput.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/cropbox.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/waitingfor.js'></script>
      <script type='text/javascript' src='<?=$CONF['hostname']?>js/jquery.caret.js'></script>




      <script type='text/javascript' src='<?=$CONF['hostname']?>js/core.js'></script>

</body>
</html>
