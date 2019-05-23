<?php       
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	header("location:../login");
	exit();
	}

	unset($_SESSION['tmpadminname']);
	header("location:../login/?tip=803");
	exit();