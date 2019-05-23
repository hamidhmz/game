
<?php 
    if (!isset($_COOKIE['tmpname']))
    {
        header("location:../../login");
        exit();
    }
    require "../../users/api/API.php";
    require "../../db/db.php";
    require "../../notif/notif.php";
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
                            echo "'../../users/vendor/images/users/";
                            echo $fetch['pic'];
                            echo "'";
                        }
                        else
                        {
                            $sqlp1="select * from topic where id=1 ;";
                            $resultp1=$connect->prepare($sqlp1);
                            $resultp1->execute();
                            $fetchp1=$resultp1->fetch(PDO::FETCH_ASSOC);
                            echo "'../../img/";
                            echo '034f29d59bab82c991550ef6a46399fdr.png';
                            echo "'";
                        }
                    }else{
                        $sqlp1="select * from topic where id=1 ;";
                        $resultp1=$connect->prepare($sqlp1);
                        $resultp1->execute();
                        $fetchp1=$resultp1->fetch(PDO::FETCH_ASSOC);
                        echo "'../../img/";
                        echo '034f29d59bab82c991550ef6a46399fdr.png';
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
