<?php
    session_start();
    function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    /**
    * @param $str
    * @return bool
    */
    function is_english($str) {
        return (strlen($str) == mb_strlen($str,'utf-8'))? false : true;
    }

    /**
     * @param $str
     * @return bool
     */
    function is_bigString($str){
        return (strlen($str) > 5) ? false : true;
    }
    /**
     * @param $str
     * @return bool
     */
    function is_goodString($str){
        return (strlen($str) < 15) ? false : true;
    }

    $user_ip = getUserIP();


  if (isset($_COOKIE['tmpname']))
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
  require '../users/api/API.php';
  if((isset($_POST["Submit1"]))&&(isset($_POST["Password2"]))&&(isset($_POST["Player"]))&&(isset($_POST["RealName"]))&&(isset($_POST["Email"]))
    )
  {
    if (!isset($_POST['checkbox'])) {
      header("location:../login/?error=927");
      exit();
    }
    //big or short for inputs
      if (is_goodString($_POST["Password2"])) {
          header("location:../login/?error=937");
          exit();
      }
      if (is_bigString($_POST["Password2"])) {
          header("location:../login/?error=938");
          exit();
      }
      if (is_goodString($_POST["Player"])) {
          header("location:../login/?error=939");
          exit();
      }
      if (is_bigString($_POST["Player"])) {
          header("location:../login/?error=940");
          exit();
      }
      if (is_goodString($_POST["RealName"])) {
          header("location:../login/?error=941");
          exit();
      }
      if (is_bigString($_POST["RealName"])) {
          header("location:../login/?error=942");
          exit();
      }
    //this part spesify characters is english or not
    if ((is_english($_POST["Player"])) || (is_english($_POST["RealName"])) || (is_english($_POST["Password2"])) ){
        header("location:../login/?error=936");
        exit();
    }
    $email = xss($_POST["Email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header("location:../login/?error=924");
      exit();
    }
    if (isset($_SESSION['net'])){
      $id_user = $_SESSION['net'];
    }
    $Player = xss($_POST["Player"]);
    $RealName = xss($_POST["RealName"]);
    $Password1 = $_POST["Password1"];
    $Password2 = $_POST["Password2"];
    $Email = xss($_POST["Email"]);
    $Gender = 'Male';
    $Location = 'iran';
    if($Password2 != $Password1)
    {
      header("location:../login/?error=902"); // password is not match
      exit();
    }
    else
    {
      $sql="select * from tmpuser where username=:user;";
      $result=$connect->prepare($sql);
      $result->bindvalue(":user",$Player);
      $result->execute();
      echo $num=$result->fetchColumn();
      if($num>0)
      {
        header("location:../login/?error=900");  //this username is exist!
        exit();
      }
      $sql="select * from tmpuser where email=:email;";
      $result=$connect->prepare($sql);
      $result->bindvalue(":email",$Email);
      $result->execute();
      $num=$result->fetchColumn();
      if($num>0)
      {
        header("location:../login/?error=907");  //this email is exist!
        exit();
      }
      else
      {
        $Gender = 'Male';
        $Avatar = 1;
        $params = array("Command"  => "AccountsAdd",
                        "Player"   => $Player,
                        "RealName" => $RealName,
                        "PW"       => $Password1,
                        "Location" => $Location,
                        "Email"    => $Email,
                        "Avatar"   => $Avatar,
                        "Gender"   => $Gender,
                        "Chat"     => "Yes",
                        "Note"     => "Account created via API",
                        "Level"    => "1");
        $api = Poker_API($params);
        if (isset($api -> Result) and $api -> Result == "Ok") {
          $Password2 = md5($Password1);
          $a="insert into tmpuser (username,fullname,password,email,active,month,year,day,ip) values (:player,:realname,:password,:email,1,:month,:year,:day,:ip) ";
          $result=$connect->prepare($a);
          $result -> bindvalue(":player",$Player);
          $result -> bindvalue(":realname",$RealName);
          $result -> bindvalue(":password",$Password2);
          $result -> bindvalue(":email",$Email);
          $result -> bindvalue(":day",date("d"));
          $result -> bindvalue(":month",date("m"));
          $result -> bindvalue(":year",date("y"));
          $result -> bindvalue(":ip",$user_ip);
          $num=$result->execute();
          if($num)
          {
            if(isset($_SESSION['net']))
            {
              $sql="select * from tmpuser where username=:username;";
              $result=$connect->prepare($sql);
              $result->bindvalue(":username",$Player);
              $result->execute();
              $fetch=$result->fetch(PDO::FETCH_ASSOC);
              $id_netuser = $fetch['id'];
              $sql="select * from tmpuser where id=:id_user ;";
              $result=$connect->prepare($sql);
              $result->bindvalue(":id_user",$id_user);
              $result->execute();
              $fetch1=$result->fetch(PDO::FETCH_ASSOC);
              if (isset($fetch1['id'])) {
                if ($fetch1['netnum'] != '0') {
                  $netnum = $fetch1['netnum'];
                  echo $netnum=$netnum-1;
                  $a="UPDATE `tmpuser` SET `netnum` = :net where id=:id_netuser ";
                  $result=$connect->prepare($a);
                  $result->bindvalue(":id_netuser",$fetch1['id']);
                  $result->bindvalue(":net",$netnum);
                  $num=$result->execute();
                  $a="insert into networking (id_user,id_netuser) values (:id_user,:id_netuser) ";
                  $result=$connect->prepare($a);
                  $result->bindvalue(":id_user",$id_user);
                  $result->bindvalue(":id_netuser",$id_netuser);
                  $num=$result->execute();
                }
              }
              if (isset($_SESSION['net'])) {
                unset($_SESSION['net']);
              }
            }

            setcookie("tmpname",$Player,time()+14400,'/');
            setcookie("tmppass",$Password1,time()+14400,'/');
            header("location:../?tip=801"); //vorod va sabte nam anjam shod
            exit();
          }
          else
          {
            header("location:../login/?error=904"); //khataee pish amade
            exit();
          }
        }else{header("location:../login/?error=904");}
      }
    }
  }
  else
  {
    header("location:../login/?error=901"); //fild hal khali and
    exit();
  }
