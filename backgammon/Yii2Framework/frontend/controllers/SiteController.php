<?php
namespace frontend\controllers;
use common\config\components\API;
use Securimage;
use Yii;
use yii\db\Query;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\Users;
class SiteController extends Controller {
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionIndex() {
        return $this->redirect(['/games/index']);
    }
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/games/index']);
        }
        if (isset($_GET['id']))
        {
            $_SESSION['net'] = $_GET['id'];
        }

        $model_login = new LoginForm();
        $model_signup = new SignupForm();

//        echo(Yii::$app->request->post('LoginForm'))['username'];
//        exit;


        if ($model_login->load(Yii::$app->request->post()) && $model_login->login())
        {
            require __DIR__."/../../../../ip/ip.php";
            $connection = \Yii::$app->db;
            if(true)
            {
//                previous settings but important --start--
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
//                previous settings --end--
                $UserName = (Yii::$app->request->post('LoginForm'))['username'];
                $Password = (Yii::$app->request->post('LoginForm'))['password'];


                $a="select * from tmpuser where username=:user && password=:pass";
                $result=$connection->createCommand($a);
                $pass=md5($Password);
                $result->bindvalue(":user",$UserName);
                $result->bindvalue(":pass",$pass);
                $fetch = $result->queryOne();
                if (isset($fetch['id'])) {
                    if ($fetch['active'] == '0') {
                        return $this->redirect(['/games/login/?error=923']);
                    }
                }
                if(isset($fetch))
                {
                    $sql = "UPDATE `tmpuser` SET `ip`=:ip WHERE username=:user";
                    $result = $connection -> createCommand($sql);
                    $result->bindvalue(":user",$UserName);
                    $result->bindvalue(":ip",$user_ip);
                    $result->query();
                    setcookie("tmpname",$UserName,time()+14400,'/');
                    setcookie("tmppass",$Password,time()+14400,'/');
                    return $this->redirect(['../?tip=800']);
//                    header("location:../?tip=800".$_COOKIE["tmpname"]); //shoma vorod kardid
//                    exit();
                }
                else
                {
                    return $this->redirect(['/games/login/?error=903']);//hamchin usernami vojod nadarad
                }
            }
            else
            {
                return $this->redirect(['/games/login/?error=901']); //fild ha khali ast
            }

//          from previous settings --end--

        }

        return $this->render('login', [
                    'model_login' => $model_login,
                    'model_signup' => $model_signup,
        ]);
    }
    public function actionLogout() {
        if (Yii::$app->user->isGuest) {
            if ((isset($_COOKIE['tmpname'])) && (isset($_COOKIE['tmppass']))){
                $UserName = $_COOKIE['tmpname'];
                $Password1 = $_COOKIE['tmppass'];
                setcookie("tmpname", $UserName, time() - 86400 * 7, '/');
                setcookie("tmppass", $Password1, time() - 86400 * 7, '/');
            }
            return $this->redirect(['login']);
        }
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
    public function actionSignup() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/games/index']);
        }
        if (isset($_GET['id']))
        {
            $_SESSION['net'] = $_GET['id'];
        }
        require __DIR__.'/../../../../users/api/API.php';
        $model_login = new LoginForm();
        $model_signup = new SignupForm();

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

        $user_ip = $ip;
        if (null !==(Yii::$app->request->post('Password2'))) {
            $Password2 = Yii::$app->request->post('Password2');
            $UserName = (Yii::$app->request->post('SignupForm'))['username'];
            $Password = (Yii::$app->request->post('SignupForm'))['password'];
            $fullname = (Yii::$app->request->post('SignupForm'))['fullname'];
            if (!isset($_POST['checkbox'])) {
                return $this->redirect(['/login?error=927']);
            }
            if (((strlen($UserName) == mb_strlen($UserName, 'utf-8')) ? false : true) || ((strlen($Password) == mb_strlen($Password, 'utf-8')) ? false : true) || ((strlen($fullname) == mb_strlen($fullname, 'utf-8')) ? false : true)) {
                return $this->redirect(['/login?error=936']);
            }
            if (isset($_SESSION['net'])) {
                $id_user = $_SESSION['net'];
            }
            if($Password2 != $Password)
            {
                return $this->redirect(['/login?error=902']);
            }
        }

        if ($model_signup->load(Yii::$app->request->post()) && ($user = $model_signup->signup()) != null) {
            $UserName = (Yii::$app->request->post('SignupForm'))['username'];
            $Player = $UserName;
            $Password = (Yii::$app->request->post('SignupForm'))['password'];
            $Password1 = $Password;
            $fullname = (Yii::$app->request->post('SignupForm'))['fullname'];
            $RealName = $fullname;

            $Email = (Yii::$app->request->post('SignupForm'))['email'];

            if($Password2 != $Password)
            {
                return $this->redirect(['/login?error=902']);
            }
            else
            {
                $connection = \Yii::$app->db;
                $sql="select * from tmpuser where username=:user;";
                $result=$connection->createCommand($sql);
                $result->bindvalue(":user",$Player);
                $num = $result->queryOne();
                if($num)
                {
                    return $this->redirect(['/login?error=900']);//this username exist
                }
                $sql="select * from tmpuser where email=:email;";
                $result=$connection->createCommand($sql);
                $result->bindvalue(":email",$Email);
                $num = $result->execute();
                if($num>0)
                {
                    return $this->redirect(['/login?error=907']);//this email exist
                }
                else
                {
                    $Location = 'iran';
                    $Gender = 'Male';
                    $Avatar = 1;
                    $params = array("Command"  => "AccountsAdd",
                        "Player"   => $Player,
                        "RealName" => $RealName,
                        "PW"       => $Password,
                        "Location" => $Location,
                        "Email"    => $Email,
                        "Avatar"   => $Avatar,
                        "Gender"   => $Gender,
                        "Chat"     => "Yes",
                        "Note"     => "Account created via API",
                        "Level"    => "1");
                    $api = API::Poker_API($params);
                    echo $api -> Result;
                    if (isset($api -> Result) and $api -> Result == "Ok") {
                        $Password2 = md5($Password1);
                        $a="insert into tmpuser (username,fullname,password,email,active,month,year,day,ip) values (:player,:realname,:password,:email,1,:month,:year,:day,:ip) ";
                        $result=$connection->createCommand($a);
                        $result -> bindvalue(":player",$Player);
                        $result -> bindvalue(":realname",$RealName);
                        $result -> bindvalue(":password",$Password2);
                        $result -> bindvalue(":email",$Email);
                        $result -> bindvalue(":day",date("d"));
                        $result -> bindvalue(":month",date("m"));
                        $result -> bindvalue(":year",date("y"));
                        $result -> bindvalue(":ip",$user_ip);
                        $num=$result->query();
                        if($num)
                        {
                            if(isset($_SESSION['net']))
                            {
                                $sql="select * from tmpuser where username=:username;";
                                $result=$connection->createCommand($sql);
                                $result->bindvalue(":username",$Player);
                                $fetch = $result->queryOne();
                                $id_netuser = $fetch['id'];
                                $sql="select * from tmpuser where id=:id_user ;";
                                $result=$connection->createCommand($sql);
                                $result->bindvalue(":id_user",$id_user);
                                $fetch1 = $result->queryOne();
                                if (isset($fetch1['id'])) {
                                    if ($fetch1['netnum'] != '0') {
                                        $netnum = $fetch1['netnum'];
                                        echo $netnum=$netnum-1;
                                        $a="UPDATE `tmpuser` SET `netnum` = :net where id=:id_netuser ";
                                        $result=$connection->createCommand($a);
                                        $result->bindvalue(":id_netuser",$fetch1['id']);
                                        $result->bindvalue(":net",$netnum);
                                        $num=$result->query();
                                        $a="insert into networking (id_user,id_netuser) values (:id_user,:id_netuser) ";
                                        $result=$connection->createCommand($a);
                                        $result->bindvalue(":id_user",$id_user);
                                        $result->bindvalue(":id_netuser",$id_netuser);
                                        $num=$result->query();
                                    }
                                }
                                if (isset($_SESSION['net'])) {
                                    unset($_SESSION['net']);
                                }
                            }

                            setcookie("tmpname",$Player,time()+14400,'/');
                            setcookie("tmppass",$Password1,time()+14400,'/');
                            if (Yii::$app->getUser()->login($user)) {
                                return $this->redirect(['/games/index']);
                            }
                            return $this->redirect(['/games/index?tip=801']); //vorod va sabte nam anjam shod

                        }
                        else
                        {
                            return $this->redirect(['/signup?error=904']); //khataee pish amade
                        }
                    }
                    else
                    {
                        return $this->redirect(['/signup?error=904']);
                    }
                }
            }




        }
        return $this->render('login', [
            'model_login' => $model_login,
            'model_signup' => $model_signup,
        ]);
    }
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));
                return $this->redirect(['login']);
            }
            else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for the provided email address.'));
            }
        }
        return $this->render('request-password-reset', [
                    'model' => $model,
        ]);
    }
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        }
        catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'New password saved.'));
            return $this->redirect(['login']);
        }

        return $this->render('reset-password', [
                    'model' => $model,
        ]);
    }



}