<?php 
  session_start();
  date_default_timezone_set('Asia/Tehran');
  if (!isset($_GET['equent']))
  {
      header("location:../../");
      exit();
  }
  require "../../users/api/API.php";
  require "../../db/db.php";
  require "../../notif/notif.php";
  $recovery = $_GET['equent'];
  $sql="select * from tmpuser where recovery=:recovery;";
  $result=$connect->prepare($sql);
  $result->bindvalue(":recovery",$recovery);
  $result->execute();
  $fetch=$result->fetch(PDO::FETCH_ASSOC);
  if (!isset($fetch['id'])) {
    header("location:../../");
    exit();
  }elseif ($fetch['allow'] == 0) {
    header("location:../../");
    exit();
  }elseif ($fetch['time']<time()) {
    header("location:../../");
    exit();
  }else{
  $_SESSION['who'] = $fetch['username'];
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

</head>

<body>
  
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
</div>
<div class="container">
  <div class="card">
    <h2 class="title">Retrieve Password </h2>
    <form method="post" action="sendpass.php">
      <div class="input-container">
        <input name="Password1" type="password" id="#{label}" required="required"/>
        <label for="#{label}">Enter Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
      
      <input name="Password2" type="password" id="#{label}" required="required"/>
      <label  for="#{label}">Enter Password Again</label>
      <div class="bar"></div>
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

    <?php
  }
?>
