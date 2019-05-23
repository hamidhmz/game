<?php 
    if (!isset($_COOKIE['tmpname']))
    {
        header("location:../../../../");
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
<link rel="shortcut icon" type="image/x-icon" href="../../img/logo.png" />
    <title>پنل کاربری | پوکر آنلاین </title>

    <!-- Bootstrap Core CSS -->
    <link href="../../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../../../../js/datatable/css/jquery.dataTables.min.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
    require "../../../../../db/db.php";
    require "../../../../../notif/notif.php";
    require "../../../../api/API.php";
    ?>
</head>

<body>

    <div id="wrapper">

         <div class="top-bar hidden-xs hidden-sm" style="background: url(../../../img/main2.png) no-repeat ;">
                <div class="bg-cover">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="">
                                    <a href="#" class="hidden-xs hidden-sm"><img src="../../../img/tumbl.gif" alt="logo" width="350" height="100" style=""></a>
                                </div>
                               
                            </div>
                            <div class="col-sm-8">
                                <h1>جوایز ماهانه و هفتگی ما </h1>
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
                <a href="#" class="hidden-md hidden-lg"><img src="../../img/tumbl.gif" alt="logo" width="200" height="70" style=""></a>
                
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
                                            echo "'../../../vendor/images/users/";
                                            echo $fetch['pic'];
                                            echo "'";
                                        }
                                        else
                                        {
                                            $sql="select * from topic where id=1 ;";
                                            $result=$connect->prepare($sql);
                                            $result->execute();
                                            $fetch=$result->fetch(PDO::FETCH_ASSOC);
                                            echo "'../../img/";
                                            echo $fetch['pic'];
                                            echo "'";
                                        }
                                        
                                    ?>
                                 width="60" height="60" alt="user Avatar">
                            </div>
                            
                        </li>

                        <li>
                            <a href="../../../"  data-toggle = "tooltip" data-placement = "bottom" title = " Home "><i class="fa fa-home fa-fw"></i> <?php
                                    $who = $_COOKIE['tmpname'];
                                    $sql="select * from tmpuser where username=:user;";
                                    $result=$connect->prepare($sql);
                                    $result->bindvalue(":user",$who);
                                    $result->execute();
                                    $fetch=$result->fetch(PDO::FETCH_ASSOC);
                                    echo $fetch['fullname'];
                                ?>    </a>
                        </li>
                        <li>
                            <a href="../../../game/?login=login" data-toggle = "tooltip" data-placement = "bottom" title = " Login to the game"><i class="fa fa-gamepad fa-fw"></i> ورود به بازی</a>
                           
                        </li>
                        <li>
                            <a href="../../../money"  data-toggle = "tooltip" data-placement = "bottom" title = " Cash out "><i class="fa fa-credit-card fa-fw"></i> برداشت وجه</a>
                           
                        </li>
                        <li>
                            <a href="../../../account"  data-toggle = "tooltip" data-placement = "bottom" title = "Deposit"><i class="fa fa-table fa-fw"></i> خرید چیپ </a>
                        </li>
                        <li>
                            <a href="../../../settings" data-toggle = "tooltip" data-placement = "bottom" title = "Setting"><i class="fa fa-wrench fa-fw"></i>تنظیمات</a>
                        </li>
                        <li>
                            <a href="../../../other/gift" class="active" data-toggle = "tooltip" data-placement = "bottom" title = "Gifts"><i class="fa fa-gift fa-fw"></i> جوایز </a>
                        </li>
                        <li>
                            <a href="../../../other/invite" data-toggle = "tooltip" data-placement = "bottom" title = "Invite"><i class="fa fa-user-plus fa-fw"></i>دعوتنامه</a>
                        </li>
                        <li>
                            <a href="../../../other/contactus"  data-toggle = "tooltip" data-placement = "bottom" title = "Suport"><i class="fa fa-phone fa-fw"></i> پشتیبانی</a>
                        </li>
                        <li>
                            <a href="../../../other/help" data-toggle = "tooltip" data-placement = "bottom" title = "Game instructions"><i class="fa fa-life-ring fa-fw"></i> آموزش </a>
                        </li>
                        <li>
                            <a href="../../../../../unset" data-toggle = "tooltip" data-placement = "bottom" title = "Logout"><i class="fa fa-power-off fa-fw"></i> خروج</a>
                        </li>
                      
                    </ul>
                   
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        
        <div class="container">
        <div id="page-wrapper" style="margin-top: 50px">
             <div class="row">
                <div class="col-lg-12">
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>

           

             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class=" rtl">
                             <div class="navbar-default sidebar" role="navigation">
                                <div class="sidebar-nav navbar-collapse">
                                    <ul class="nav" id="">
                                        
                                        <li>
                                            <a href="../"  data-toggle = "tooltip" data-placement = "bottom" title = " info"><i class="fa fa-gift fa-fw"></i>  اطلاعات</a>
                                           
                                        </li>
                                        <li>
                                            <a href="../rackback/" class="active" data-toggle = "tooltip" data-placement = "bottom" title = " Rack Back "><i class="fa fa-money fa-fw"></i>  پورسات ها</a>
                                           
                                        </li>
                                        <li>
                                            <a href="../myplayers/"  data-toggle = "tooltip" data-placement = "bottom" title = "My Player"><i class="fa fa-table fa-fw"></i>  زیرمجموعه های من</a>
                                        </li>
                                        <li>
                                            <a href="../Invite/" data-toggle = "tooltip" data-placement = "bottom" title = "Invite"><i class="fa fa-send-o fa-fw"></i>  دعوت از دوستان </a>
                                        </li>
                                        <li>
                                            <a href="../Status/" data-toggle = "tooltip" data-placement = "bottom" title = "Invitations Status"><i class="fa fa-info fa-fw"></i>  وضعیت دعوتنامه ها</a>
                                        </li>
                                      
                                    </ul>
                                   
                                </div>
                                <!-- /.sidebar-collapse -->
                            </div>
                        </div>
                        <div class="row">
                       
                        <div class="" style="margin: 50px ">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading rtl">
                                            اطلاعات پورسانت شما از زیرمجموعه ها .
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="clearfix">
                                                        <div class="pull-right tableTools-container"></div>
                                                    </div>
                                                    <table id="dynamic-table" class="bordered striped responsive-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>نام کاربر</th>
                                                                <th>تاریخ</th>
                                                                <th>درصد</th>
                                                                <th>مبلغ(تومان)</th>
                                                                <th>وضعیت </th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>
                                                                    <span>ریری ببز</span>
                                                                </td>
                                                                <td>
                                                                    <span>10/4/96</span>
                                                                </td>
                                                                <td>
                                                                    <span>نام دارنده حساب</span>
                                                                </td>
                                                                <td>
                                                                    <span>65842356</span>
                                                                </td>
                                                                <td>
                                                                    <span class="label label-success">اظافه شده</span>
                                                                    <span class="label label-warning">در انتظار تایید</span>
                                                                    
                                                                </td>
                                                                
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>                            
                                            </div>
                                            <!-- /.row (nested) -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <!-- /.col-lg-12 -->
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
    <script src="../../../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../../../vendor/bootstrap/js/bootstrap.min.js"></script>
 <script>
   $(function () { $("[data-toggle = 'tooltip']").tooltip(); });
</script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../../../dist/js/sb-admin-2.js"></script>
     <script src="../../../../js/datatable/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            jQuery(function($) {
                //initiate dataTables plugin
                var myTable = 
                $('#dynamic-table')
                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                .DataTable( {
                    bAutoWidth: false,
                    "aoColumns": [
                      { "bSortable": false },
                      null, null,null, null,
                      { "bSortable": false }
                    ],
                    "aaSorting": [],
                    
                    
                    //"bProcessing": true,
                    //"bServerSide": true,
                    //"sAjaxSource": "http://127.0.0.1/table.php"   ,
            
                    //,
                    //"sScrollY": "200px",
                    //"bPaginate": false,
            
                    //"sScrollX": "100%",
                    //"sScrollXInner": "120%",
                    //"bScrollCollapse": true,
                    //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
                    //you may want to wrap the table inside a "div.dataTables_borderWrap" element
            
                    //"iDisplayLength": 50
            
            
                    select: {
                        style: 'multi'
                    }
                } );
            
                
                
                $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
                
                new $.fn.dataTable.Buttons( myTable, {
                    buttons: [
                      {
                        "extend": "colvis",
                        "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
                        "className": "btn btn-white btn-primary btn-bold",
                        columns: ':not(:first):not(:last)'
                      },
                      {
                        "extend": "copy",
                        "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                      },
                      {
                        "extend": "csv",
                        "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                      },
                      {
                        "extend": "excel",
                        "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                      },
                      {
                        "extend": "pdf",
                        "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                      },
                      {
                        "extend": "print",
                        "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
                        "className": "btn btn-white btn-primary btn-bold",
                        autoPrint: false,
                        message: 'This print was produced using the Print button for DataTables'
                      }       
                    ]
                } );
                myTable.buttons().container().appendTo( $('.tableTools-container') );
                
                //style the message box
                var defaultCopyAction = myTable.button(1).action();
                myTable.button(1).action(function (e, dt, button, config) {
                    defaultCopyAction(e, dt, button, config);
                    $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
                });
                
                
                var defaultColvisAction = myTable.button(0).action();
                myTable.button(0).action(function (e, dt, button, config) {
                    
                    defaultColvisAction(e, dt, button, config);
                    
                    
                    if($('.dt-button-collection > .dropdown-menu').length == 0) {
                        $('.dt-button-collection')
                        .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                        .find('a').attr('href', '#').wrap("<li />")
                    }
                    $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
                });
            
                ////
            
                setTimeout(function() {
                    $($('.tableTools-container')).find('a.dt-button').each(function() {
                        var div = $(this).find(' > div').first();
                        if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
                        else $(this).tooltip({container: 'body', title: $(this).text()});
                    });
                }, 500);
                
            
            
            })
        </script>
</body>

</html>
