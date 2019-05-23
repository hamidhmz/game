<?php
    if (!isset($_COOKIE['tmpname']))
    {
        header("location:../");
        exit();
    }
	require "../db/db.php";
	require "../users/api/API.php";
	if (isset($_POST['lastpass']))
	{
		$who = $_COOKIE['tmpname'];
		$sql="select * from tmpuser where username=:user;";
	    $result=$connect->prepare($sql);
	    $result->bindvalue(":user",$who);
	    $result->execute();
	    $fetch=$result->fetch(PDO::FETCH_ASSOC);
	    if ($fetch['password'] == md5($_POST['lastpass']))
	    {
	    	if (isset($_POST['submit']) && isset($_POST['password1']) && isset($_POST['password2']))
			{
				if ($_POST['password2'] == $_POST['password1']) 
				{
					$pass = md5($_POST['password1']);
					$who = $_COOKIE['tmpname'];
					$a="UPDATE tmpuser SET password=:pass where username=:who ";
					$result=$connect->prepare($a);
					$result->bindvalue(":pass",$pass);
					$result->bindvalue(":who",$who);
					$num=$result->execute();
					if ($num) 
					{
						$params = array("Command"  => "AccountsEdit",
				                        "Player"   => $who,
						                      "pw" => $_POST['password1'], );
						$api = Poker_API($params);
     				    if ($api -> Result == "Ok")
     				    {
     				    	setcookie("tmppass",$_POST['password1'],time()+86400,'/');
							header('location:../settings/?tip=806');
							exit();
						}
						else
						{
							header('location:../settings/?error=909&machine=out');
							exit();
						}
					}
					else
					{
						header('location:../settings/?error=909');
						exit();
					}
				}
				else
				{
					header('location:../settings/?error=912');
					exit();
				}
			}
			else
			{
				header('location:../settings/?error=901');
				exit();
			}
	    }
	    else
	    {
	    	header('location:../settings/?error=913');
			exit();
	    }
	}
	else
	{
		header('location:../settings/?error=901');
		exit();
	}
	
	