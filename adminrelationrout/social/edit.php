<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	header("location:../login");
	exit();
	}
	include ("../../db/db.php");
	if(isset($_POST['btn1']))
	{
		$caption=$_POST["caption"];
		$a="UPDATE `social` SET `telegram` = :caption ";
		$result=$connect->prepare($a);
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
	if(isset($_POST['btn2']))
	{
		$caption=$_POST["caption"];
		$a="UPDATE `social` SET `instagram` = :caption ";
		$result=$connect->prepare($a);
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
	if(isset($_POST['btn3']))
	{
		$caption=$_POST["caption"];
		$a="UPDATE `social` SET `twitter` = :caption ";
		$result=$connect->prepare($a);
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
		