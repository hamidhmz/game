<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
		header("location:../login");
		exit();
	}
	require "../../db/db.php";
    require "../../notif/notif.php";
    require "../../users/api/API.php";

    date_default_timezone_set('Asia/Tehran');
    if (isset($_GET['btn'])) {
    	$Player = $_GET['username'];
		$mount = $_GET['mount'];
		$sqlp="select * from tmpuser where username=:user;";
	    $resultp=$connect->prepare($sqlp);
	    $resultp->bindvalue(":user",$Player);
	    $resultp->execute();
	    $fetchp=$resultp->fetch(PDO::FETCH_ASSOC);
	    if (!isset($fetchp['id'])) {
	    	header("location:../depositmoney/?error=931");
	    	exit();
	    }
	    
		$params = array("Command"  => "AccountsGet",
	                    "Player"   => $Player,);
	    $api = Poker_API($params);
	    $Blanace = $api -> Balance;
	    $Blanace += $mount;
	    $params = array("Command"  => "AccountsEdit",
	                    "Player"   => $Player,
	                    "Balance"  => $Blanace,);
	    $api = Poker_API($params);
	    $str="0123456789abcdefghijklmnopqrstuvwxyz";
		$max=strlen($str)-1;
		$result1="";
		for($i=0;$i<5;$i++)
		{
			$random=rand(0,$max);
			$char=substr($str,$random,1);
			$result1.=$char;
		}
		$tar=strtoupper($result1);
		$t = 0;
		$tarakonesh = md5($tar);
		while ($t==0) {
			
			$sqlp3="select * from tmpaddmoney where tarakonesh=:tarakonesh;";
		    $resultp3=$connect->prepare($sqlp3);
		    $resultp3->bindvalue(":tarakonesh",'530'.$tarakonesh);
		    $resultp3->execute();
		    $fetchp3=$resultp3->fetch(PDO::FETCH_ASSOC);
	    	if(isset($fetchp3['id'])){
	    		$tarakonesh .='1';
	    	}else{
	    		$t=1;
	    	}
		}
	    if ($api -> Result == "Ok") {
	    	$a = "INSERT INTO `tmpaddmoney`(`id_user`, `mount`, `tarakonesh`, `year`, `month`, `day`, `week`,`time`) VALUES (:id_user,:amount,:tarakonesh,:year,:month,:day,:week,:time) ";
		    $result = $connect->prepare($a);
		    $result->bindvalue(":id_user",$fetchp['id']);
		    $result->bindvalue(":year",date('y'));
		    $result->bindvalue(":month",date('m'));
		    $result->bindvalue(":day",date('d'));
		    $result->bindvalue(":week",date('W'));
		    $result->bindvalue(":amount",$mount);
		    $result->bindvalue(":tarakonesh",'530'.$tarakonesh);
		    $result->bindvalue(":time",date("Y/n/d-g:i:s a"));
		    $num = $result->execute();
		    if ($num){
		        header('location:../depositmoney/?tip=810');
	        	exit();
		    }else{
		    	header("location:../depositmoney/?error=db error");
		    	exit();
		    }
	    }else{
	    	header("location:../depositmoney/?error=api error");
	    	exit();
	    }
    }else{
    	header("location:../depositmoney/");
    	exit();
    }
