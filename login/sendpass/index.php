<?php 
    if (isset($_COOKIE['tmpname']))
    {
        header("location:../../");
        exit();
    }
    date_default_timezone_set('Asia/Tehran');
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, target-densitydpi=medium-dpi, user-scalable=0" />
  <meta name="viewport" content="width=device-width, initial-scale=1">


<title>پوکر | برترین سایت پول واقعی در ایران </title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

<link rel="stylesheet" type="text/css" href="../../fonts/font-awesome-4.6.3/css/font-awesome.min.css">

      <link rel="stylesheet" href="../../css/login.css">

  <style type="text/css">
    @media only screen and (max-width: 768px) {
      h1{font-size: 30px !important;}
      h2{padding: 5px !important;font-size: 25px !important}

    }
    .container{
        max-width: 460px !important;
      }
  </style>
<?php
require "../../db/db.php";
require "../../users/api/API.php";
if(isset($_POST["btn"]))
{
  if (!isset($_POST['ct_captcha'])) {
  header("location:../sendpass/?error=921");
  exit();
  }
  require_once '../securimage.php';
  $securimage = new Securimage();
  $captcha = @$_POST['ct_captcha'];
  if ($securimage->check($captcha) == false) {
  $errors['captcha_error'] = 'Incorrect security code entered';
  header("location:../sendpass/?error=925");
  exit();
  }
  $email = $_POST['email'];
  include "PHPMailer/class.phpmailer.php";
  $a="select * from tmpuser where email=:email";
  $result=$connect->prepare($a);
  $result->bindvalue(":email",$email);
  $result->execute();
  $num=$result->fetchColumn();
  if($num>0)
  {
    $str="0123456789abcdefghijklmnopqrstuvwxyz";
    $max=strlen($str)-1;
    $result="";
    for($i=0;$i<5;$i++)
    {
    $random=rand(0,$max);
    $char=substr($str,$random,1);
    $result.=$char;
    }
    $pass=strtoupper($result);
    $sql="select * from tmpuser where email='" . $email . "' ;";
    $result=$connect->query($sql);
    $fetch=$result->fetch(PDO::FETCH_ASSOC);
    $username = $fetch["username"];
    $active = $fetch["active"];
    $md = md5($pass);
    $time = time();
    $sql1 = "UPDATE `tmpuser` SET `recovery` =:recovery  , allow=1 , `time`=:ltime WHERE `tmpuser`.`email` =:email;";
    $result1=$connect->prepare($sql1);
    $result1->bindvalue(":email",$email);
    $result1->bindvalue(":ltime",$time);
    $result1->bindvalue(":recovery",$md);
    $result1->execute();
    $num=$result1->fetchColumn();
    if($num>0 )
    {
      $to = $email;
      $subject = "reset pass";
      $txt = 'http://ggpot.com/login/reset/?equent=' . md5($pass);
      $headers = "From: info@ggpot.com" . "\r\n" .
      "CC: ".$email;
      mail($to,$subject,$txt,$headers);
      echo '<font color="#00CC00" size="2" face="tahoma">ایمیل با موفقیت ارسال شد</font>';
      header("location:../?tip=804");
      exit();
    }
    
  }
  else
  {
    header("location:?error=906");
    exit();
  }
}


require "../../notif/notif.php";
?>
</head>

<body>
  
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
</div>
<div class="container">
  <div class="card">
    <h2 class="title">Retrieve Password </h2>
    <form method="post" action="">
      <div class="input-container">
        <input name="email" type="#{type}" id="#{label}" required="required"/>
        <label for="#{label}">Enter your email</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
      <?php require_once '../securimage.php'; echo Securimage::getCaptchaHtml(array('input_name' => 'ct_captcha')); ?>
      <div class="bar"></div>
      <label style="top: 162px;" for="#{label}">Enter Captcha code</label>
      </div>
      <div class="button-container">
        <input type="submit" name="btn" value="Send Me !">
      </div>
    </form>
  </div>
  
</div>
<!-- CodePen--><a id="codepen" href="../" title="برگشت به ورود و ثبتنام"><i class="fa fa-arrow-right"></i></a>
<span class="backhome">Back to Login</span>
<div id="video"></div>
<script type="text/javascript" src="../../js/jquery2.min.js"></script>

    <script src="../../js/login.js"></script>

</body>
</html>
