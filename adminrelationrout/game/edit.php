<?php
	include ("../../db/db.php");
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	header("location:../login");
	exit();
	}
	if(isset($_POST['btn']))
	{
		$matn=$_POST["matn"];
		$caption=$_POST["caption"];
		$a="UPDATE `topic` SET `caption` = :caption , `text` = :matn WHERE `topic`.`id` = 7;";
		$result=$connect->prepare($a);
		$result->bindvalue(":matn",$matn);
		$result->bindvalue(":caption",$caption);
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
		