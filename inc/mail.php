<?php
include_once('sys/class.phpmailer.php');


function send_mail($to,$subj,$msg) {
    global $CONF, $CONF_MAIL, $dbConnection;


    if (get_conf_param('mail_type') == "sendmail") {

    $mail = new PHPMailer();
    $mail->CharSet 	  = 'UTF-8';
    $mail->IsSendmail();

  $mail->AddReplyTo($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->AddAddress($to, $to);
  $mail->SetFrom($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->Subject = $subj;
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($msg);
  $mail->Send();

}
else if (get_conf_param('mail_type') == "SMTP") {


    $mail = new PHPMailer();
    $mail->CharSet 	  = 'UTF-8';
    $mail->IsSMTP();
  $mail->SMTPAuth   = $CONF_MAIL['auth'];                  // enable SMTP authentication
if (get_conf_param('mail_auth_type') != "none")
    {
	$mail->SMTPSecure = $CONF_MAIL['auth_type'];
    }
$mail->Host       = $CONF_MAIL['host'];
$mail->Port       = $CONF_MAIL['port'];
$mail->Username   = $CONF_MAIL['username'];
$mail->Password   = $CONF_MAIL['password'];


  $mail->AddReplyTo($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->AddAddress($to, $to);
  $mail->SetFrom($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->Subject = $subj;
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML($msg);
  $mail->Send();




}
}



function mailtoactivate($login, $mails, $pass) {
global $CONF, $CONF_MAIL, $dbConnection;
//global $CONF['hostname'];
    $mfrom_name=get_lang('MAIL_name');
    $mfrom_mail=$CONF_MAIL['from'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";

    'Reply-To: '.$CONF_MAIL['from'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $to      = $mails;
    $subject = get_lang('MAIL_active');

    $MAIL_cong=get_lang('MAIL_cong');
    $MAIL_data=get_lang('MAIL_data');
    $MAIL_adr=get_lang('MAIL_adr');
    $MAIL_login=get_lang('CONF_mail_login');
    $MAIL_pass=get_lang('CONF_mail_pass');

    $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">{$MAIL_cong}</p>

<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;"><center>
      <strong>{$MAIL_data} </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$MAIL_adr}:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;"><a href='{$CONF['hostname']}'> {$CONF['hostname']}</a></td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$MAIL_login}:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$login}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$MAIL_pass}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$pass}</td>
  </tr>
</table>
</center>

</div>
EOBODY;


send_mail($to,$subject,$message);


}
function mailtoactivate_admin($login, $mail, $pass) {
global $CONF, $CONF_MAIL, $dbConnection;

    $MAIL_cong=get_lang('MAIL_cong');
    $MAIL_data=get_lang('MAIL_data');
    $MAIL_adr=get_lang('MAIL_adr');
    $MAIL_login=get_lang('CONF_mail_login');
    $MAIL_pass=get_lang('CONF_mail_pass');
    $mfrom_name=get_lang('MAIL_name');
    $mfrom_mail=$CONF_MAIL['from'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";
    'Reply-To: '.$CONF_MAIL['from'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $to      = $CONF['mail'];
    $subject = get_lang('MAIL_active');
    $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">{$MAIL_cong}</p>

<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;"><center>
      <strong>{$MAIL_data} </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$MAIL_adr}:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;"><a href='{$CONF['hostname']}'> {$CONF['hostname']}</a></td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$MAIL_login}:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$login}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$MAIL_pass}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;">{$pass}</td>
  </tr>
</table>
</center>

</div>
EOBODY;


send_mail($to,$subject,$message);


}
?>