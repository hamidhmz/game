<?php
namespace common\config\components;
use Yii;
use yii\base\Component;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_SmtpTransport;
use \Swift_Attachment;
class EMAIL extends Component {
    //پس از ثبت نام کاربر
    public static function sendRegister($settings, $user) {
        /* @var $settings \common\models\Settings */
        /* @var $user \common\models\Users */
        $subject = 'ثبت نام';
        $message = static::replace($user, $settings->email_text_after_register, $subject);
        return static::send($settings, $user->email, $user->fullname, $subject, $message);
    }
    //بازیابی رمز عبور
    public static function sendResetPassword($settings, $user) {
        /* @var $settings \common\models\Settings */
        /* @var $user \common\models\Users */
        $subject = 'بازیابی رمز عبور';
        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
        $message = static::replace($user, "<a href=\"$resetLink\">$resetLink</a>", $subject);
        return static::send($settings, $user->email, $user->fullname, $subject, $message);
    }
    //
    private static function send($setting, $email_address, $name, $subject, $message) {
        /* @var $setting \common\models\Settings */
        $mail = Swift_SmtpTransport::newInstance($setting->email_server, $setting->email_port, 'tls');
        $mail->setUsername($setting->email_username);
        $mail->setPassword($setting->email_password);
        $mailer = Swift_Mailer::newInstance($mail);
        $swift_message = Swift_Message::newInstance($subject);
        $swift_message->setFrom($setting->email_username, $setting->site_title . ' | ' . Yii::t('base', 'Support'));
        $swift_message->setTo($email_address, $name);
        $swift_message->setBody($message, 'text/html', 'UTF-8');
        //$swift_message->attach(Swift_Attachment::fromPath('my-document.pdf'));
        return $mailer->send($swift_message);
    }
    private static function replace($user, $message, $subject) {
        /* @var $user \common\models\Users */
        $output = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . Yii::$app->charset . "\" />
        <title>$subject</title>
    </head>
    <body dir=\"rtl\">
        ";
        $output .= str_replace([
            '{username}', '{email}', '{fullname}',
        ], [
            $user->username, $user->email, $user->fullname,
        ], $message);
        $output .= "
    </body>
</html>";
        return $output;
    }
}