<?php
	if (!isset($_COOKIE['tmpname']))
    {
        header("location:../login/");
        exit();
    }
	$UserName=$_COOKIE['tmpname'];
	$Password1=$_COOKIE['tmppass'];
	setcookie("tmpname",$UserName,time()-86400*7,'/');
	setcookie("tmppass",$Password1,time()-86400*7,'/');
	if(isset($_COOKIE['tmpname']))
	{
		header("location:../?tip=803");
		exit();
	}