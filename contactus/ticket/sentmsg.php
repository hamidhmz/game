<?php 
	if (!isset($_COOKIE['tmpname']))
    {
        header("location:../../login");
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
	if(isset($_POST['btn1']))
	{
		$sqll="UPDATE `tmpuser` SET status=0 WHERE username=:username";
	    $resultl=$connect->prepare($sqll);
	    $resultl->bindvalue(":username",$who);
	    $resultl->execute();
		$caption=xss($_POST["caption"]);
		$a="INSERT INTO `chat`( `id_user`, `text`, `date`, `status`, `direction`) VALUES (:id_user,:caption,:dat,0,0)";
		$result=$connect->prepare($a);
		$result->bindvalue(":id_user",$fetch['id']);
		$result->bindvalue(":caption",$caption);
		$result->bindvalue(":dat",date("Y/n/d-g:i:s a"));
		$num=$result->execute();
		if ($num)
		{
			echo "<b><font color=green>اطلاعات ثبت شد</font></b>";
		}
		else
		{
			echo "<b><font color=red>خطا در درج</font></b>";
		}
	}