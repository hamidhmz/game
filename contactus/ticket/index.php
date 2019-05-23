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
    <link href="../../users/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../users/dist/css/jquery.bxslider.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../users/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../users/dist/css/sb-admin-2.css" rel="stylesheet">

    

    <!-- Morris Charts CSS -->
    <link href="../../users/vendor/morrisjs/morris.css" rel="stylesheet">

      <link href="../../css/responsive.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../users/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="../../users/vendor/jquery/jquery.min.js"></script>

    <script src="../../slider/sliderengine/amazingslider.js"></script>
    <link rel="stylesheet" type="text/css" href="../../slider/sliderengine/amazingslider-1.css">
    <script src="../../slider/sliderengine/initslider-1.js"></script>

    <!-- <script src="../../users/dist/js/jquery.bxslider.js"></script>
     <script type="text/javascript">
         $(document).ready(function(){
              $('.bxslider').bxSlider();
            });
     </script> -->

    <?php
    require "../../db/db.php";
    require "../../notif/notif.php";
    require "../../users/api/API.php";
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
</head>

<body >
    <div class="">
        <nav class="mynav row " role="navigation" >
         <div class="col-xs-12">
             <div class="col-sm-4">
                <div class="logo">
                    <a href="#" class=""><img src="../../img/tumbl.png" alt="logo" width="200" height="" ></a>
                </div>
            </div>
            <button type="button" id="ShowNav" class="navbar-toggle cd-nav-trigger" >
                <span  ></span>
            </button>
            <div class="col-sm-6 user-level hidden-xs">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="../../img/avatar.png" class="pull-right avatar" width="60" height="60" alt="user Avatar" />
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
                <a href="../../unset" class="logout-link">
                    <img src="../../img/logout3.png" width="70" alt="logout" /><br>
                    Logout
                </a>
            </div>
         </div>
        <div class="col-xs-12 no-padding navInXs_hide" id="navInXs">
            <div class="navbar-default sidebar " >
                <a href="../../unset" class="logout-link in-xs hidden-sm hidden-md hidden-lg">
                    <img src="../../img/logout3.png" width="70" alt="logout" /><br>
                    Logout
                </a>
                <div class="sidebar-nav navbar-collapse " >
                    <ul class="nav" id="">


                        <li>
                            <a href="../../" data-toggle = "tooltip" data-placement = "bottom" title = " Home "><i class="fa fa-home fa-fw"></i> صفحه اصلی</a>
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
                            <a href="../../account" data-toggle = "tooltip" data-placement = "bottom" title = "Deposit"><i class="fa fa-table fa-fw"></i> خرید چیپ </a>
                        </li>
                        <li>
                            <a href="../../money" data-toggle = "tooltip" data-placement = "bottom" title = " Cash out "><i class="fa fa-credit-card fa-fw"></i> برداشت وجه</a>

                        </li>
                        <li>
                            <a href="../../makemoney" data-toggle = "tooltip" data-placement = "bottom" title = "Make Money"><i class="fa fa-gift fa-fw"></i> کسب درآمد </a>
                        </li>
                        <li>
                            <a href="../../help"  data-toggle = "tooltip" data-placement = "bottom" title = "Game instructions"><i class="fa fa-life-ring fa-fw"></i> آموزش </a>
                        </li>
                        <li>
                            <a href="../../settings" data-toggle = "tooltip" data-placement = "bottom" title = "Setting"><i class="fa fa-wrench fa-fw"></i>تنظیمات</a>
                        </li>
                        
                        <li>
                            <a href="../../contactus" class="active" data-toggle = "tooltip" data-placement = "bottom" title = "Suport"><i class="fa fa-phone fa-fw"></i> پشتیبانی</a>
                        </li>
                        

                    </ul>

                   
                </div>
                <!-- /.sidebar-collapse -->
            </div>
        </div>
    </nav>
    <div id="wrapper" >
        

        <?php
            $sql1="select * from topic where id=7;";
            $result1=$connect->prepare($sql1);
            $result1->execute();
            $fetch1=$result1->fetch(PDO::FETCH_ASSOC);
            $pic = $fetch1['pic'];
            ?>

        <div class="top-bar">
             <div >
                <!-- Loading Screen -->
                <?php
                $sql="select * from topic where id=11;";
                $result=$connect->prepare($sql);
                $result->execute();
                $fetch=$result->fetch(PDO::FETCH_ASSOC);
                $spic1 = $fetch['pic'];
                ?>
                <?php
                $sql="select * from topic where id=12 ;";
                $result=$connect->prepare($sql);
                $result->execute();
                $fetch=$result->fetch(PDO::FETCH_ASSOC);
                $spic2 = $fetch['pic'];
                ?>
                <?php
                $sql="select * from topic where id=13 ;";
                $result=$connect->prepare($sql);
                $result->execute();
                $fetch=$result->fetch(PDO::FETCH_ASSOC);
                $spic3 = $fetch['pic'];
                ?>
                <?php
                $sql="select * from topic where id=14 ;";
                $result=$connect->prepare($sql);
                $result->execute();
                $fetch=$result->fetch(PDO::FETCH_ASSOC);
                $spic4 = $fetch['pic'];
                ?>
                <!-- Slides Container -->
                <!-- <ul class="bxslider">
                  <li><img src="../../img/slider/<?= $spic1; ?>" alt="slider" /></li>
                  <li><img src="../../img/slider/<?= $spic2; ?>"  alt="slider" /></li>
                  <li><img  src="../../img/slider/<?= $spic3; ?>" alt="slider"  /></li>
                  <li><img  src="../../img/slider/<?= $spic4; ?>" alt="slider"  /></li>
                </ul> -->
                <!-- Insert to your webpage where you want to display the slider -->
                <div id="amazingslider-wrapper-1" style="display:block;position:relative;max-width:100%;margin:0 auto;">
                    <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
                        <ul class="amazingslider-slides" style="display:none;">
                            <li><img src="../../img/slider/<?= $spic1; ?>" />
                            </li>
                            <li><img src="../../img/slider/<?= $spic2; ?>" />
                            </li>
                            <li><img src="../../img/slider/<?= $spic3; ?>" />
                            </li>
                            <li><img src="../../img/slider/<?= $spic4; ?>" />
                            </li>
                        </ul>
                       
                    </div>
                </div>
                <!-- End of body section HTML codes -->

                
            </div>
            <div class="slider-link">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="" class="box">
                            <div class="box-content red row">
                                <div class="img-box pull-left">
                                    <img src="../../img/slider-icon/claim.png" alt="slider-icon " class="img-responsive" />
                                </div>
                                <div class="text-box pull-left">
                                    <p>سطح خود را بالا ببرید و جایزه بگیرید </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="" class="box">
                            <div class="box-content black row">
                                <div class="img-box pull-left">
                                    <img src="../../img/slider-icon/create.png" alt="slider-icon " class="img-responsive" />
                                </div>
                                <div class="text-box pull-left">
                                    <p>دوستان خود را دعوت کنید و 30% پاداش بگیرید </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>


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
                        <div class=" rtl">
                            <div class="navbar-default in-xs sidebar" role="navigation">
                                <div class="sidebar-nav navbar-collapse">
                                    <ul class="nav" id="">
                                        
                                        <li>
                                            <a href="../"  data-toggle = "tooltip" data-placement = "bottom" title = " info"><i class="fa fa-phone fa-fw"></i>  تماس با ما </a>
                                           
                                        </li>
                                        <li>
                                            <a href="ticket/" class="active"  data-toggle = "tooltip" data-placement = "bottom" title = " Rack Back "><i class="fa fa-send-o fa-fw"></i>  ارسال تیکت </a>
                                           
                                        </li>
                                        
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card ">
                                <div class="card-content black text-center">
                                    <div class="row post" id="content">
                                       
                                    </div>
                                </div>
                                <div class="card-action text-center">
                                    <div class="row">
                                        <div class="input-field col-xs-12">
                                            <!-- <label for="textarea1" class="col-sm-4">متن خود را وارد نمایید</label> -->
                                            <textarea  id="textarea1" class="materialize-textarea " placeholder="متن خود را وارد نمایید"></textarea>
                                        </div>
                                        <a id="save1"  class="btn btn-success btn-lg"><i class="fa fa-send-o"></i> ارسال </a>
                                    </div>
                                    <div id="txt1"></div>
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
    

    <!-- Bootstrap Core JavaScript -->
    <script src="../../users/vendor/bootstrap/js/bootstrap.min.js"></script>
 <script>
   $(function () { $("[data-toggle = 'tooltip']").tooltip(); });
</script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../users/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../users/vendor/raphael/raphael.min.js"></script>
    <script src="../../users/vendor/morrisjs/morris.min.js"></script>
    <script src="../../users/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../users/dist/js/sb-admin-2.js"></script>

    
    <script type="text/javascript" src="../../users/dist/js/jssor.slider.min.js"></script>
    <script>

        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: 1,                                       //[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $Idle: 3000,                                        //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: 1,                         //[Optional] Steps to go for each navigation request by pressing arrow key, default value is 1.
                $SlideEasing: $Jease$.$OutQuint,                    //[Optional] Specifies easing for right to left animation, default value is $Jease$.$OutQuad
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide, default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0,                                   //[Optional] Space between each slide in pixels, default value is 0
                $Cols: 1,                                           //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $Align: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 12,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    jssor_slider1.$ScaleWidth(parentWidth - 30);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#save1").click(function(){
            $("#txt1").html("<b><font color=black>اطلاعات در حال ارسال میباشد</font></b>");
            var btn1="save1";
            var caption = $("#textarea1").val();
            $.post("sentmsg.php",{btn1:btn1,caption:caption},function(data){$("#txt1").html(data);});
            });
            function showmsg()
            {
                $.post("index.tmp.php",function(data){
                    $('#content').html(data);
                });
            }
            setInterval(showmsg,1000);
        });
    </script>
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
