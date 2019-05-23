<?php
session_start();
if (!isset($_SESSION['who']))
    {
        header("location:../");
        exit();
    }
	require "../../db/db.php";
	require "../../users/api/API.php";
	if (isset($_POST['btn']) && isset($_POST['Password1']) && isset($_POST['Password2']))
	{
		if ($_POST['Password2'] == $_POST['Password1']) 
		{
			$pass = md5($_POST['Password1']);
			$who = $_SESSION['who'];
			$a="UPDATE tmpuser SET password=:pass where username=:who ";
			$result=$connect->prepare($a);
			$result->bindvalue(":pass",$pass);
			$result->bindvalue(":who",$who);
			$num=$result->execute();
			if ($num) 
			{
				$params = array("Command"  => "AccountsEdit",
		                        "Player"   => $who,
				                      "pw" => $_POST['Password1'], );
				$api = Poker_API($params);
			    if ($api -> Result == "Ok")
			    {
			    	unset($_SESSION['who']);
					header('location:../?tip=806');
					exit();
				}
				else
				{
					unset($_SESSION['who']);
					header('location:../?error=909&machine=out');
					exit();
				}
			}
			else
			{
				unset($_SESSION['who']);
				header('location:../?error=909');
				exit();
			}
		}
		else
		{
			unset($_SESSION['who']);
			header('location:../?error=912');
			exit();
		}
	}
	else
	{
		unset($_SESSION['who']);
		header('location:../?error=901');
		exit();
	}
	
	