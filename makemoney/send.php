<?php
  if (!isset($_COOKIE['tmpname']))
  {
      header("location:../");
      exit();
  }
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("location:../makemoney/?error=924");
    exit();
  }
  require "../db/db.php";
  require "../notif/notif.php";
  require "../users/api/API.php";
  require "PHPMailer/class.phpmailer.php";
  $sqlp1="select * from tmpuser where email=:email;";
  $resultp1=$connect->prepare($sqlp1);
  $resultp1->bindvalue(":email",$_POST['email']);
  $resultp1->execute();
  $fetchp1=$resultp1->fetch(PDO::FETCH_ASSOC);
  if (isset($fetchp1['id']) && !empty($fetchp1['id'])) {
    header("location:../makemoney/?error=934");exit();
  }
  $who = $_COOKIE['tmpname'];
  $sql="select * from tmpuser where username=:user;";
  $result=$connect->prepare($sql);
  $result->bindvalue(":user",$who);
  $result->execute();
  $fetch=$result->fetch(PDO::FETCH_ASSOC);
  if ($fetch['active'] == 0) {
      header("location:../unset");
      exit();
  }
  if ($fetch['netnum'] > 0) {
    $netnum = $fetch['netnum'];
    $netnum--;
    $subject = "invite";
    $message = $who." Invited You to play Games In ggpot.com\n
for registration please click link below:\n http://GGPOT.com/login/?id=".$fetch['id'];
    $email = $_POST['email'];
    $id = $fetch['id'];
    if($fetch['netnum'] > 0)
    {
      $to = $email;
      $subject = "ggpot support";
      $txt = $message;
      $headers = "From: info@ggpot.com" . "\r\n" .
      "CC: ".$email;
      mail($to,$subject,$txt,$headers);
      header("location:../makemoney/?tip=802");
      exit();
    }
  }
  