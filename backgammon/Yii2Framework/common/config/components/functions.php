<?php
namespace common\config\components;
use Yii;
use yii\base\Component;
use common\config\components\jdf;
class functions extends Component {
    public static function currentuser() {
        return Yii::$app->user->identity;
    }
    public static function getdate() {
        return date('Y-m-d');
    }
    public static function getdatetime() {
        return date('Y-m-d') . ' ' . jdf::jdate('H:i:s');
    }
    public static function convertdatetime($in_datetime) {
        if ($in_datetime && $in_datetime != '0000-00-00 00:00:00') {
            $datetime = explode(' ', $in_datetime);
            return jdf::jdate('Y/m/d', strtotime($datetime[0])) . ' - ' . $datetime[1];
        }
        return '---';
    }
    public static function convertdate($in_date, $type = 0) {
        if ($type === 0) {
            if ($in_date) {
                if (strlen($in_date) > 10) {
                    $datetime = explode(' ', $in_date);
                    $in_date = $datetime[0];
                }
                if ($in_date == '0000-00-00') {
                    return null;
                }
                return jdf::jdate('Y/m/d', strtotime($in_date));
            }
            return null;
        }
        if ($type === 1) {
            if ($in_date && $in_date != '0000-00-00') {
                if (strlen($in_date) > 10) {
                    $datetime = explode(' ', $in_date);
                    $in_date = $datetime[0];
                }
                $jdate = explode('/', $in_date);
                if (count($jdate)) {
                    return implode('-', jdf::jalali_to_gregorian($jdate[0], $jdate[1], $jdate[2]));
                }
            }
            return null;
        }
    }
    public static function a($i) {
        $output = [$i - 2];
        if (($i / 2) >= 2) {
            $output = array_merge($output, self::a($i / 2));
        }
        return $output;
    }
    public static function datestring($in_date) {
        if ($in_date) {
            if (strlen($in_date) > 10) {
                $datetime = explode(' ', $in_date);
                $in_date = $datetime[0];
            }
            if ($in_date == '0000-00-00') {
                return null;
            }
            return jdf::jdate('l d F Y', strtotime($in_date));
        }
        return '0000-00-00';
    }
}