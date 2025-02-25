<?php

namespace app\components;

use app\models\User;
use Yii;

class ErrorCodes extends RequestError
{
    public function checkExist($errorCode)
    {
        return array_key_exists($errorCode, $this->errorCodes);
    }
}
