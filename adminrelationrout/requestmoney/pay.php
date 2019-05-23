<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	  header("location:../login");
	  exit();
	}
	require "../../db/db.php";
	if (isset($_GET['id'])) {
		$id = $_GET["id"];
		$a="UPDATE `tmpgetmoney` SET `status` = '1' WHERE `tmpgetmoney`.`id` = :id ;";
		$result=$connect->prepare($a);
		$result->bindvalue(":id",$id);
		$num=$result->execute();
		if ($num) {
			header("location:../requestmoney/?tip=806");
			exit();
		}
	}
	