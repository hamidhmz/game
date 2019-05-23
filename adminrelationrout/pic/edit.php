	<?php
	session_start();
	if (!isset($_SESSION['tmpadminname']))
	{
	header("location:../login");
	exit();
	}
	include ("../../db/db.php");
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
								$sql="select * from topic where id=1;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 1;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit1']))
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
								$sql="select * from topic where id=3;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 3;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit2']))
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
								$sql="select * from topic where id=4;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 4;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit3']))
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
								$sql="select * from topic where id=5;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 5;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit4']))
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
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit5']))
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
								$sql="select * from topic where id=7;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 7;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit6']))
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
							$move=move_uploaded_file($tmp,"../../img/slider/".$filename);
							if($move)
							{
								$sql="select * from topic where id=11;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/slider/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 11;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit7']))
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
							$move=move_uploaded_file($tmp,"../../img/slider/".$filename);
							if($move)
							{
								$sql="select * from topic where id=12;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 12;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit8']))
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
							$move=move_uploaded_file($tmp,"../../img/slider/".$filename);
							if($move)
							{
								$sql="select * from topic where id=13;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/slider/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 13;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}
	if(isset($_POST['submit9']))
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
							$move=move_uploaded_file($tmp,"../../img/slider/".$filename);
							if($move)
							{
								$sql="select * from topic where id=14;";
							    $result=$connect->prepare($sql);
							    $result->execute();
							    $fetch=$result->fetch(PDO::FETCH_ASSOC);
							    if ($fetch['pic'] != "")
							    {
							    $lastfile = $fetch["pic"];
								unlink("../../img/slider/".$fetch['pic']);
							    }
								$a="UPDATE `topic` SET `pic` = :pic WHERE `topic`.`id` = 14;";
								$result=$connect->prepare($a);
								$result->bindvalue(":pic",$filename);
								$num=$result->execute();
								if ($num) 
								{
									header('location:../pic/?tip=807');
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
							header('location:../pic/?error=911');
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
			header("location:../pic/?error=910");
			exit();
		}
	}