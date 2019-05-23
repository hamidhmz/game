<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	  header("location:../login");
	  exit();
	}
	include ("../../db/db.php");
	if(isset($_GET['inactive']))
	{
		$id=$_GET["inactive"];
		$a="UPDATE `tmpuser` SET `active`=0 WHERE id=:id";
		$result=$connect->prepare($a);
		$result->bindvalue(":id",$id);
		$num=$result->execute();
		if ($num)
		{
			header("location:../users/?tip=809");
			exit();
		}
		else
		{
			header("location:../users/?error=919");
			exit();
		}
	}
	if(isset($_GET['active']))
	{
		$id=$_GET["active"];
		$a="UPDATE `tmpuser` SET `active`=0 WHERE id=:id";
		$result=$connect->prepare($a);
		$result->bindvalue(":id",$id);
		$num=$result->execute();
		if ($num)
		{
			header("location:../users/?tip=812");
			exit();
		}
		else
		{
			header("location:../users/?error=919");
			exit();
		}
	}
