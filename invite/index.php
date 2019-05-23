<?php
    if (!isset($_COOKIE['tmpname']))
    {
        header("location:../");
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
<link rel="shortcut icon" type="image/x-icon" href="../img/logo.png" />
    <title>پنل کاربری | پوکر آنلاین </title>

    <!-- Bootstrap Core CSS -->
    <link href="../users/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../users/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../users/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../users/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../users/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
    require "../db/db.php";
    require '../ip/ip.php';
    require "../notif/notif.php";
    require "../users/api/API.php";
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
    ?>
</head>

<body>

    <div id="wrapper">

        <div class="top-bar hidden-xs hidden-sm" style="background: url(../img/d3.gif) no-repeat ;">
                <div class="bg-cover">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="">
                                    <a href="#" class="hidden-xs hidden-sm"><img src="../img/tumbl.gif" alt="logo" width="350" height="100" style=""></a>
                                </div>

                            </div>
                            <div class="col-sm-8">
                                <h1 style="font-size: 25px">زیر مجموعه های شما ---> دوستانی که شما دعوت کرده اید: </h1>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        <!-- Navigation -->
        <nav class="navbar  navbar-static-top container" role="navigation" style="margin-bottom: 0;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">منو</span>
                    <span class="fa fa-bars"></span>

                </button>
                <a href="#" class="hidden-md hidden-lg"><img src="../img/tumbl.gif" alt="logo" width="200" height="70" style=""></a>

            </div>
            <!-- /.navbar-header -->

            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                   <ul class="nav" id="">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <img src=
                                    <?php
                                        $who = $_COOKIE['tmpname'];
                                        $sql="select * from tmpuser where username=:user;";
                                        $result=$connect->prepare($sql);
                                        $result->bindvalue(":user",$who);
                                        $result->execute();
                                        $fetch=$result->fetch(PDO::FETCH_ASSOC);
                                        if ($fetch['pic'] != "")
                                        {
                                            echo "'../users/vendor/images/users/";
                                            echo $fetch['pic'];
                                            echo "'";
                                        }
                                        else
                                        {
                                            $sql="select * from topic where id=1 ;";
                                            $result=$connect->prepare($sql);
                                            $result->execute();
                                            $fetch=$result->fetch(PDO::FETCH_ASSOC);
                                            echo "'../img/";
                                            echo $fetch['pic'];
                                            echo "'";
                                        }

                                    ?>
                                 width="60" height="60" alt="user Avatar">
                            </div>

                        </li>

                        <li>
                            <a href="../"  data-toggle = "tooltip" data-placement = "bottom" title = " Home "><i class="fa fa-home fa-fw"></i> <?php
                                    $who = $_COOKIE['tmpname'];
                                    $sql="select * from tmpuser where username=:user;";
                                    $result=$connect->prepare($sql);
                                    $result->bindvalue(":user",$who);
                                    $result->execute();
                                    $fetch=$result->fetch(PDO::FETCH_ASSOC);
                                    echo $fetch['fullname'];
                                ?>    </a>
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
                            <a href="../money"  data-toggle = "tooltip" data-placement = "bottom" title = " Cash out "><i class="fa fa-credit-card fa-fw"></i> برداشت وجه</a>

                        </li>
                        <li>
                            <a href="../account"  data-toggle = "tooltip" data-placement = "bottom" title = "Deposit"><i class="fa fa-table fa-fw"></i> خرید چیپ </a>
                        </li>
                        <li>
                            <a href="../settings" data-toggle = "tooltip" data-placement = "bottom" title = "Setting"><i class="fa fa-wrench fa-fw"></i>تنظیمات</a>
                        </li>
                        <li>
                            <a href="../makemoney" class="active" data-toggle = "tooltip" data-placement = "bottom" title = "Make Money"><i class="fa fa-gift fa-fw"></i> کسب درآمد </a>
                        </li>
                        <li>
                            <a href="../invite" class="active" data-toggle = "tooltip" data-placement = "bottom" title = "Invite"><i class="fa fa-user-plus fa-fw"></i>دعوتنامه</a>
                        </li>
                        <li>
                            <a href="../contactus"  data-toggle = "tooltip" data-placement = "bottom" title = "Suport"><i class="fa fa-phone fa-fw"></i> پشتیبانی</a>
                        </li>
                        <li>
                            <a href="../help"  data-toggle = "tooltip" data-placement = "bottom" title = "Game instructions"><i class="fa fa-life-ring fa-fw"></i> آموزش </a>
                        </li>
                        <li>
                            <a href="../unset" data-toggle = "tooltip" data-placement = "bottom" title = "Logout"><i class="fa fa-power-off fa-fw"></i> خروج</a>
                        </li>

                    </ul>

                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
      <div class="container">
        <div id="page-wrapper" style="margin-top: 100px">
             <div class="row">
                <div class="col-lg-12">

                </div>
                <!-- /.col-lg-12 -->
            </div>



             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading rtl">
                            <h3>دعوت دوستان</h3>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 pull-right" style="margin: 10px auto">
                               <p class="rtl" style="padding: 20px 5px; font-size: 16px;line-height: 2;">
                                   دوستان خود را به بازی دعوت کنید و با بُرد و کسب امتیاز آنها شما هم درآمد داشته باشید .
                                   <br>
                                   شما میتوانید 5 نفر را دعوت کنید و به زیرمجموعه های خود اظافه نمایید .
                                   <br>
                                   برای دعوت ایمیل فرد مورد نظرتان را وارد کنید و ارسال را بزنید .
                               </p>
                                <div class="row">

                                   <form role="form" method="POST">
                                        <fieldset >
                                            <div class="form-group rtl">
                                                <label for="username">ایمیل </label>
                                                <input class="form-control" placeholder="ایمل را وارد کنید " name="Player" id="username" type="email" style="width: 65%" />
                                            </div>
                                            <div class=" rtl">
                                                <input type="submit" name="" class="btn btn-success " value="ارسال دعوت نامه ">
                                            </div>
                                        </fieldset>
                                    </form>
                               </div>

                            </div>
                            <div class="col-sm-6 pull-right" style="margin: 30px auto">
                                <div class="panel panel-default">
                                     <div class="panel-heading rtl">
                                        <h5>زیر مجموعه های شما</h5>
                                    </div>
                                    <table class="table table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام کاربر</th>
                                                <th>ایمیل</th>
                                                <th>پورسانت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tbody>
                                            <?php
                                                    $sql="select * from tmpuser where username=:user;";
                                                    $result=$connect->prepare($sql);
                                                    $result->bindvalue(":user",$who);
                                                    $result->execute();
                                                    $fetch=$result->fetch(PDO::FETCH_ASSOC);
                                                    $idd = $fetch['id'];
                                                    $precentage = $fetch['precentage'];
                                                    $sql1="select * from networking where id_user=:user;";
                                                    $result1=$connect->prepare($sql1);
                                                    $result1->bindvalue(":user",$idd);
                                                    $result1->execute();
                                                    $i = 0;
                                                    while($fetch1=$result1->fetch(PDO::FETCH_ASSOC)){ $i++; ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?php $sql2="select * from tmpuser where id=:user;";
                                                    $result2=$connect->prepare($sql2);
                                                    $result2->bindvalue(":user",$fetch1['id_netuser']);
                                                    $result2->execute();
                                                    $fetch2=$result2->fetch(PDO::FETCH_ASSOC); echo $fetch2['username']; ?></td>
                                                    <td><?= $fetch2['email'] ?></td>
                                                    <td><?php $sql3="select * from tmpaddmoney where id_user=:user;";
                                                    $result3=$connect->prepare($sql3);
                                                    $result3->bindvalue(":user",$fetch1['id_netuser']);
                                                    $result3->execute();
                                                    $add = 0;
                                                    while ($fetch3=$result3->fetch(PDO::FETCH_ASSOC)) {
                                                        $add += $fetch3['mount'];
                                                    } echo $precent = ($precentage / 100) * $add;
                                                     ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                $sql="select * from social ";
                $result=$connect->prepare($sql);
                $result->execute();
                while($fetch=$result->fetch(PDO::FETCH_ASSOC)){
                    ?>
                <li class="pull-right"><a href="<?= $fetch['instagram'];?>" class=""><i class="fa fa-instagram fa-2x purper"></i></a></li>
                <li class="pull-right" style="margin-right: 10px"><a href="<?= $fetch['telegram']?>" class=""><i class="fa fa-telegram fa-2x blue"></i></a></li>
            <?php
                }
            ?>
        </ul>
    </div>

</footer>
    <!-- jQuery -->
    <script src="../users/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../users/vendor/bootstrap/js/bootstrap.min.js"></script>
<script>
   $(function () { $("[data-toggle = 'tooltip']").tooltip(); });
</script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../users/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../users/dist/js/sb-admin-2.js"></script>

</body>

</html>
