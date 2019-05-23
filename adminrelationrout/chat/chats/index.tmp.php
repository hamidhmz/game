
<?php 
    session_start();
    if (!isset($_SESSION['tmpadminname']))
    {
        header("location:../../login");
        exit();
    }//direction = 0 yani karbar
    require "../../../db/db.php";
    require "../../../notif/notif.php";
    require "../../../users/api/API.php";
    $who = $_SESSION['id'];
    
    $sqlf="select * from chat where id_user=:id ";
    $resultf=$connect->prepare($sqlf);
    $resultf->bindvalue(":id",$who);
    $resultf->execute();
    while($fetchf=$resultf->fetch(PDO::FETCH_ASSOC)){
        $sqlf1="UPDATE `chat` SET `status`=1 WHERE id=:id";
        $resultf1=$connect->prepare($sqlf1);
        $resultf1->bindvalue(":id",$fetchf['id']);
        $resultf1->execute();
    }
    $sqll="UPDATE `tmpuser` SET status=1 WHERE id=:id";
    $resultl=$connect->prepare($sqll);
    $resultl->bindvalue(":id",$who);
    $resultl->execute();
    $sql="select * from tmpuser where id=:id;";
    $result=$connect->prepare($sql);
    $result->bindvalue(":id",$who);
    $result->execute();
    $fetch=$result->fetch(PDO::FETCH_ASSOC);
    $sqlp="select * from chat where id_user=:id ";
    $resultp=$connect->prepare($sqlp);
    $resultp->bindvalue(":id",$fetch['id']);
    $resultp->execute();
    while($fetchp=$resultp->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div style="margin-bottom: 10px;" class= <?php echo "'"; echo"col-xs-12 "; if($fetchp['direction'] == 0){echo "in";}else{echo "out";} echo "'"; ?>>
        <div class="wrap-ut">
            <div class="userinfo">
               <div class="  img-sm">
                   <img src=
                   	<?php
                   	if ($fetchp['direction'] == 0) {
                   		if ($fetch['pic'] != "")
                        {
                            echo "'../../../users/vendor/images/users/";
                            echo "034f29d59bab82c991550ef6a46399fdr.png";
                            echo "'";
                        }
                        else
                        {
                            $sqlp1="select * from topic where id=1 ;";
                            $resultp1=$connect->prepare($sqlp1);
                            $resultp1->execute();
                            $fetchp1=$resultp1->fetch(PDO::FETCH_ASSOC);
                            echo "'../../../img/";
                            echo "034f29d59bab82c991550ef6a46399fdr.png";
                            echo "'";
                        }
                   	}else{
                   		$sqlp1="select * from topic where id=1 ;";
                        $resultp1=$connect->prepare($sqlp1);
                        $resultp1->execute();
                        $fetchp1=$resultp1->fetch(PDO::FETCH_ASSOC);
                   		echo "'../../../img/";
                        echo "034f29d59bab82c991550ef6a46399fdr.png";
                        echo "'";
                   	}
                        
                        
                    ?>
                   class=" img-responsive " width="600" height="600" >
               </div> 
            </div>
            <div class="posttext text-right rounded-5">
                <small class="label label-success time"><i class="fa fa-calendar margin-left-10 "></i><?= $fetchp['date'] ?></small>
               <span class="">نام فرستنده :<small> <?php if($fetchp['direction'] == 0){echo $fetch['username'];}else{echo "مدیر";}  ?></small><i class="icon-note pull-right margin-left-10"></i></span>
                <br>
                <strong>متن پیام : </strong> <i class="icon-bubbles pull-right margin-left-10"></i><span class="alert no-padding"><?= $fetchp['text'] ?></span>
            </div>
            
        </div>
    </div>



    <?php
    }
