<?php 
	session_start();
    if (!isset($_SESSION['tmpadminname']))
    {
        header("location:../../login");
        exit();
    }//direction = 0 yani karbar
    require "../../../db/db.php";
    require "../../../notif/notif.php";
    require "../../../users/api/API.php";
    date_default_timezone_set('Asia/Tehran');
    $who = $_SESSION['id'];
    $sql="select * from tmpuser where id=:id;";
    $result=$connect->prepare($sql);
    $result->bindvalue(":id",$who);
    $result->execute();
    $fetch=$result->fetch(PDO::FETCH_ASSOC);
	if(isset($_POST['btn1']))
	{
		$caption = $_POST["caption"];
		$a="INSERT INTO `chat`( `id_user`, `text`, `date`, `status`, `direction`) VALUES (:id_user,:caption,:dat,1,1)";
		$result=$connect->prepare($a);
		$result->bindvalue(":id_user",$fetch['id']);
		$result->bindvalue(":caption",$caption);
		$result->bindvalue(":dat",date("Y/n/d-g:i:s a"));
		$num=$result->execute();
		if ($num)
		{
			echo "<b><font color=green>اطلاعات ثبت شد</font></b>";
		}
		else
		{
			echo "<b><font color=red>خطا در درج</font></b>";
		}
	}