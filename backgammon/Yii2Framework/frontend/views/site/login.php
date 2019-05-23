<?php
 
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
$connection = \Yii::$app->db;
/* @var $this yii\web\View */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $model \frontend\models\LoginForm */
$this->title = Yii::t('base', 'Login');
$this->registerCss("#success_message { border: 1px solid #000; width: 550px; text-align: left; padding: 10px 7px; background: #33ff33; color: #000; font-weight; bold; font-size: 1.2em; border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; }
      fieldset { width: 90%; }
      legend { font-size: 24px; }
      .note { font-size: 18px; }
      form label { display: block; font-weight: bold; }
      ");
$this->registerLinkTag(['//cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css']);

$this->registerCssFile(Url::to(['/themes/sixpairs/css/login.css']));
$this->registerCssFile(Url::to(['/themes/sixpairs/css/bootstrap.min.css']));
$this->registerCssFile(Url::to(['/themes/sixpairs/css/font-awesome.min.css']));
$this->registerJsFile(Url::to(['/themes/sixpairs/js/login.js']), ['depends' => yii\web\YiiAsset::className()]);
$this->registerJsFile(Url::to(['/themes/sixpairs/js/bootstrap.min.js']), ['depends' => yii\web\YiiAsset::className()]);
//$this->params['breadcrumbs'][] = $this->title;
require __DIR__.'/../../../../../notif/notif.php';

?>



<!-- Mixins-->
<!-- Pen Title-->

<div class="container" style="margin-top: 50px;font-family: tahoma">
    <div class="card">
        <h2 class="title">Login </h2>
<!--        <form method="post" action="/game-poker/backgammon/login" id="form1" >-->
        <?php $form_login = ActiveForm::begin(['id' => 'form1'] ); ?>
            <div class="input-container">
                <input name="LoginForm[username]" type="text" id="#{label}" required="required"/>

                <label for="#{label}">UserName</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input name="LoginForm[password]" type="password" id="#{label}" required="required"/>
                <label for="#{label}">Password</label>
                <div class="bar"></div>
            </div>
            <div class="input-container" id="mycaptcha">
                <?= $form_login->field($model_login, 'captcha')->widget(Captcha::className()) ?>

                <div class="bar"></div>
            </div>
            <div class="button-container">
                <input type="submit" name="Submit2" value="Login">
            </div>
            <div class="footer"><a href="sendpass">I forgot my password</a></div>
        <?php ActiveForm::end(); ?>
        <?php
            if ('' !== (Html::error($model_signup, 'email')))
            {
                echo "<script type='text/javascript'>";
                echo  "alert('" . Html::error($model_signup, 'email') . "');";
                echo "</script>";
            }
        ?>
        <?php
        if ('' !== (Html::error($model_signup, 'username')))
        {
            echo "<script type='text/javascript'>";
            echo  "alert('" . Html::error($model_signup, 'username') . "');";
            echo "</script>";
        }
        ?>
        <?php
        if ('' !== (Html::error($model_signup, 'fullname')))
        {
            echo "<script type='text/javascript'>";
            echo  "alert('" . Html::error($model_signup, 'fullname') . "');";
            echo "</script>";
        }
        ?>
        <?php
        if ('' !== (Html::error($model_signup, 'password')))
        {
            echo "<script type='text/javascript'>";
            echo  "alert('" . Html::error($model_signup, 'password') . "');";
            echo "</script>";
        }
        ?>
<!--        </form>-->
    </div>
    <div class="card alt">
        <div class="toggle"></div>
        <h2 class="title">New Registration
            <div class="close"></div>
        </h2>
<!--        <form method="post" action="sincheck.php">-->
        <?php $form_signup = ActiveForm::begin(['action' =>['signup']]); ?>
            <div class="input-container">
                <input name="SignupForm[username]" type="text" id="#{label}" required="required"/>
                <label for="UserName">UserName</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input name="SignupForm[fullname]" type="text" id="#{label}" required="required"/>
                <label for="Full">FullName</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input name="SignupForm[email]" type="text" id="#{label}" required="required"/>
                <label for="Email">Email</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input name="SignupForm[password]" type="password" id="#{label}" required="required"/>
                <label for="Password1">Password</label>
                <div class="bar"></div>
            </div>
            <div class="input-container" style="margin-bottom: 10px">
                <input name="Password2" type="password" id="Password2" required="required"/>
                <label for="Password2">Repeat Password</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input name="checkbox" type="checkbox" id="Terms" style="float: left;width: 30px" /><br>
                <label for="Terms" style="top: 33px;left: 55px;">Accept the <a href="" data-toggle = "modal" data-target = "#myModal">Terms and Policies</a></label>

            </div>
            <div class="button-container" style="clear: both;margin-top: 20px">
                <input type="submit" name="Submit1" value="Register">
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<!-- Modal -->
<div id = "myModal" class="modal fade in" data-keyboard="false" data-backdrop="static">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title" id = "myModalLabel">
                    قوانین و شرایط سایت ggpot.com
                </h4>
            </div>
            <div class = "modal-body">
                <strong><font color="red">توجه :</font></strong>
                <small>کاربر گرامی لطفا با دقت قوانین را مطالعه نمایید . ثبتنام شما به منزله قبول تمامی شرایط و قوانین می باشد .</small>
                <p style="margin: 30px 0"><small>
                    <?php
                    $sql="select * from topic where id=5";
                    $result=$connection->createCommand($sql);
                    $fetch = $result->queryOne();
                    if (isset($fetch['text']))
                   {
                        echo $fetch['text'];
                   }
                   ?>
                </p>
                </small>
                </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-primary" data-dismiss = "modal">
                    فهمیدم و موافقم
                </button>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<!-- CodePen-->
<div id="video"></div>
<?php
