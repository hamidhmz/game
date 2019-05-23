<?php
 
    if (!isset($_COOKIE['tmpname']))
    {
        header("location:../login");
        exit();
    }

require "../db/db.php";
require '../users/api/API.php';
$who = $_COOKIE['tmpname'];

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
						$move=move_uploaded_file($tmp,"../users/vendor/images/users/".$filename);
						if($move)
						{

							// function resize_image($file,$new_file) 
							// { 
							//     $new_width=35; 
							//     $new_height=35; 
							//     if(!extension_loaded('gd')&&!extension_loaded('gd2'))  { 
							//         die("GD is not installed!"); 
							//     } 
							//     list($width,$height,$type)=getimagesize($file); 
							//     switch($type) 
							//     { 
							//         case 1:$img=imagecreatefromgif($file);break; 
							//         case 2:$img=imagecreatefromjpeg($file);break; 
							//         case 3:$img=imagecreatefrompng($file);break; 
							//         default:die('Unsknown file!'); 
							//     } 
							//     $ratio=(float)$height/$width; 
							//     $new_ratio=(float)$new_height/$new_width; 
							//     if($new_ratio>$ratio)$new_height=round($new_width*$ratio); 
							//     else $new_width=round($new_height/$ratio); 
							//     $new_img=imagecreatetruecolor($new_width,$new_height); 
							//     if(($type==1)||($type==3)){ 
							//         imagealphablending($new_img,false); 
							//         imagesavealpha($new_img,true); 
							//         $tmp=imagecolorallocatealpha($new_img,255,255,255,127); 
							//         imagefilledrectangle($new_img,0,0,$new_width,$new_height,$tmp); 
							//     } 
							//     imagecopyresampled($new_img,$img,0,0,0,0,$new_width,$new_height,$width,$height); 
							//     switch($type) 
							//     { 
							//         case 1:imagegif($new_img,$new_file);break; 
							//         case 2:imagejpeg($new_img,$new_file);break; 
							//         case 3:imagepng($new_img,$new_file);break; 
							//         default:die('Failed resize image!'); 
							//     } 
							// }
							// resize_image("../users/vendor/images/users/".$filename,"../users/vendor/images/game/".$filename);


							
							$sql="select * from tmpuser where username=:user;";
						    $result=$connect->prepare($sql);
						    $result->bindvalue(":user",$who);
						    $result->execute();
						    $fetch=$result->fetch(PDO::FETCH_ASSOC);
						    if ($fetch['pic'] != "")
						    {
						    $lastfile = $fetch["pic"];
							unlink("../users/vendor/images/users/".$lastfile);
							// unlink("../users/vendor/images/game/".$lastfile);
						    }
							$a="UPDATE tmpuser SET pic=:pic where username=:who ";
							$result=$connect->prepare($a);
							$result->bindvalue(":pic",$filename);
							$result->bindvalue(":who",$who);
							$num=$result->execute();
							// $params = array("Command"  => "AccountsEdit",
							// 				"Player"   => $who,
							// 				"AvatarFile"=> 'C:\xampp\htdocs\game-poker\game-poker\users\vendor\images\game\\'.$filename,
							// 				"Avatar"   => '0',
							// 				);
							// $api = Poker_API($params);
							if ($num) 
							{
								header('location:../settings/?tip='.$width);
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
						header('location:../settings/?error=911');
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
		header("location:../settings/?error=910");
		exit();
	}
}

?>