<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	header("location:../login");
	exit();
	}
	include ("../../db/db.php");
	if(isset($_POST['btn']))
	{
		$matn=$_POST["matn"];
		$a="UPDATE `topic` SET `text` = :matn WHERE `topic`.`id` = 9;";
		$result=$connect->prepare($a);
		$result->bindvalue(":matn",$matn);
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
	if(isset($_POST['btn1']))
	{
		$matn=$_POST["matn"];
		$a="UPDATE `topic` SET `text` = :matn WHERE `topic`.`id` = 3;";
		$result=$connect->prepare($a);
		$result->bindvalue(":matn",$matn);
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
	if(isset($_POST['submit']))
	{
		if($_FILES["file"]["error"]<=0)
		{
			$name=$_FILES["file"]["name"];
			$type=$_FILES["file"]["type"];
			$size=$_FILES["file"]["size"];
			$tmp=$_FILES["file"]["tmp_name"];
			if(isset($tmp))
			{
				if($_FILES["file"]["error"]>0)
				{
					echo "Error1";
				}
				else
				{
					if(is_uploaded_file($tmp))
					{
						$ext=array("image/jpeg","image/jpg","image/png","image/gif");
						if(in_array($type,$ext))
						{
							$filename=md5($name.microtime()).substr($name,-5,5);
							$move=move_uploaded_file($tmp,"../../img/".$filename);
							if($move)
							{
								$sql="select * from topic where id=9;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 9;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../howtoplay/?tip=807');
									exit();
									echo "فایل شما با موفقیت آپلود شد";
								}
							}
							else
							{
								echo "فایل مورد نظر آپلود نشد";
							}
						}
						else
						{
							header('location:../howtoplay/?error=911');
							exit();
							echo "پسوند فایل شما مجاز نمیباشد";
						}
					}
					else
					{
						echo "http cant upload";
					}
				}
			}
		}
		else
		{
			header("location:../howtoplay/?error=910");
			exit();
		}
	}
		