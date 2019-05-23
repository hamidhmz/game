<?php
    if (isset($_COOKIE['tmpname']))
    {
        header("location:../");
        exit();
    }
	require "../db/db.php";
  require "../ip/ip.php";
	if((isset($_POST["Submit2"]))&&(isset($_POST["UserName"]))&&(isset($_POST["Password3"])))
	{
		if (isset($_POST['ct_captcha'])=='') {
			header("location:../login/?error=921");
            exit();
		}
        require_once dirname(__FILE__) . '/securimage.php';
        $securimage = new Securimage();
        echo $captcha = @$_POST['ct_captcha'];
        echo '<br>';echo $securimage->check($captcha);exit;
        if ($securimage->check($captcha) == false) {
            $errors['captcha_error'] = 'Incorrect security code entered';
            header("location:../login/?error=925");
            exit();
        }
		// $FormCaptcha = new Captcha("FormCaptcha");
		// $FormCaptcha->UserInputID = "CaptchaCode";
		// if (!$FormCaptcha->IsSolved) {
		// 	$isHuman = $FormCaptcha->Validate();
		// 	$isPageValid = $isPageValid && $isHuman;
		// 	$form_page = $form_page . "&CaptchaCodeValid=" . $isHuman;
		// }
		// if (!$isHuman) {
		// // Captcha validation failed, show error message
		// 	header("location:../login/?error=921");
		// 	exit();
		// }

		// if(isset($_POST['g-recaptcha-response']) or 1==1 ){
  //         $captcha=$_POST['g-recaptcha-response'];
  //       }
  //       if(!$captcha or 1==1 ){
  //         echo '<h2>Please check the the captcha form.</h2>';
  //         header("location:../login/?error=921");
  //         exit;
  //       }
  //       $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=YOUR SECRET KEY&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
  //       if($response.success==false)
  //       {
  //         echo '<h2>You are spammer ! Get the @$%K out</h2>';
  //         header("location:../login/?error=922");
  //         exit();
  //       }
		$UserName = $_POST["UserName"];
		$Password = $_POST["Password3"];
		$a="select * from tmpuser where username=:user && password=:pass";
		$result=$connect->prepare($a);
		$pass=md5($Password);
		$result->bindvalue(":user",$UserName);
		$result->bindvalue(":pass",$pass);
		$result->execute();
		$num=$result->fetchColumn();
		$fetch = $result -> fetch(PDO::FETCH_ASSOC);
		if (isset($fetch['id'])) {
			if ($fetch['active'] == '0') {
				header("location:../?error=923");
				exit();
			}
		}
		if($num>0)
	    {
        $sql = "UPDATE `tmpuser` SET `ip`=:ip WHERE username=:user";
        $result = $connect -> prepare($sql);
        $result->bindvalue(":user",$UserName);
        $result->bindvalue(":ip",$user_ip);
    		$result->execute();
	      setcookie("tmpname",$UserName,time()+14400,'/');
        setcookie("tmppass",$Password,time()+14400,'/');
	      header("location:../?tip=800".$_COOKIE["tmpname"]); //shoma vorod kardid
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
