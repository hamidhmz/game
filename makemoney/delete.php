<?php 
    if (!isset($_COOKIE['tmpname']))
    {
        header("location:../");
        exit();
    }
    require "../db/db.php";
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
    if(isset($_GET['delete']))
	{	
		$id=$_GET["delete"];
		$sqlp1="select * from networking where id=:user;";
		$resultp1=$connect->prepare($sqlp1);
		$resultp1->bindvalue(":user",$id);
		$resultp1->execute();
		$fetchp1=$resultp1->fetch(PDO::FETCH_ASSOC);
		if (isset($fetchp1['id'])&&($fetch['id']==$fetchp1['id_user'])) {
			$sqlp2="select * from tmpuser where id=:id;";
			$resultp2=$connect->prepare($sqlp2);
			$resultp2->bindvalue(":id",$fetchp1['id_user']);
			$resultp2->execute();
			$fetchp2=$resultp2->fetch(PDO::FETCH_ASSOC);
			$a="DELETE FROM `networking` WHERE `id` = :id";
			$result=$connect->prepare($a);
			$result->bindvalue(":id",$id);
			$num=$result->execute();
			if ($num)
			{
				$num = 0;
				$num = $fetchp2['netnum'];
				$num++;
				$a="UPDATE tmpuser SET netnum=:num where id=:id ";
				$result=$connect->prepare($a);
				$result->bindvalue(":num",$num);
				$result->bindvalue(":id",$fetchp1['id_user']);
				$num=$result->execute();
				header("location:../makemoney/?tip=813");
				exit();
			}
			else
			{
				header("location:../makemoney/?error=919");
				exit();
			}
				
		}
	}