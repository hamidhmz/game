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
		$username=$_POST["caption"];
		$sql="select * from tmpuser where username=:username;";
		$result=$connect->prepare($sql);
		$result->bindvalue(":username",$username);
		$num = $result->execute();
		$fetch1=$result->fetch(PDO::FETCH_ASSOC);
		if(isset($fetch1['id'])){
	        $a="insert into gift (id,id_user,type) values ('',:id,1) ";
			$result=$connect->prepare($a);
			$result->bindvalue(":id",$fetch1['id']);
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
		else{
			echo "<b><font color=red>این کاربر وجود ندارد</font></b>";
		}
	}
	if(isset($_POST['btn2']))
	{
		$username=$_POST["caption"];
		$sql="select * from tmpuser where username=:username;";
		$result=$connect->prepare($sql);
		$result->bindvalue(":username",$username);
		$num = $result->execute();
		$fetch1=$result->fetch(PDO::FETCH_ASSOC);
		if(isset($fetch1['id'])){
	        $a="insert into gift (id,id_user,type) values ('',:id,2) ";
			$result=$connect->prepare($a);
			$result->bindvalue(":id",$fetch1['id']);
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
		else{
			echo "<b><font color=red>این کاربر وجود ندارد</font></b>";
		}
	}
	if(isset($_POST['btn3']))
	{
		$caption=$_POST["caption"];
		$a="UPDATE `topic` SET `text` = :caption where id=5 ";
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
		