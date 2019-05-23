<?php session_start();
if (!isset($_SESSION['tmpadminname']))
			{
			header("location:../login");
			exit();
			}
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>پنل مدیریت وب سایت </title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="../assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="../assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="../assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="../assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="../assets/js/ace-extra.min.js"></script>
		<script src="../assets/js/jquery-1.11.1.min.js"></script>
		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="../assets/js/html5shiv.min.js"></script>
		<script src="../assets/js/respond.min.js"></script>
		<![endif]-->
		<style type="text/css">
			table thead,table tbody {direction: rtl;}
			table thead th,table tbody td {direction: rtl;text-align: right;}
		</style>
		<?php

			require "../../db/db.php";
		    require "../../notif/notif.php";
		    require "../../users/api/API.php";

		    date_default_timezone_set('Asia/Tehran');


    		if (isset($_GET['get'])) {
    			$date = date("Y/n/d-g:i:s a");
				$add = 0;
				// iterate through list
				$sqlp6 = "SELECT * FROM tmpuser ";
				$resultp6 = $connect -> prepare($sqlp6);
				$resultp6 -> execute();
				while($fetchp6 = $resultp6 -> fetch(PDO::FETCH_ASSOC))
				{
					$Player = $fetchp6['username'];
					$params = array("Command"  => "AccountsGet",
				                    "Player"   => $Player,);
				    $api = Poker_API($params);
					$PRake = $api -> PRake;
					$add += $PRake;
					$sqlp = "SELECT * FROM tmpuser WHERE username=:username";
					$resultp = $connect -> prepare($sqlp);
					$resultp -> bindvalue(":username",$Player);
					$resultp -> execute();
					$fetchp = $resultp -> fetch(PDO::FETCH_ASSOC);
					$id_userp = $fetchp['id'];
					$sqlp1 = "SELECT * FROM networking WHERE id_netuser=:id_net";
					$resultp1 = $connect -> prepare($sqlp1);
					$resultp1 -> bindvalue("id_net",$id_userp);
					$resultp1 -> execute();
					$fetchp1 = $resultp1 -> fetch(PDO::FETCH_ASSOC);

					if (isset($fetchp1['id_user'])) {
						$id_userp1 = $fetchp1['id_user'];
						$sqlp2 = "SELECT * FROM tmpuser WHERE id=:id";
						$resultp2 = $connect -> prepare($sqlp2);
						$resultp2 -> bindvalue(":id",$id_userp1);
						$resultp2 -> execute();
						$fetchp2 = $resultp2 -> fetch(PDO::FETCH_ASSOC);
						$prakep2 = $fetchp2['prake'];echo "</br>";
						$userp2 = $fetchp2['username'];echo "</br>";
						$precentagep2 = $fetchp2['precentage'];
						$params = array("Command"  => "AccountsGet",
					                    "Player"   => $userp2,);
					    $api = Poker_API($params);
					    $Balances = $api -> Balance;echo "</br>";
					    $new_width = ($precentagep2/ 100) * $PRake;
					    $Balances += $new_width;echo "</br>";
					    $prakep2 += $new_width;echo "</br>";
					    $add -= $new_width;echo "</br>";
					    $params = array("Command"  => "AccountsEdit",
					                    "Player"   => $userp2,
					                    "Balance"  => $Balances,);
					    $api = Poker_API($params);
					    $params = array("Command"  => "AccountsEdit",
					                    "Player"   => $Player,
					                    "PRake"  => 0,);
					    $api = Poker_API($params);
					    $sqlp3 = "UPDATE `tmpuser` SET `prake`=:prake WHERE id=:id_userp1";
						$resultp3 = $connect -> prepare($sqlp3);
						$resultp3 -> bindvalue(":prake",$prakep2);
						$resultp3 -> bindvalue(":id_userp1",$id_userp1);
						$resultp3 -> execute();
					}
					$PRake += $fetchp['rake'];
					$sqlp3 = "UPDATE `tmpuser` SET `rake`=:rake WHERE username=:Player";
					$resultp3 = $connect -> prepare($sqlp3);
					$resultp3 -> bindvalue(":Player",$Player);
					$resultp3 -> bindvalue(":rake",$PRake);
					$resultp3 -> execute();
					require '../../levelup/process.php';
					$params = array("Command"  => "AccountsEdit",
			                    	"Player"   => $Player,
			                    	"PRake"    => '0',
			                    	"Level"    =>$level,
			                    	"Avatar"   =>$level);
			    	$api = Poker_API($params);
				}
				$sqlp5 = "SELECT * FROM lastsettle WHERE id=1";
				$resultp5 = $connect -> prepare($sqlp5);
				$resultp5 -> execute();
				$fetchp5 = $resultp5 -> fetch(PDO::FETCH_ASSOC);
				$admission = $fetchp5['admission'];
				$admission += $add;
				$sqlp4 = "UPDATE `lastsettle` SET `time`=:tisme,`admission`=:admission WHERE id=1";
				$resultp4 = $connect -> prepare($sqlp4);
				$resultp4 -> bindvalue(":tisme",$date);
				$resultp4 -> bindvalue(":admission",$admission);
				$resultp4 -> execute();
				$sqlp6 = "insert into dayli (day,week,month,year,time,`add`) values (:day,:week,:month,:year,:time,:add)";
				$resultp6 = $connect -> prepare($sqlp6);
				$resultp6 -> bindvalue(":day",date(d));
				$resultp6 -> bindvalue(":week",date(W));
				$resultp6 -> bindvalue(":month",date(m));
				$resultp6 -> bindvalue(":year",date(y));
				$resultp6 -> bindvalue(":time",$date);
				$resultp6 -> bindvalue(":add",$add);
				$neuon = $resultp6 -> execute();

				header("location:../networking");
    		}

		?>

	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">منو</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-right">
					<a href="../" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							پنل مدیریت
						</small>
					</a>
				</div>


			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>



				<ul class="nav nav-list">
					<li class="">
						<a href="../">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> داشبورد </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="../requestmoney">
							<i class="menu-icon fa fa-money"></i>
							<span class="menu-text">
								درخواست های برداشت
							</span>
							<span class="badge badge-success"></span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>

					<li class="">
						<a href="../depositmoney" >
							<i class="menu-icon fa fa-dollar"></i>
							<span class="menu-text">
								واریز به حساب
							</span>
							<span class="badge badge-primary"></span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>

					<!-- <li class="">
						<a href="Tournaments.html" >
							<i class="menu-icon fa fa-gamepad"></i>
							<span class="menu-text">
								تورنومنت ها
							</span>
							<span class="badge badge-warning">5</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li> -->
					<li class="">
						<a href="../contact" >
							<i class="menu-icon fa fa-phone"></i>
							<span class="menu-text">
								تماس ها
							</span>
							<span class="badge badge-danger"></span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="">
						<a href="../chat" >
							<i class="menu-icon fa fa-phone"></i>
							<span class="menu-text">
								تیکت ها
							</span>
							<span class="badge badge-danger"></span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="">
						<a href="../users" >
							<i class="menu-icon fa fa-user-o"></i>
							<span class="menu-text">
								کاربران
							</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="">
						<a href="../social" >
							<i class="menu-icon fa fa-flag"></i>
							<span class="menu-text">
								شبکه های اجتماعی
							</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="">
						<a href="../howtoplay" >
							<i class="menu-icon fa fa-flag"></i>
							<span class="menu-text">
								تغییر محتوای صفحه آموزش
							</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="">
						<a href="../rules" >
							<i class="menu-icon fa fa-flag"></i>
							<span class="menu-text">
								تغییر محتوای صفحه قوانین
							</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="">
						<a href="../pic" >
							<i class="menu-icon fa fa-flag"></i>
							<span class="menu-text">
								تغییر عکس صفحات پنل کاربر
							</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="active">
						<a href="../networking" >
							<i class="menu-icon fa fa-user-plus"></i>
							<span class="menu-text">
								کاربران بازاریاب
							</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>

					<li class="">
						<a href="../unset" >
							<i class="menu-icon fa fa-power-off"></i>
							<span class="menu-text">
								خروج
							</span>
						</a>
					</li>
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">کاربران </a>
							</li>

						</ul><!-- /.breadcrumb -->

						<!-- /.nav-search -->
					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								اعضا
								<small>
									<i class="ace-icon fa fa-angle-double-left"></i>
									نمایی کلی از جزییات کاربران بازاریاب
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="space-6"></div>


								<div class="row">
									<div class="col-sm-12">

										<div class="widget-box widget-color-green" id="">
											<div class="widget-header">
												<h4 class="widget-title lighter smaller">
													<i class="ace-icon fa fa-money blue"></i>گزارش تسویه حساب
												</h4>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
													<table class="table table-striped table-bordered table-hover">
														<thead>
															<th>تسویه</th>
															<th>تاریخ آخرین تسویه حساب</th>
															<th>کل درآمد سایت</th>
														</thead>
														<tbody>
															<td>
																<a href="../networking/?get=shel" class="btn btn-primary btn-lg ">تسویه حساب با کاربران </a>
															</td>
															<td>
																<?php
																	$a="SELECT l.time FROM lastsettle as l where id=1 ";
																    $result1=$connect->prepare($a);
																	$num=$result1->execute();
																	$fetch1=$result1->fetch(PDO::FETCH_ASSOC);
																	echo $fetch1['time'];
																?>
															</td>
															<td>
																<?php
																	$a="SELECT admission FROM lastsettle as l where id=1 ";
																    $result1=$connect->prepare($a);
																	$num=$result1->execute();
																	$fetch1=$result1->fetch(PDO::FETCH_ASSOC);
																	echo $fetch1['admission'];
																?>
															</td>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="hr hr32 hr-dotted"></div>


								<div class="row">
									<div class="col-sm-12">

										<div class="widget-box widget-color-pink" id="recent-box">
											<div class="widget-header">
												<h4 class="widget-title lighter smaller">
													<i class="ace-icon fa fa-user-o blue"></i>کل مشخصات اعضا
												</h4>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
													<div class=" padding-8">
														<div class="clearfix">
															<div class="pull-right tableTools-container"></div>
														</div>
														<table id="dynamic-table" class="table table-striped table-bordered table-hover">
															<thead>
																<tr>
																	<th class="center">
																		<label class="pos-rel">
																			<input type="checkbox" class="ace" />
																			<span class="lbl"></span>
																		</label>
																	</th>
																	<th>نام کاربری</th>
																	<th>تعداد زیرمجموعه</th>
																	<th>کل مبلغ واریزی توسط زیرمجموعه هاش</th>
																	<th>حد اکثر زیر مجموعه</th>
																	<th >درصد بازاریابی</th>
																	<th>لینک زیرمجموعه ها</th>
																	<th>مشاهده زیرمجموعه هاش</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	if (isset($_GET['id'])) {
																		$id = $_GET['id'];
																		$a="UPDATE `tmpuser` SET `networked` = 1 where id=:id";
														                $result=$connect->prepare($a);
																		$result->bindvalue(":id",$id);
														                $num=$result->execute();
																	}
																	$sql="select * from tmpuser  ";
																    $result=$connect->prepare($sql);
																	$num=$result->execute();
																    while($fetch=$result->fetch(PDO::FETCH_ASSOC))
																    {
																    	$id = $fetch['id'];
																?>
																<tr>
																	<td>
																		<label class="pos-rel">
																			<input type="checkbox" class="ace" />
																			<span class="lbl"></span>
																		</label>
																	</td>
																	<td>
																		<span id="username"><?= $fetch['username'] ?> </span>
																	</td>
																	<td>
																		<span><?php
																			$a="SELECT COUNT(id) as tid FROM networking where id_user=:id";
																		    $result1=$connect->prepare($a);
																			$result1->bindvalue(":id",$fetch['id']);
																			$num=$result1->execute();
																			$fetch1=$result1->fetch(PDO::FETCH_ASSOC);
																			echo $fetch1['tid'];
																		?></span>
																	</td>
																	<td>
																		<span>
																			<?php
																			$add = 0;
																			$sql2="select * from tmpaddmoney ";
																		    $result2=$connect->prepare($sql2);
																			$num=$result2->execute();
																		    while($fetch2=$result2->fetch(PDO::FETCH_ASSOC))
																		    {
																		    	$a1="SELECT * FROM tmpuser where networked=2 AND id=:id";
																			    $result3=$connect->prepare($a1);
																				$result3->bindvalue(":id",$fetch2['id']);
																				$num=$result3->execute();
																				$fetch3=$result3->fetch(PDO::FETCH_ASSOC);
																				if (isset($fetch3['id'])) {
																					$a2="SELECT * FROM networking where id_user=:id AND id_netuser=:idnet";
																				    $result4=$connect->prepare($a2);
																					$result4->bindvalue(":id",$fetch['id']);
																					$result4->bindvalue(":idnet",$fetch3['id']);
																					$num=$result4->execute();
																					if ($num) {
																						$add += $fetch2['mount'];
																					}
																				}
																		    }
																		    echo $add;
																		    ?>

																		</span>
																	</td>
																	<td style="width: 20%">
																		<div class="input-group">
																			<form method="get" action="edit.php">
																				<input type="text" class="form-control " name="text" style="direction: rtl;" value="<?= $fetch['netnum'] ?>" />
																				<input type="text" style="display: none" class="form-control " name="username" style="direction: rtl;" value="<?= $fetch['username'] ?>" />
																				<span class="input-group-btn">
																					<input type="submit" name="btn1"  class="btn btn-purple btn-sm form-control" value="ذخیره">
																				</span>
																			</form>
																		</div>
																	</td>
																	<td style="width: 20%">
																		<div class="input-group">
																			<form method="get" action="edit.php">
																				<input type="text" class="form-control " name="text" style="direction: rtl;" value="<?= $fetch['precentage'] ?>" />
																				<input type="text" style="display: none" class="form-control " name="username" style="direction: rtl;" value="<?= $fetch['username'] ?>" />
																				<span class="input-group-btn">
																					<input type="submit" name="btn"  class="btn btn-purple btn-sm form-control" value="ذخیره">
																				</span>
																			</form>
																		</div>
																	</td>
																	<td>
																		<a class="red open-event" href="delete.php/?delete=<?= $fetch['id'] ?>" data-toggle="modal" title="حذف">
																				<i class="ace-icon fa fa-trash bigger-130"></i>
																			</a>
																		<a class="green open-event" href="#usernetworking<?= $fetch['id']?>" data-toggle="modal" title="لینک اشتراکی این کاربر">
																				<i class="ace-icon fa fa-pencil bigger-130"></i>
																			</a>

																		<!-- Modal for view complate text -->
																		<div class = "modal fade" id ="usernetworking<?= $fetch['id']?>" tabindex = "-1" role = "dialog" aria-labelledby = "myModalLabel" aria-hidden = "true">

																		   <div class = "modal-dialog">
																		      <form class = "modal-content">

																		         <div class = "modal-header">
																		            <button  type = "button" class = "close pull-left" data-dismiss = "modal" aria-hidden = "true">
																		                  &times;
																		            </button>

																		            <h4 class = "modal-title" id = "myModalLabel">
																		               لینک دعوت از دوستان
																		            </h4>
																		         </div>

																		         <div class = "modal-body">

																		            <p style="margin: 50px;">
																		            	<strong>لینک : </strong><br><br><br> <strong>http://GGPOT.com/login/?id=<?= $id ?></strong>
																		            </p>


																		         </div>

																		         <div class = "modal-footer">
																		            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
																		               بستن
																		            </button>


																		         </div>

																		      </form><!-- /.modal-content -->
																		   </div><!-- /.modal-dialog -->

																		</div><!-- /.modal for view complate text -->

																	</td>
																	<td>
																		<a href="net/?id=<?= $id ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
																	</td>
																</tr>
																<?php
																	}
																?>
															</tbody>


														</table>

													</div>

												</div><!-- /.widget-main -->

											</div><!-- /.widget-body -->

										</div><!-- /.widget-box -->
									</div><!-- /.col -->
								</div><!-- /.row -->
								<div class="hr hr32 hr-dotted"></div>
								<!-- PAGE CONTENT ENDS -->
								</div>

							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder"></span>
							 &copy; 2017-2016
						</span>

					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="../assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="../assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="../assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="../assets/js/jquery.dataTables.min.js"></script>
		<script src="../assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="../assets/js/dataTables.buttons.min.js"></script>
		<script src="../assets/js/buttons.flash.min.js"></script>
		<script src="../assets/js/buttons.html5.min.js"></script>
		<script src="../assets/js/buttons.print.min.js"></script>
		<script src="../assets/js/buttons.colVis.min.js"></script>
		<script src="../assets/js/dataTables.select.min.js"></script>

		<!-- ace scripts -->
		<script src="../assets/js/ace-elements.min.js"></script>
		<script src="../assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable =
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": true },
					  null, null, null,null,null,null

					  { "bSortable": false }
					],
					"aaSorting": [],


					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,

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
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>نمایش یا مخفی کردن</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>کپی در سیستم</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>گرفتن خروجی با فرمت CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>گرفتن خروجی با فرمت Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>گرفتن خروجی با فرمت PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>پرینت</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'این پرینتی از فیلد توذنومنت ها است'
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





				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );




				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header

					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});

				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});



				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});



				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header

					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});

				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});



				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();

					var off2 = $source.offset();
					//var w2 = $source.width();

					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}




				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/





				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/


			})


				$( ".open-event" ).tooltip({
					show: null,
					position: {
						my: "left top",
						at: "left bottom"
					},
					open: function( event, ui ) {
						ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
					}
				});
		</script>
	</body>
</html>
