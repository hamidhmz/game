<?php
if (!isset($_COOKIE['tmpname'])) {
    header("location:login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


<link rel="shortcut icon" type="image/x-icon" href="img/logo.png" />

    <title>پنل کاربری | پوکر آنلاین </title>

    <!-- Bootstrap Core CSS -->
    <link href="users/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="users/dist/css/jquery.bxslider.css" rel="stylesheet"> -->
    <!-- MetisMenu CSS -->
    <link href="users/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="users/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="users/vendor/morrisjs/morris.css" rel="stylesheet">

    <link href="css/responsive.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="users/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script src="users/vendor/jquery/jquery.min.js"></script>

    <script src="slider/sliderengine/amazingslider.js"></script>
    <link rel="stylesheet" type="text/css" href="slider/sliderengine/amazingslider-1.css">
    <script src="slider/sliderengine/initslider-1.js"></script>
   <!--  <script src="users/dist/js/jquery.bxslider.js"></script>
     <script type="text/javascript">
             $(document).ready(function(){
              $('.bxslider').bxSlider();
            });
     </script> -->

    <?php
	
require "users/api/API.php";

include "db/db.php";
require "notif/notif.php";

require "ip/ip.php";
$who = $_COOKIE['tmpname'];
$sql = "select * from tmpuser where username=:user;";
$result = $connect->prepare($sql);
$result->bindvalue(":user", $who);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
if ($fetch['active'] == 0) {
    header("location:unset");
    exit();
}
if ($fetch['ip'] != $user_ip) {
    header("location:unset");
    exit();
}
$Player = $_COOKIE['tmpname'];
$params = array("Command" => "AccountsGet",
    "Player" => $Player);
$api = Poker_API($params);
if (isset($api->Level)) {
    $level = $api->Level;
    $balance = number_format($api->Balance);
}else{
	header('location:backgammon/site/logout');
	exit;
}
$level100 = $level * 100;
$width = $level100 / 30;
?>
</head>

<body >
    <div class="">
        <nav class="mynav row " role="navigation" >
         <div class="col-xs-12">
             <div class="col-sm-4">
                <div class="logo">
                    <a href="#" class=""><img src="img/tumbl.png" alt="logo" width="200" height="" ></a>
                </div>
            </div>
            <button type="button" id="ShowNav" class="navbar-toggle cd-nav-trigger" >
                <span  ></span>
            </button>
            <div class="col-sm-6 user-level hidden-xs">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="img/avatar.png" class="pull-right avatar" width="60" height="60" alt="user Avatar" />
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
                                $sql = "select * from tmpuser where username=:user;";
                                $result = $connect->prepare($sql);
                                $result->bindvalue(":user", $who);
                                $result->execute();
                                $fetch = $result->fetch(PDO::FETCH_ASSOC);
                                echo $fetch['username'];
                                ?>
                                </strong>
                            </li>
                            <li>
                                <small>Level :</small>
                                <strong> <?=$level?>
                                    <div class="level-progress">
                                        <div class = "progress progress-striped active" >
                                            <div class = "progress-bar progress-bar-success" role = "progressbar" aria-valuenow = "60" aria-valuemin = "0" aria-valuemax = "100" style = "width: <?=$width?>%"></div>
                                        </div>
                                    </div>
                                </strong>
                            </li>
                            <li>
                                <small>Balance :</small>
                                <strong> <?=$balance?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 hidden-xs">
                <a href="unset" class="logout-link">
                    <img src="img/logout3.png" width="70" alt="logout" /><br>
                    Logout
                </a>
            </div>
         </div>
        <div class="col-xs-12 no-padding navInXs_hide" id="navInXs">
            <div class="navbar-default sidebar " >
                <a href="unset" class="logout-link in-xs hidden-sm hidden-md hidden-lg">
                    <img src="img/logout3.png" width="70" alt="logout" /><br>
                    Logout
                </a>
                <div class="sidebar-nav " >
                    <ul class="nav" id="">


                        <li>
                            <a href=""  class="active" data-toggle = "tooltip" data-placement = "bottom" title = " Home "><i class="fa fa-home fa-fw"></i> صفحه اصلی</a>
                        </li>
                        <li class="dropdown ">
                            <a class="dropdown-toggle" class="active" data-toggle="dropdown" href="#" aria-expanded="true">
                                <i class="fa fa-gamepad fa-fw"></i> ورود به بازی
                            </a>
                            <ul class="dropdown-menu dropdown-messages">

                                <li>
                                    <a href="game/?login=login"  data-toggle = "tooltip" data-placement = "right" title = " Login to the Poker">میخوام پوکر بازی کنم <i class="fa fa-arrow-left pull-left"></i></a>

                                </li>
                                <li>
                                    <a href="backgammon"  data-toggle = "tooltip" data-placement = "right" title = " Login to the backgammon">میخوام تخته نرد بازی کنم  <i class="fa fa-arrow-left pull-left"></i></a>

                                </li>

                            </ul>
                            <!-- /.dropdown-messages -->
                        </li>
                        <li>
                            <a href="account" data-toggle = "tooltip" data-placement = "bottom" title = "Deposit"><i class="fa fa-table fa-fw"></i> خرید چیپ </a>
                        </li>
                        <li>
                            <a href="money" data-toggle = "tooltip" data-placement = "bottom" title = " Cash out "><i class="fa fa-credit-card fa-fw"></i> برداشت وجه</a>

                        </li>
                        <li>
                            <a href="makemoney" data-toggle = "tooltip" data-placement = "bottom" title = "Make Money"><i class="fa fa-gift fa-fw"></i> کسب درآمد </a>
                        </li>
                        <li>
                            <a href="help"  data-toggle = "tooltip" data-placement = "bottom" title = "Game instructions"><i class="fa fa-life-ring fa-fw"></i> آموزش </a>
                        </li>
                        <li>
                            <a href="settings" data-toggle = "tooltip" data-placement = "bottom" title = "Setting"><i class="fa fa-wrench fa-fw"></i>تنظیمات</a>
                        </li>

                        <li>
                            <a href="contactus" data-toggle = "tooltip" data-placement = "bottom" title = "Suport"><i class="fa fa-phone fa-fw"></i> پشتیبانی</a>
                        </li>


                    </ul>

                </div>
                <!-- /.sidebar-collapse -->
            </div>
        </div>
    </nav>
    <div id="wrapper" >


        <?php
$sql1 = "select * from topic where id=7;";
$result1 = $connect->prepare($sql1);
$result1->execute();
$fetch1 = $result1->fetch(PDO::FETCH_ASSOC);
$pic = $fetch1['pic'];
?>

        <div class="top-bar">
             <div class="my-slider">
                <!-- Loading Screen -->
                <?php
$sql = "select * from topic where id=11;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$spic1 = $fetch['pic'];
?>
                <?php
$sql = "select * from topic where id=12 ;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$spic2 = $fetch['pic'];
?>
                <?php
$sql = "select * from topic where id=13 ;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$spic3 = $fetch['pic'];
?>
                <?php
$sql = "select * from topic where id=14 ;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$spic4 = $fetch['pic'];
?>
                <?php
$sql = "select * from topic where id=3 ;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$pic1 = $fetch['pic'];
?>
                <?php
$sql = "select * from topic where id=5 ;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$pic2 = $fetch['pic'];
?>
                <?php
$sql = "select * from topic where id=9 ;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$pic3 = $fetch['pic'];
?>
                <?php
$sql = "select * from topic where id=7 ;";
$result = $connect->prepare($sql);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$pic4 = $fetch['pic'];
?>
                <!-- Slides Container -->

               <!--  <ul class="bxslider">
                  <li><img src="img/slider/<?=$spic1;?>" alt="slider" /></li>
                  <li><img src="img/slider/<?=$spic2;?>"  alt="slider" /></li>
                  <li><img  src="img/slider/<?=$spic3;?>" alt="slider"  /></li>
                  <li><img  src="img/slider/<?=$spic4;?>" alt="slider"  /></li>
                </ul> -->
                <!-- Insert to your webpage where you want to display the slider -->
                <div id="amazingslider-wrapper-1" style="display:block;position:relative;max-width:100%;margin:0 auto;">
                    <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
                        <ul class="amazingslider-slides" style="display:none;">
                            <li><img src="img/slider/<?=$spic1;?>" />
                            </li>
                            <li><img src="img/slider/<?=$spic2;?>" />
                            </li>
                            <li><img src="img/slider/<?=$spic3;?>" />
                            </li>
                            <li><img src="img/slider/<?=$spic4;?>" />
                            </li>
                        </ul>

                    </div>
                </div>
                <!-- End of body section HTML codes -->


            </div>
            <div class="slider-link">

                <div class="row hidden-xs hidden-sm">
                    <div class="panel " style="margin-bottom: 0">
                        <div class="panel-body">
                            <div class="col-xs-12 pull-right">
                                <div class="col-sm-4">
                                    <div class="panel  ">
                                        <div class="panel-heading panel-my">

                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-money fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">
                                                        <?php
$Player = $_COOKIE['tmpname'];
$params = array("Command" => "AccountsGet",
    "Player" => $who);
$api = Poker_API($params);
echo $balance = number_format($api->Balance);
?>
                                                    </div>
                                                    <div class="rtl neon-text">your balance</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel ">
                                        <div class="panel-heading panel-my">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">
                                                        <?php

$who = $_COOKIE['tmpname'];
$sql = "select * from tmpuser where username=:user;";
$result = $connect->prepare($sql);
$result->bindvalue(":user", $who);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$id = $fetch['id'];
if (isset($fetch['prake'])) {
    echo number_format($fetch['prake']);
}
?>
                                                    </div>
                                                    <div class="rtl neon-text">Rake</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="panel ">
                                        <div class="panel-heading panel-my">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-support fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">
                                                        <?php
$Player = $_COOKIE['tmpname'];
$params = array("Command" => "AccountsGet",
    "Player" => $Player);
$api = Poker_API($params);
if (isset($api->Level)) {
    echo $api->Level;
} else {
    echo "0";
}
?>
                                                    </div>
                                                    <div class="rtl neon-text">Level</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    <div class="">
        <div style="position: relative; margin-top: 20px;" class="hidden-md hidden-lg">
            <a href="game/?login=login" class="btn btn-lg btn-success game-btn" >
              ورود به بازی
           </a>
        </div>
        <div class="row hidden-md hidden-lg">
            <div class="panel " style="margin-bottom: 0">
                <div class="panel-body">
                    <div class="col-xs-12 pull-right">
                        <div class="col-sm-4">
                            <div class="panel  bg1">
                                <div class="panel-heading panel-my">

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-money fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">
                                                <?php
$who = $_COOKIE['tmpname'];
$sql = "select * from tmpuser where username=:user;";
$result = $connect->prepare($sql);
$result->bindvalue(":user", $who);
$result->execute();
if (isset($fetch['active'])) {
    if ($fetch['active'] == '1') {
        $Player = $_COOKIE['tmpname'];
        $params = array("Command" => "AccountsGet",
            "Player" => $Player);
        $api = Poker_API($params);
        //echo number_format($api -> Balance);
        echo $balance;
    } else {
        echo "0";
    }
}
?>
                                            </div>
                                            <div class="rtl neon-text">your balance</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="panel bg2">
                                <div class="panel-heading panel-my">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-shopping-cart fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">
                                                <?php

$who = $_COOKIE['tmpname'];
$sql = "select * from tmpuser where username=:user;";
$result = $connect->prepare($sql);
$result->bindvalue(":user", $who);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
$id = $fetch['id'];
if (isset($fetch['prake'])) {
    echo number_format($fetch['prake']);
}
?>
                                            </div>
                                            <div class="rtl neon-text">Rake</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="panel bg3">
                                <div class="panel-heading panel-my">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-support fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">
                                                <?php
$Player = $_COOKIE['tmpname'];
$params = array("Command" => "AccountsGet",
    "Player" => $Player);
$api = Poker_API($params);
if (isset($api->Level)) {
    echo $api->Level;
} else {
    echo "0";
}
?>

                                            </div>
                                            <div class="rtl neon-text">Level</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="page-wrapper"  style="margin: 0">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <h1 class="page-header">داشبورد</h1> -->
                </div>
                <!-- /.col-lg-12 -->

            </div>
            <!-- /.row -->
            <?php
$who = $_COOKIE['tmpname'];
$sql = "select * from tmpuser where username=:user;";
$result = $connect->prepare($sql);
$result->bindvalue(":user", $who);
$result->execute();
$fetch = $result->fetch(PDO::FETCH_ASSOC);
if ($fetch['active'] != '1') {
    echo "<div class='alert alert-danger alert-dismissable rtl'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            کاربر گرامی اطلاعات حساب شما کامل نیست لطفا قبل از وارد  شدن به بازی ابتدا اطلاعات خود را تکمیل نمایید . <a href='settings/''>تکمیل اطلاعات</a>
                        </div> ";
}
?>


            <!-- /.row -->
           <div class="row">
               <div class="panel ">
                    <div class="panel-body" style="width: 100%">
                        <a href="#" class="col-sm-3 boxed no-padding">
                            <img src="img/<?=$pic1;?>" class="img-responsive img-boxed" alt="poker"><br>
                            <span>Poker</span>
                        </a>
                        <a href="#" class="col-sm-3 boxed no-padding">
                            <img src="img/<?=$pic2;?>" class="img-responsive img-boxed" alt="poker"><br>
                            <span>Backgommon</span>
                        </a>
                        <a href="#" class="col-sm-3 boxed no-padding">
                            <img src="img/<?=$pic3;?>" class="img-responsive img-boxed" alt="poker"><br>
                            <span>Poker</span>
                        </a>
                        <a href="#" class="col-sm-3 boxed no-padding">
                            <img src="img/<?=$pic4;?>" class="img-responsive img-boxed" alt="poker"><br>
                            <span>Backgommon</span>
                        </a>
                    </div>
                </div>
           </div>
           <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                         <div class="panel-heading rtl">
                            جوایز
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="margin: 50px 0">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-primary">
                         <div class="panel-heading rtl">
                            بازیکنان برتر
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="margin: 20px 0">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>Name</th>
                                        <th>location</th>
                                        <th>rake</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    </div>
    <!-- /#wrapper -->
<footer class="footer">
    <div class="center-box text-center" style="color: #fff">
        @copy 2017 <a href="http://ggpot.com">ggpot.com</a>
        <ul class="pull-right">
            <?php
$sql = "select * from social ";
$result = $connect->prepare($sql);
$result->execute();
while ($fetch = $result->fetch(PDO::FETCH_ASSOC)) {
    ?>
                <li class="pull-right"><a href="<?=$fetch['instagram'];?>" class=""><i class="fa fa-instagram fa-2x purper"></i></a></li>
                <li class="pull-right" style="margin-right: 10px"><a href="<?=$fetch['telegram']?>" class=""><i class="fa fa-telegram fa-2x blue"></i></a></li>
            <?php
}
?>
        </ul>
    </div>

</footer>
    </div>
    <!-- jQuery -->


    <!-- Bootstrap Core JavaScript -->
    <script src="users/vendor/bootstrap/js/bootstrap.min.js"></script>

    <script>
   $(function () { $("[data-toggle = 'tooltip']").tooltip(); });
</script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="users/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="users/vendor/raphael/raphael.min.js"></script>
    <script src="users/vendor/morrisjs/morris.min.js"></script>
    <script src="users/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="users/dist/js/sb-admin-2.js"></script>

    <!-- jssor slider scripts-->

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
</body>

</html>
