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
	if((isset($_POST["btn"]))&&(isset($_POST['RealName']))&&(isset($_POST['Account'])))
	{
		$RealName =xss($_POST['RealName']);
		$Account = xss($_POST['Account']);
		if (($_POST['Shaba'])!='' && !empty($_POST['Shaba']) & isset($_POST['Shaba'])) {
			$Shaba = xss($_POST["Shaba"]);
			if (strlen($Shaba)<24) {
				header("location:../money/?error=933");exit();
			}
			if (strlen($Account)<16) {
				header("location:../money/?error=932");exit();
			}
		}else {
			$Shaba = '0';
			if (strlen($Account)<16) {
				header("location:../money/?error=932");exit();
			}
		}
		$sqlp1 = "UPDATE `tmpuser` SET `acount`=:acount,`acountrealname`=:realname,`shaba`=:shaba WHERE username=:username ";
		$resultp1 = $connect->prepare($sqlp1);
		$resultp1 -> bindvalue(":acount",$Account);echo $Account;
		$resultp1 -> bindvalue(":realname",$RealName);echo $RealName;
		$resultp1 -> bindvalue(":shaba",$Shaba);
		$resultp1 -> bindvalue(":username",$Player);echo $Player.$Shaba;
		echo $num = $resultp1 -> execute();
		if ($num>0) {
			header("location:../money/?tip=814");//ba movafaghiat sabt shod
			exit();
		}else{
			header("location:../?error=928");//badan emtehan konid namovafagh bod
			exit();
		}
	}else{
		header("location:../?error=929");//vorode gheyre mojaz
		exit();
	}