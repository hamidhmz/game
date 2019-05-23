	<?php
    require "../db/db.php";
    require "../notif/notif.php";
    require "../users/api/API.php";
    if(isset($_POST['btn1'])){
    ?>
        <div class="row">
       
        <div class="" style=" ">
			<div class="row">
				<div style="padding: 5px;direction: rtl;margin: 0 0 10px 0 ">
				   <p>
				   <?php
				    $sql="select * from topic where id=5;";
				    $result=$connect->prepare($sql);
				    $result->execute();
				    $fetch=$result->fetch(PDO::FETCH_ASSOC);
				    echo $fetch['text'];
				    ?>
				   </p>
				</div>
			</div>
        </div>
        </div>
    <?php 
	}

	if(isset($_POST['btn3'])){
    ?>
        <div class="row">         
            <div class="" style="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading rtl">
                                ارسال دعوتنامه به دوستان
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12" style="margin: 10px auto">
                                       <p class="rtl" style="padding: 20px 5px; font-size: 16px;line-height: 2;">
                                           دوستان خود را به بازی دعوت کنید و با بُرد و کسب امتیاز آنها شما هم درآمد داشته باشید .
                                           <br>
                                           شما میتوانید 5 نفر را دعوت کنید و به زیرمجموعه های خود اظافه نمایید .
                                           <br>
                                           برای دعوت ایمیل فرد مورد نظرتان را وارد کنید و ارسال را بزنید . 
                                       </p>
                                        <div class="row">
                                           
                                           <form role="form" method="POST" action="send.php">
                                                <fieldset >
                                                    <div class="form-group rtl">
                                                        <label for="username">ایمیل </label>
                                                        <input class="form-control" placeholder="ایمل را وارد کنید " name="email" id="username" type="email" style="width: 65%" />
                                                    </div>
                                                    <div class=" rtl">
                                                        <input type="submit" name="btn" class="btn btn-success " value="ارسال دعوت نامه ">
                                                    </div>
                                                </fieldset>
                                            </form>
                                       </div>
                                        
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
    <?php 
	}
	if(isset($_POST['btn4'])){
    ?>
        <div class="row">
       
        <div class="" style=" ">
			<div class="row">
				<div style="padding: 20px;direction: rtl;margin: 0 0 50px 0 ">
				   <p>
				   <?php
				    $sql="select * from tmpuser where username=:user;";
				    $result=$connect->prepare($sql);
				    $result -> bindvalue("user",$_COOKIE['tmpname']);
				    $result->execute();
				    $fetch=$result->fetch(PDO::FETCH_ASSOC);
				    echo "The number of people you can invite:";
				    echo $fetch['netnum'];
				    ?>
				   </p>
				</div>
			</div>
        </div>
        </div>
    <?php 
	}
	
	if(isset($_POST['btn2'])){
    ?>
        <div class="row">
                       
	        <div class="" style="">
	            <div class="row">
	                <div class="col-lg-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading rtl">
	                            اطلاعات زیرمجموعه ها .
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
	                                                <th>سطح</th>
	                                                <th class="hidden-xs">تعداد ورود به بازی</th>
	                                                <th>وضعیت </th>
	                                                
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                        	<?php 
	                                            	$who = $_COOKIE['tmpname'];
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
			                                        while($fetch1=$result1->fetch(PDO::FETCH_ASSOC)){ $i++; 
	                                           	?>
	                                            <tr>
	                                                <td><?= $i; ?></td>
	                                                <td>
	                                                    <span><?php 
	                                                    		$sql2="select * from tmpuser where id=:user;";
						                                        $result2=$connect->prepare($sql2);
						                                        $result2->bindvalue(":user",$fetch1['id_netuser']);
						                                        $result2->execute();
						                                        $fetch2=$result2->fetch(PDO::FETCH_ASSOC); echo $fetch2['username'];
	                                                    ?></span>
	                                                </td>
	                                                <td>
	                                                    <span>
	                                                    <?php 
                                                    		$Player = $fetch2['username'];
                                                            $params = array("Command"  => "AccountsGet",
                                                                            "Player"   => $Player,);
                                                            $api = Poker_API($params);
                                                            echo $api -> Level;
                                                            $logins = $api -> Logins;
                                                        ?> 	
                                                        </span>
	                                                </td>
	                                                <td class="hidden-xs"><?= $logins; ?></td>
	                                                <td>
	                                                	<a href="delete.php?delete=<?= $fetch1['id'] ?>" class="btn btn-xs btn-danger" data-toggle = "tooltip" data-placement = "bottom" title = "حذف"><i class="fa fa-trash"></i></a>
	                                                <?php 
	                                                	if ($fetch2['active'] == 0) {
                                            		?>
                                            			<a  class="btn btn-xs btn-warning" data-toggle = "tooltip" data-placement = "bottom" title = "">غیر فعال</a>
                                            		<?php
	                                                	}else{
                                            		?>
                                            			<a  class="btn btn-xs btn-success" data-toggle = "tooltip" data-placement = "bottom" title = "">فعال</a>
                                            		<?php
	                                                	}
	                                                ?>
	                                                </td>
	                                            </tr>
	                                            <?php } ?>
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
<script src="../users/js/datatable/js/jquery.dataTables.min.js"></script>
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
                      null, null,null,
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

    <?php 
	}

    ?>
