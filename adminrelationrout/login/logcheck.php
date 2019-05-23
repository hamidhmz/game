<?php 
	session_start();
    if (isset($_SESSION['tmpadminname']))
    {
        header("location:../");
        exit();
    }
	require "../../db/db.php";
	if((isset($_POST["Submit"]))&&(isset($_POST["UserName"]))&&(isset($_POST["Password"])))
	{
		if (!isset($_POST['ct_captcha'])) {
			header("location:../login/?error=921");
            exit();
		}
        require_once dirname(__FILE__) . '/securimage.php';
        $securimage = new Securimage();
        $captcha = @$_POST['ct_captcha'];
        if ($securimage->check($captcha) == false) {
            $errors['captcha_error'] = 'Incorrect security code entered';
            header("location:../login/?error=925");
            exit();
        }
		$UserName = $_POST["UserName"];
		$Password = $_POST["Password"];
		$a="select * from tmpadmin where username=:user && password=:pass";
		$result=$connect->prepare($a);
		$pass=md5($Password);
		$result->bindvalue(":user",$UserName);
		$result->bindvalue(":pass",$pass);
		$result->execute();
		$num=$result->fetchColumn();
		if($num>0)
	    {
	      $_SESSION['tmpadminname'] = $UserName;
	      header("location:../?tip=800"); //shoma vorod kardid
	      exit();
	    }
	    else
	    {
	      header("location:../login/?error=903"); //hamchin usernami vojod nadarad
	      exit();
	    }
	}
	else
	{
	    header("location:../login/?error=901"); //fild ha khali ast
	    exit();
	}