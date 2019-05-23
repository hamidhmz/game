<?php
require "../db/db.php";
if((isset($_POST["btn"]))&&(isset($_COOKIE['tmpname'])))
{
  $email = $_POST['email'];
  include "PHPMailer/class.phpmailer.php";
  $a="select * from tmpuser where username=:username";
  $result=$connect->prepare($a);
  $result->bindvalue(":username",$_COOKIE['tmpname']);
  $result->execute();
  $fetch=$result->fetch(PDO::FETCH_ASSOC);
  $mail=new PHPMailer(true);
  $mail->IsSMTP();
  if(isset($fetch['id'])){
    try
    {
      $mail->Host='smtp.gmail.com';
      $mail->SMTPAuth=true;
      $mail->SMTPSecure="ssl";
      $mail->Port=465;
      $mail->Username="gg7.info@gmail.com";
      $mail->Password="pkr4me8338";
      $mail->AddAddress($_POST["email"]);
      $mail->SetFrom("gg7.info@gmail.com");
      $mail->Subject = 'invite';
      $mail->CharSet="UTF-8";
      $mail->ContentType="text/htm";
      $mail->MsgHTML('این لینک دعوت از طرف</br>'.'http://GGPOT.com/login/?id='.$fetch['id']);
      $mail->Send();
      echo '<font color="#00CC00" size="2" face="tahoma">ایمیل با موفقیت ارسال شد</font>';
      header("location:../?tip=804");
      exit();
    }
    catch(phpmailerException $e)
    {
      $error = $e->errorMessage();
      header("location:../?catch=" . $error);
      exit();
    }
    catch(Exception $e)
    {
      $error = $e->getMessage();
      header("location:../?catch=" . $error);
      exit();
    }
  }
}else{
  header("location:../?error=906");
  exit();
}

?>