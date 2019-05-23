<?php
    if (isset($_COOKIE['tmpname']))
    {
        header("location:../");
        exit();
    }
    session_start();
    if (isset($_GET['id']))
    {
      $_SESSION['net'] = $_GET['id'];
    }

    if (3!=34){
        header("location:../backgammon");
        exit;
    }


?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, target-densitydpi=medium-dpi, user-scalable=0" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>پوکر | برترین سایت پول واقعی در ایران </title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.6.3/css/font-awesome.min.css">

  <link href="../users/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../css/login.css">
  <style type="text/css">
      #success_message { border: 1px solid #000; width: 550px; text-align: left; padding: 10px 7px; background: #33ff33; color: #000; font-weight; bold; font-size: 1.2em; border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; }
      fieldset { width: 90%; }
      legend { font-size: 24px; }
      .note { font-size: 18px; }
      form label { display: block; font-weight: bold; }
  </style>
<?php
require "../db/db.php";
require "../notif/notif.php";
?>
</head>

<body>

<!-- Mixins-->
<!-- Pen Title-->

<div class="container" style="margin-top: 50px;font-family: tahoma">
  <div class="card">
    <h2 class="title">Login </h2>
    <form method="post" action="logcheck.php" id="form1" >
      <div class="input-container">
        <input name="UserName" type="#{type}" id="#{label}" required="required"/>
        <label for="#{label}">UserName</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="Password3" type="password" id="#{label}" required="required"/>
        <label for="#{label}">Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">

          <?php require_once 'securimage.php'; echo Securimage::getCaptchaHtml(array('input_name' => 'ct_captcha')); ?>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <input type="submit" name="Submit2" value="Login">
      </div>
      <div class="footer"><a href="sendpass">I forgot my password</a></div>
    </form>
  </div>
  <div class="card alt">
    <div class="toggle"></div>
    <h2 class="title">New Registration
      <div class="close"></div>
    </h2>
    <form method="post" action="sincheck.php">
      <div class="input-container">
        <input name="Player" type="#{type}" id="UserName" required="required"/>
        <label for="UserName">UserName</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="RealName" type="#{type}" id="Full" required="required"/>
        <label for="Full">Full Name</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="Email" type="#{type}" id="Email" required="required"/>
        <label for="Email">Email</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="Password1" type="password" id="Password1" required="required"/>
        <label for="Password1">Paasword</label>
        <div class="bar"></div>
      </div>
      <div class="input-container" style="margin-bottom: 10px">
        <input name="Password2" type="password" id="Password2" required="required"/>
        <label for="Password2">Repeat Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="checkbox" type="checkbox" id="Terms" style="float: left;width: 30px" /><br>
        <label for="Terms" style="top: 33px;left: 55px;">Accept the <a href="" data-toggle = "modal" data-target = "#myModal">Terms and Policies</a></label>

      </div>
      <div class="button-container" style="clear: both;margin-top: 20px">
        <input type="submit" name="Submit1" value="Register">
      </div>
    </form>
  </div>
</div>
<!-- Modal -->
    <div id = "myModal" class="modal fade in" data-keyboard="false" data-backdrop="static">

       <div class = "modal-dialog">
          <div class = "modal-content">
             <div class = "modal-header">
                <h4 class = "modal-title" id = "myModalLabel">
                   قوانین و شرایط سایت ggpot.com
                </h4>
             </div>
             <div class = "modal-body">
                <strong><font color="red">توجه :</font></strong>
                <small>کاربر گرامی لطفا با دقت قوانین را مطالعه نمایید . ثبتنام شما به منزله قبول تمامی شرایط و قوانین می باشد .</small>
                <p style="margin: 30px 0"><small>
                    <?php
                      $sql="select * from topic where id=1";
                      $result=$connect->query($sql);
                      $fetch=$result->fetch(PDO::FETCH_ASSOC);
                      if (isset($fetch['text']))
                      {
                        echo $fetch['text'];
                      }
                    ?>
                </small></p>
             </div>
             <div class = "modal-footer">
                <button type = "button" class = "btn btn-primary" data-dismiss = "modal">
                   فهمیدم و موافقم
                </button>

             </div>

          </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

<!-- CodePen-->
<div id="video"></div>
<script type="text/javascript" src="../js/jquery2.min.js"></script>
<script src="../users/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/login.js"></script>


</body>
</html>
