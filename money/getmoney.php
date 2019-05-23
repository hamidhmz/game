<?php
    if (!isset($_COOKIE['tmpname']))
    {
        header("location:../");
        exit();
    }
    function xss($value)
	{
	$val=addslashes($value);
	$string1=strip_tags($val);
	// or    htmlspecialchars
	return $string1;
	}
    date_default_timezone_set('Asia/Tehran');
	require "../users/api/API.php";
    require "../db/db.php";
	$Player = $_COOKIE['tmpname'];
	$sql = "select * from tmpuser where username=:user;";
	$result = $connect->prepare($sql);
	$result -> bindvalue(":user",$Player);
	$result -> execute();
	$fetch = $result->fetch(PDO::FETCH_ASSOC);
	$active = $fetch['active'];
	if ($active == '0')
	{
		header('location:../money/?error=917');
		exit();
	}
	if ($fetch['acount'] != '0') {
		$acount = $fetch['acount'];
		$realname = $fetch['acountrealname'];
		$shaba = $fetch['shaba'];
	}
	if((isset($_POST["Submit"]))&&(isset($acount))&&(isset($realname))&&(isset($_POST["Mount"])))
	{
		$sqlp2 = "SELECT * FROM `tmpgetmoney` WHERE status=0 AND id_user=:id";
		$resultp2 = $connect->prepare($sqlp2);
		$resultp2 -> bindvalue(":id",$fetch['id']);
		$resultp2 -> execute();
		$fetchp2 = $resultp2->fetch(PDO::FETCH_ASSOC);
		if(isset($fetchp2['id'])){
			header('location:../money/?error=935');
			exit();
		}
		$RealName = $realname;
		$Account = $acount;
		$Mount = xss($_POST["Mount"]);
		if ($Mount<30000) {
			header("location:../money/?error=930");//hade aghale mablaghe dar khasti si hezartoman mibashad
			exit();
		}
        $params = array("Command"  => "AccountsGet",
                        "Player"   => $Player,);
        $api = Poker_API($params);
        $Balance = $api -> Balance;
        if ($Balance > 30000)
        {
        	if ($Mount <= $Balance)
        	{
        		$left = $Balance - $Mount;
        		$params = array("Command"  => "AccountsEdit",
								"Player"   => $Player,
								"Balance"  => $left,);
				$api = Poker_API($params);
				if ($api -> Result == "Ok")
				{

	        		$sql = "select * from tmpuser where username=:user;";
					$result = $connect->prepare($sql);
					$result -> bindvalue(":user",$Player);
					$result -> execute();
					$fetch = $result->fetch(PDO::FETCH_ASSOC);
					$id_user = $fetch['id'];
					$date = date('Y/m/d');
					$a = "INSERT INTO `tmpgetmoney` ( `id_user`, `date`, `mount`, `status` , realname , account,shaba,day,year,month) VALUES ( :iduser, :date1, :mount,'0',:realname , :account ,:shaba,:day,:year,:month);";
			        $result = $connect -> prepare($a);
			        $result -> bindvalue(":iduser",$id_user);
			        $result -> bindvalue(":date1",$date);
			        $result -> bindvalue(":mount",$Mount);
			        $result -> bindvalue(":realname",$RealName);
			        $result -> bindvalue(":account",$Account);
              $result -> bindvalue(":shaba",$shaba);
              $result -> bindvalue(":day",date(d));
      				$result -> bindvalue(":month",date(m));
      				$result -> bindvalue(":year",date(y));
			        $num = $result -> execute();
			        if($num)
			        {
			        	header("location:../money/?tip=808");
						exit();
			        }
			        else
			        {
			        	header("location:../money/?error=918");
						exit();
			        }
			    }
				else
				{
					header("location:../money/?error=904");
					exit();
				}
        	}
        	else
        	{
        		header("location:../money/?error=916");
        		exit();
        	}
        }
        else
        {
        	header("location:../money/?error=915");
        	exit();
        }
    }
    else
    {
    	header("location:../money/?error=901");
        exit();
    }
