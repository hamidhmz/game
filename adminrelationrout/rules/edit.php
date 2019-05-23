<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	header("location:../login");
	exit();
	}
	include ("../../db/db.php");
	if(isset($_POST['btn']))
	{
		$matn=$_POST["matn"];
		$a="UPDATE `topic` SET `text` = :matn WHERE `topic`.`id` = 1;";
		$result=$connect->prepare($a);
		$result->bindvalue(":matn",$matn);
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