<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
		header("location:../login");
		exit();
	}
	include ("../../db/db.php");
	if (isset($_GET['delete'])) {
		$id=$_GET["delete"];
		$a="UPDATE `tmpuser` SET networked=0 where `id` = :id ";
		$result=$connect->prepare($a);
		$result->bindvalue(":id",$id);
		$num=$result->execute();
		if ($num)
		{
			$sql = "DELETE FROM `networking` WHERE `networking`.`id_user` = :id";
			$result=$connect->prepare($a);
			$result->bindvalue(":id",$id);
			$num=$result->execute();
			if ($num) {
				header("location:../?tip=808");
				exit();
			}
		}
	}