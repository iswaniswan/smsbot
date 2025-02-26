<?php 

namespace app\components;

use app\models\User;
use Yii;
use \InvalidArgumentException;
use \Exception;

class SMSGuruStatic
{

    public static $url = 'https://api.sms-activate.org/stubs/handler_api.php';

    public static function getBalance($apiKey='')
    {
        return self::$url .'?api_key=' . $apiKey . '&action=' . __FUNCTION__;
    }

}
