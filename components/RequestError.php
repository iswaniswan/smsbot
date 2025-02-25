<?php

namespace app\components;

use app\models\User;
use Yii;
use \Exception;


class RequestError extends Exception
{
    private $responseCode;

    public function __construct($errorCode)
    {
        $this->responseCode = $errorCode;
//        если надо получать файл и строку в которой получена ошибка
//        $message = "Error in {$this->getFile()}, line: {$this->getLine()}: {$this->errorCodes[$errorCode]}";
        if (array_key_exists($errorCode, $this->errorCodes)) {
            $message = "{$this->errorCodes[$errorCode]}";
        } else {
            $message = $errorCode;
        }
        parent::__construct($message);
    }

    protected $errorCodes = array(
        'ACCESS_ACTIVATION' => 'Service successfully activated',
        'ACCESS_CANCEL'     => 'Activation canceled',
        'ACCESS_READY'      => 'Waiting for new SMS',
        'ACCESS_RETRY_GET'  => 'Phone number readiness confirmed',
        'ACCOUNT_INACTIVE'  => 'No free numbers available',
        'ALREADY_FINISH'    => 'Rental already completed',
        'ALREADY_CANCEL'    => 'Rental already canceled',
        'BAD_ACTION'        => 'Incorrect action (parameter action)',
        'BAD_SERVICE'       => 'Incorrect service name (parameter service)',
        'BAD_KEY'           => 'Invalid API access key',
        'BAD_STATUS'        => 'Attempt to set a non-existent status',
        'BANNED'            => 'Account blocked',
        'CANT_CANCEL'       => 'Cannot cancel rental (more than 20 minutes have passed)',
        'ERROR_SQL'         => 'One of the parameters has an invalid value',
        'NO_NUMBERS'        => 'No free numbers available to receive SMS from the current service',
        'NO_BALANCE'        => 'Balance depleted',
        'NO_YULA_MAIL'      => 'You must have more than 500 rubles in your account to purchase services from the Mail.ru and Mamba holding',
        'NO_CONNECTION'     => 'No connection to sms-activate servers',
        'NO_ID_RENT'        => 'Rental ID not provided',
        'NO_ACTIVATION'     => 'The specified activation ID does not exist',
        'STATUS_CANCEL'     => 'Activation/rental canceled',
        'STATUS_FINISH'     => 'Rental paid and completed',
        'STATUS_WAIT_CODE'  => 'Waiting for the first SMS',
        'STATUS_WAIT_RETRY' => 'Waiting for code clarification',
        'SQL_ERROR'         => 'One of the parameters has an invalid value',
        'INVALID_PHONE'     => 'The number was not rented by you (incorrect rental ID)',
        'INCORECT_STATUS'   => 'Missing or incorrectly specified status',
        'WRONG_SERVICE'     => 'The service does not support forwarding',
        'WRONG_SECURITY'    => 'Error when trying to transmit activation ID without forwarding, or with a completed/inactive activation'
    );
    

    public function getResponseCode()
    {
        return $this->errorCodes[$this->responseCode];
    }
}
