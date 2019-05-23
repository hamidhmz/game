<?php
  require "../../db/db.php";
  require "../../notif/notif.php";
  require "../../users/api/API.php";
  require "PHPMailer/class.phpmailer.php";
  session_start();
  if (!isset($_SESSION['tmpadminname']))
  {
      header("location:../login");
      exit();
  }
  $mail=new PHPMailer(true);
  $mail->IsSMTP();
  $subject = $_GET['subject'];
  echo $message = $_GET['message'];
  $email = $_GET['email'];
  echo $id = $_GET['id'];
  $sql = "UPDATE `tmpcontact` SET `answer` =:answer WHERE `id` =:id";
  $result=$connect->prepare($sql);
  $result->bindvalue(":answer",$message);
  $result->bindvalue(":id",$id);
  $result->execute();
  $num=$result->execute();
  if($num>0 )
  {
    $to = $email;
    $subject = "ggpot support";
    $txt = $message;
    $headers = "From: info@ggpot.com" . "\r\n" .
    "CC: ".$email;

    mail($to,$subject,$txt,$headers);
  
    echo '<font color="#00CC00" size="2" face="tahoma">ایمیل با موفقیت ارسال شد</font>';
    header("location:../contact/?tip=802");
    exit();
    
  }
  