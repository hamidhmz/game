<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	header("location:../login");
	exit();
	}
	include ("../../db/db.php");
	if(isset($_GET['btn']))
	{
		$text=$_GET["text"];
		$a="UPDATE `tmpuser` SET `precentage` = :precentage where username=:username";
		$result=$connect->prepare($a);
		$result->bindvalue(":username",$_GET['username']);
		$result->bindvalue(":precentage",$text);
		$num=$result->execute();
		if ($num)
		{
			echo "<b><font color=green>اطلاعات ثبت شد</font></b>";
			header("location:../networking/?tip=808");
			exit();
		}
		else
		{
			echo "<b><font color=red>خطا در درج</font></b>";
			header("location:../networking/?error=919");
			exit();
		}
	}
	if(isset($_GET['btn1']))
	{
		$text=$_GET["text"];
		$a="UPDATE `tmpuser` SET `netnum` = :netnum where username=:username";
		$result=$connect->prepare($a);
		$result->bindvalue(":username",$_GET['username']);
		$result->bindvalue(":netnum",$text);
		$num=$result->execute();
		if ($num)
		{
			echo "<b><font color=green>اطلاعات ثبت شد</font></b>";
			header("location:../networking/?tip=808");
			exit();
		}
		else
		{
			echo "<b><font color=red>خطا در درج</font></b>";
			header("location:../networking/?error=919");
			exit();
		}
	}
