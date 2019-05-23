<?php
	if (!isset($_COOKIE['tmpname']))
    {
        header("location:../");
        exit();
    }
    function xss($value)
	{
	$val=addslashes($value);
	$string1=strip_tags($val);
	// or    htmlspecialchars
	return $string1;
	}
	require "../db/db.php";
	if(isset($_GET['submit']) && isset($_GET['text']) && ($_GET['text']!=""))
	{
		$text=xss($_GET['text']);
		$email=xss($_GET['email']);
		$name=xss($_GET['name']);
		$a="insert into tmpcontact (name,caption,email,text) values (:name,'1',:email,:text) ";
        $result=$connect->prepare($a);
        $result->bindvalue(":name",$name);
        $result->bindvalue(":email",$email);
        $result->bindvalue(":text",$text);
        echo $num=$result->execute();
        header('location:../contactus/?tip=802');
        exit();
	}
	else
	{
		// header('location:../contactus/?error=901');
		// exit();
	}