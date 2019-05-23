<?php
	require "../../db/db.php";
	session_start();
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

		<meta name="description" content="Mailbox with some customizations as described in docs" />
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

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="../assets/js/html5shiv.min.js"></script>
		<script src="../assets/js/respond.min.js"></script>
		<![endif]-->
		<?php
		require "../../notif/notif.php";
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
					<li class="active">
						<a href="../pic" >
							<i class="menu-icon fa fa-flag"></i>
							<span class="menu-text">
								تغییر عکس صفحات پنل کاربر
							</span>
							<b class="arrow fa fa-angle-left"></b>
						</a>
					</li>
					<li class="">
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
								<a href="../">داشبورد</a>
							</li>

						</ul><!-- /.breadcrumb -->

						<!-- /.nav-search -->
					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								ویرایشگر صفحات
								<small>
									<i class="ace-icon fa fa-angle-double-left"></i>
									ویرایش عکس صفحه ی <span class="green">پنل کاربر</span>
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->


								<div class="row">

									<div class="col-sm-3">
										<div class="row">
											<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
											    عکس صفحه اول از چپ اولی
												<input name="file" type="file" />
												<input name="submit1" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
											</form>
										</div>

									</div>


									<div class="col-sm-3">
										<div class="row">
											<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
											    عکس صفحه اول از چپ دومی
												<input name="file" type="file" />
												<input name="submit3" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
											</form>
										</div>

									</div>

									<div class="col-sm-3">
										<div class="row">
											<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
											    عکس صفحه اول از چپ سومی
												<input name="file" type="file" />
												<input name="submit4" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
											</form>
										</div>

									</div>
									<div class="col-sm-3">
										<div class="row">
											<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
											    عکس صفحه اول از چپ چهارمی
												<input name="file" type="file" />
												<input name="submit5" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
											</form>
										</div>

									</div>


									</div>
									<hr>
									<div class="row">
										<h4 style="text-align: right;">تغییر عکس اسلایدر </h4>
										<hr>
										<div class="col-sm-3">
											<div class="row">
												<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
												    عکس اسلایدر اول
													<input name="file" type="file" />
													<input name="submit6" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
												</form>
											</div>

										</div>
										<div class="col-sm-3">
											<div class="row">
												<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
												    عکس اسلایدر دوم
													<input name="file" type="file" />
													<input name="submit7" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
												</form>
											</div>

										</div>
										<div class="col-sm-3">
											<div class="row">
												<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
												    عکس اسلایدر سوم
													<input name="file" type="file" />
													<input name="submit8" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
												</form>
											</div>

										</div>
										<div class="col-sm-3">
											<div class="row">
												<form method="post" action="edit.php" enctype="multipart/form-data" class="col-xs-12" style="direction: rtl;">
												    عکس اسلایدر چهارم
													<input name="file" type="file" />
													<input name="submit9" type="submit" style="margin: 10px" class="btn btn-success" value="ذخیره" >
												</form>
											</div>

										</div>
									</div>
								</div>

								<!-- PAGE CONTENT ENDS -->
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
							<a href="" target="blank">tmpiran</a>  &copy; 2017-2016
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
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="../assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="../assets/js/jquery-ui.custom.min.js"></script>
		<script src="../assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="../assets/js/markdown.min.js"></script>
		<script src="../assets/js/bootstrap-markdown.min.js"></script>
		<script src="../assets/js/jquery.hotkeys.index.min.js"></script>
		<script src="../assets/js/bootstrap-wysiwyg.min.js"></script>
		<script src="../assets/js/bootbox.js"></script>

		<!-- ace scripts -->
		<script src="../assets/js/ace-elements.min.js"></script>
		<script src="../assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($){

	$('textarea[data-provide="markdown"]').each(function(){
        var $this = $(this);

		if ($this.data('markdown')) {
		  $this.data('markdown').showEditor();
		}
		else $this.markdown()

		$this.parent().find('.btn').addClass('btn-white');
    })



	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			//console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	}

	//$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

	//but we want to change a few buttons colors for the third style
	$('#editor1').ace_wysiwyg({
		toolbar:
		[
			'font',
			null,
			'fontSize',
			null,
			{name:'bold', className:'btn-info'},
			{name:'italic', className:'btn-info'},
			{name:'strikethrough', className:'btn-info'},
			{name:'underline', className:'btn-info'},
			null,
			{name:'insertunorderedlist', className:'btn-success'},
			{name:'insertorderedlist', className:'btn-success'},
			{name:'outdent', className:'btn-purple'},
			{name:'indent', className:'btn-purple'},
			null,
			{name:'justifyleft', className:'btn-primary'},
			{name:'justifycenter', className:'btn-primary'},
			{name:'justifyright', className:'btn-primary'},
			{name:'justifyfull', className:'btn-inverse'},
			null,
			{name:'createLink', className:'btn-pink'},
			{name:'unlink', className:'btn-pink'},
			null,
			{name:'insertImage', className:'btn-success'},
			null,
			'foreColor',
			null,
			{name:'undo', className:'btn-grey'},
			{name:'redo', className:'btn-grey'}
		],
		'wysiwyg': {
			fileUploadError: showErrorAlert
		}
	}).prev().addClass('wysiwyg-style2');


	/**
	//make the editor have all the available height
	$(window).on('resize.editor', function() {
		var offset = $('#editor1').parent().offset();
		var winHeight =  $(this).height();

		$('#editor1').css({'height':winHeight - offset.top - 10, 'max-height': 'none'});
	}).triggerHandler('resize.editor');
	*/


	$('#editor2').css({'height':'200px'}).ace_wysiwyg({
		toolbar_place: function(toolbar) {
			return $(this).closest('.widget-box')
			       .find('.widget-header').prepend(toolbar)
				   .find('.wysiwyg-toolbar').addClass('inline');
		},
		toolbar:
		[
			'bold',
			{name:'italic' , title:'Change Title!', icon: 'ace-icon fa fa-leaf'},
			'strikethrough',
			null,
			'insertunorderedlist',
			'insertorderedlist',
			null,
			'justifyleft',
			'justifycenter',
			'justifyright'
		],
		speech_button: false
	});




	$('[data-toggle="buttons"] .btn').on('click', function(e){
		var target = $(this).find('input[type=radio]');
		var which = parseInt(target.val());
		var toolbar = $('#editor1').prev().get(0);
		if(which >= 1 && which <= 4) {
			toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
			if(which == 1) $(toolbar).addClass('wysiwyg-style1');
			else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
			if(which == 4) {
				$(toolbar).find('.btn-group > .btn').addClass('btn-white btn-round');
			} else $(toolbar).find('.btn-group > .btn-white').removeClass('btn-white btn-round');
		}
	});




	//RESIZE IMAGE

	//Add Image Resize Functionality to Chrome and Safari
	//webkit browsers don't have image resize functionality when content is editable
	//so let's add something using jQuery UI resizable
	//another option would be opening a dialog for user to enter dimensions.
	if ( typeof jQuery.ui !== 'undefined' && ace.vars['webkit'] ) {

		var lastResizableImg = null;
		function destroyResizable() {
			if(lastResizableImg == null) return;
			lastResizableImg.resizable( "destroy" );
			lastResizableImg.removeData('resizable');
			lastResizableImg = null;
		}

		var enableImageResize = function() {
			$('.wysiwyg-editor')
			.on('mousedown', function(e) {
				var target = $(e.target);
				if( e.target instanceof HTMLImageElement ) {
					if( !target.data('resizable') ) {
						target.resizable({
							aspectRatio: e.target.width / e.target.height,
						});
						target.data('resizable', true);

						if( lastResizableImg != null ) {
							//disable previous resizable image
							lastResizableImg.resizable( "destroy" );
							lastResizableImg.removeData('resizable');
						}
						lastResizableImg = target;
					}
				}
			})
			.on('click', function(e) {
				if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
					destroyResizable();
				}
			})
			.on('keydown', function() {
				destroyResizable();
			});
	    }

		enableImageResize();

		/**
		//or we can load the jQuery UI dynamically only if needed
		if (typeof jQuery.ui !== 'undefined') enableImageResize();
		else {//load jQuery UI if not loaded
			//in Ace demo ./components will be replaced by correct components path
			$.getScript("assets/js/jquery-ui.custom.min.js", function(data, textStatus, jqxhr) {
				enableImageResize()
			});
		}
		*/
	}


});
		</script>
<script>
$(window).load(function() {
  $('#editor2').each(function(i) {
    $(this).css({'direction':'rtl'});
  });
})
</script>
		<script type="text/javascript">
		    $(document).ready(function(){
		    $("#save").click(function(){
		    	$("#txt").html("<b><font color=blue>اطلاعات در حال ارسال میباشد</font></b>");
		        var btn="save";
		        var caption = $("#caption").val();
		        var matn=$('#editor2').html();
		        $.post("edit.php",{matn:matn,btn:btn,caption:caption},function(data){$("#txt").html(data);});
		        });
		    });
	    </script>
	</body>
</html>
