<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	  header("location:../login");
	  exit();
	}
	include ("../../db/db.php");
	if(isset($_GET['id']))
	{
		$id=$_GET["id"];
		$a="DELETE FROM `tmpcontact` WHERE `id` = :id";
		$result=$connect->prepare($a);
		$result->bindvalue(":id",$id);
		$num=$result->execute();
		if ($num)
		{
			header("location:../contact/?tip=811");
			exit();
		}
		else
		{
			header("location:../contact/?error=919");
			exit();
		}
	}