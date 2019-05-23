 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>پنل کاربری | پوکر آنلاین </title>

    <!-- Bootstrap Core CSS -->
    <link href="../users/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../users/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../users/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../users/vendor/morrisjs/morris.css" rel="stylesheet">

      <link href="../css/responsive.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../users/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="../users/js/datatable/css/jquery.dataTables.min.css"/>
  <?php
    require "../users/api/API.php";
    require "../db/db.php";
    require "../notif/notif.php";
    require '../ip/ip.php';
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
    if ($fetch['ip'] != $user_ip) {
      header("location:../unset");
      exit();
    }
    $Player = $_COOKIE['tmpname'];
    $params = array("Command"  => "AccountsGet",
                  "Player"   => $Player,);
    $api = Poker_API($params);
    if(isset($api -> Level )){
        $level = $api -> Level;
        $balance = number_format($api -> Balance);
    }
    $level100 = $level*100; $width = $level100/30;
    ?>
    <style type="text/css">
        .ul-left {
            direction: ltr;
            text-align: left;
            color: #fff;
        }
        .ul-left strong {
            color: #fff
        }

    </style>
 <script src="../users/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    // body...
    $('#ShowNav').click(function() {
        // body...
        if( $('#navInXs').hasClass('navInXs_hide') ) {
            $('#navInXs').removeClass('navInXs_hide');
            $('#navInXs').addClass('showXsNav');
            $('#ShowNav').addClass('nav-is-visible');
            $('body').addClass('body-close');
        }
        else{
            $('#navInXs').removeClass('showXsNav');
            $('#navInXs').addClass('navInXs_hide');
            $('#ShowNav').removeClass('nav-is-visible');
            $('body').removeClass('body-close');
        }

    })



})
</script>
</head>




<body >
    <div class="">
        <nav class="mynav row " role="navigation" >
         <div class="col-xs-12">
             <div class="col-sm-4">
                <div class="logo">
                    <a href="#" class=""><img src="../img/tumbl.png" alt="logo" width="200" height="" ></a>
                </div>
            </div>
            <button type="button" id="ShowNav" class="navbar-toggle cd-nav-trigger" >
                <span  ></span>
            </button>
            <div class="col-sm-6 user-level hidden-xs">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="../img/avatar.png" class="pull-right avatar" width="60" height="60" alt="user Avatar" />
                    </div>
                    <div id="curly-brace">
                        <div id="left" class="brace"></div>
                        <div id="right" class="brace"></div>
                    </div>
                    <div class="col-sm-8">
                        <ul>
                            <li><small>User : </small>
                                <strong>
                                <?php
                                    $who = $_COOKIE['tmpname'];
                                    $sql="select * from tmpuser where username=:user;";
                                    $result=$connect->prepare($sql);
                                    $result->bindvalue(":user",$who);
                                    $result->execute();
                                    $fetch=$result->fetch(PDO::FETCH_ASSOC);
                                    echo $fetch['fullname'];
                                ?>
                                </strong>
                            </li>
                            <li>
                                <small>Level :</small>
                                <strong> <?= $level ?>
                                    <div class="level-progress">
                                        <div class = "progress progress-striped active" >
                                            <div class = "progress-bar progress-bar-success" role = "progressbar" aria-valuenow = "60" aria-valuemin = "0" aria-valuemax = "100" style = "width: <?=$width?>%"></div>
                                        </div>
                                    </div>
                                </strong>
                            </li>
                            <li>
                                <small>Balance :</small>
                                <strong> <?= $balance ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 hidden-xs">
                <a href="../unset" class="logout-link">
                    <img src="../img/logout3.png" width="70" alt="logout" /><br>
                    Logout
                </a>
            </div>
         </div>
        <div class="col-xs-12 no-padding navInXs_hide" id="navInXs">
            <div class="navbar-default sidebar " >
                <a href="../unset" class="logout-link in-xs hidden-sm hidden-md hidden-lg">
                    <img src="../img/logout3.png" width="70" alt="logout" /><br>
                    Logout
                </a>
                <div class="sidebar-nav navbar-collapse " >
                    <ul class="nav" id="">


                        <li>
                            <a href="../" data-toggle = "tooltip" data-placement = "bottom" title = " Home "><i class="fa fa-home fa-fw"></i> صفحه اصلی</a>
                        </li>
                        <li class="dropdown ">
                            <a class="dropdown-toggle" class="active" data-toggle="dropdown" href="#" aria-expanded="true">
                                <i class="fa fa-gamepad fa-fw"></i> ورود به بازی
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                
                                <li>
                                    <a href="../game/?login=login"  data-toggle = "tooltip" data-placement = "right" title = " Login to the Poker">میخوام پوکر بازی کنم <i class="fa fa-arrow-left pull-left"></i></a>

                                </li>
                                <li>
                                    <a href="../backgammon"  data-toggle = "tooltip" data-placement = "right" title = " Login to the backgammon">میخوام تخته نرد بازی کنم  <i class="fa fa-arrow-left pull-left"></i></a>

                                </li>

                            </ul>
                            <!-- /.dropdown-messages -->
                        </li>
                        <li>
                            <a href="../account" data-toggle = "tooltip" data-placement = "bottom" title = "Deposit"><i class="fa fa-table fa-fw"></i> خرید چیپ </a>
                        </li>
                        <li>
                            <a href="../money" data-toggle = "tooltip" data-placement = "bottom" title = " Cash out "><i class="fa fa-credit-card fa-fw"></i> برداشت وجه</a>

                        </li>
                        <li>
                            <a href="../makemoney" data-toggle = "tooltip" data-placement = "bottom" title = "Make Money"><i class="fa fa-gift fa-fw"></i> کسب درآمد </a>
                        </li>
                        <li>
                            <a href="../help"  data-toggle = "tooltip" data-placement = "bottom" title = "Game instructions"><i class="fa fa-life-ring fa-fw"></i> آموزش </a>
                        </li>
                        <li>
                            <a href="../settings" data-toggle = "tooltip" data-placement = "bottom" title = "Setting"><i class="fa fa-wrench fa-fw"></i>تنظیمات</a>
                        </li>
                        
                        <li>
                            <a href="../contactus" data-toggle = "tooltip" data-placement = "bottom" title = "Suport"><i class="fa fa-phone fa-fw"></i> پشتیبانی</a>
                        </li>
                        

                    </ul>

                </div>
                <!-- /.sidebar-collapse -->
            </div>
        </div>
    </nav>

<?php

  $server = $urlgame;

  if (isset($_GET["login"]))
  {
    $player = $_COOKIE['tmpname'];
    $password = $_COOKIE['tmppass'];
    $params = array("Command" => "AccountsPassword", "Player" => $player, "PW" => $password);
    $api = Poker_API($params);
    if ($api -> Result != "Ok") die($api -> Error . "<br/>" . "Click Back Button to retry.");
    if ($api -> Verified != "Yes") die("Password is incorrect. Click Back Button to retry.");
    $params = array("Command" => "AccountsSessionKey", "Player" => $player);
    $api = Poker_API($params);
    if ($api -> Result != "Ok") die($api -> Error . "<br/>" . "Click Back Button to retry.");
    $key = $api -> SessionKey;
    $src = $server . "/?LoginName=" . $player . "&amp;SessionKey=" . $key;
    echo "<div><iframe style='display:block;width:100%; height:900px;object-fit: cover;' src='$src'></iframe></div>\r\n</body>\r\n</html>";
    exit;
  }
?>

</body>
</html>
