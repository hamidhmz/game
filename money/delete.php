<?php
	if (!isset($_COOKIE['tmpname']))
    {
        header("location:../");
        exit();
    }
    require "../db/db.php";
    require "../users/api/API.php";
	$sql = "select * from tmpuser where username=:user;";
	$result = $connect->prepare($sql);
	$result -> bindvalue(":user",$_COOKIE['tmpname']);
	$result -> execute();
	$fetch = $result->fetch(PDO::FETCH_ASSOC);
	$active = $fetch['active'];
	if ($active == '0')
	{
		header('location:../money/?error=917');
		exit();
	}
	if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
		$sqlp1 = "select * from tmpgetmoney where id=:id;";
		$resultp1 = $connect->prepare($sqlp1);
		$resultp1 -> bindvalue(":id",$id);
		$resultp1 -> execute();
		$fetchp1 = $resultp1->fetch(PDO::FETCH_ASSOC);
		$sql="DELETE FROM `tmpgetmoney` WHERE id=:id ";
		$result=$connect->prepare($sql);
		$result->bindvalue(":id",$id);
		$num = $result->execute();
		if ($num) {
			$params = array("Command"  => "AccountsGet",
	                    	"Player"   => $_COOKIE['tmpname'],);
	        $api = Poker_API($params);
	        $Balance = $api -> Balance;
	        $Balance += $fetchp1['mount'];
    		$params = array("Command"  => "AccountsEdit",
							"Player"   => $_COOKIE['tmpname'],
							"Balance"  => $Balance,);
			$api = Poker_API($params);
			if ($api -> Result == "Ok") 
			{
				header("location:../money/?tip=815");exit();
			}else{
				header("location:../money/?error=919");
				exit();
			}
		}else{
			header("location:../money/?error=918");
			exit();
		}
	}else {
		header("location:../money/");
		exit;
	}
		