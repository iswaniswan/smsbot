<?php

namespace app\components;

use app\models\User;
use Yii;
use app\config\credentials;

class WebhookQuery
{    
    protected $chatId = null;
    protected $command = null;
    protected $keyword = null;
    protected $params = [];
    protected $message = 'Invalid parameter. Please try again.';
    protected $credentials = null;
    protected $API_KEY = null;

    // static command
    const START = '/start'; // testing command
    const QUERY = '/query'; // request api for new number
    const ADMIN = '/admin'; // request api for new number


    // static keyword
    const NEWNUMBER = 'newnumber'; // get new number
    const BALANCE = 'balance'; // get balance

    // parameters
    protected $username = null;
    protected $pin = null;
    protected $country = null;

    public function __construct($chatId, $text)
    {
        $this->credentials = require Yii::getAlias('@app/config') . '/credentials.php';
        $this->API_KEY = $this->credentials['sms_activate']['api_key'];
        if (!isset($this->API_KEY)) {
            throw new \Exception("Telegram credentials not found");
        }

        $this->chatId = $chatId;
        
        /** text format should be
         * 
         * /command keyword param1 param2 param3
         * 
         */

        /** command */
        $array = explode(' ', $text);
        if ($this->validateString(@$array[0]) == false) {
            return $this->getResult();
        }
        $this->command = $array[0];

        /** keyword */
        if ($this->validateString(@$array[1]) == false) {
            return $this->getResult();
        }
        $this->keyword = $array[1];

        /** username */
        if ($this->validateString(@$array[2]) == false) {
            return $this->getResult();
        }
        $this->username = $array[2];

        /** pin */
        if ($this->validateString(@$array[3]) == false) {
            return $this->getResult();
        }
        $this->pin = $array[3];

        /** country */
        if ($this->validateString(@$array[4]) == false) {
            return $this->getResult();
        }
        $this->country = $array[4];


        $this->run();
    }

    private function validateString($param=null)
    {
        if ($param == null || $param == '' || empty($param)) {
            return false;
        }
        return true;
    }

    private function run()
    {
        switch ($this->command) {
            case self::START:
                $this->message = 'Welcome to the number generator bot. Please use /query newnumber to get a new number.';
                break;
            case self::QUERY:
                if ($this->keyword == self::NEWNUMBER) {

                    if ($this->username == null || $this->username == '' || $this->isUsernameValid() == false) {
                        $this->message = self::QUERY .' is Invalid username. Please try again.';
                        break;
                    }

                    if ($this->pin == null || $this->pin == '' || $this->isPinValid() == false) {
                        $this->message = self::QUERY .' is Invalid pin. Please try again.';
                        break;
                    }

                    if ($this->country == null || $this->country == '' || $this->isCountryValid() == false) {
                        $this->message = self::QUERY .' is Invalid country. Please try again.';
                        break;
                    }
                }

                $this->message = 'success';
                break;

            case self::ADMIN:
                if ($this->keyword == self::BALANCE) {

                    if ($this->username == null || $this->username == '' || $this->isUsernameValid('admin') == false) {
                        $this->message = self::ADMIN .' is Invalid username. Please try again.';
                        break;
                    }

                    if ($this->pin == null || $this->pin == '' || $this->isPinValid() == false) {
                        $this->message = self::ADMIN .' is Invalid pin. Please try again.';
                        break;
                    }

                    if ($this->country == null || $this->country == '' || $this->isCountryValid() == false) {
                        $this->message = self::ADMIN .' is Invalid country. Please try again.';
                        break;
                    }
                

                    $smsActivate = new SMSActivate($this->API_KEY);
                    // $result = $smsActivate->getBalance();
                    $result = $smsActivate->getTopCountriesByService();
                    $this->message = $result;
                }

                break;
            default:
                return $this->getResult();
            break;
        }


    }

    protected function query()
    {

    }

    public function getResult()
    {
        return $this->message;
    }

    protected function isUsernameValid($type=null)
    {
        $query = null;

        if ($type == null) {
            $query = User::find()->where(['username' => $this->username])->one();
        }

        if ($type == 'admin') {
            $query = User::find()
                ->where(['username' => $this->username, 'user_role.id_role' => 1])
                ->join('INNER JOIN', 'user_role', 'user_role.id_user = user.id')
                ->one();
        }

        if ($query && $query != null) {
            return true;
        }

        return false;
    }

    protected function isPinValid($type=null)
    {
        $query = User::find()->where(['username' => $this->username, 'pin' => $this->pin])->one();
        if ($query) {
            return true;
        }

        return false;
    }

    protected function isCountryValid($type=null) 
    {
        $listCountryShort = ['ID', 'MY', 'SG', 'TH', 'VN'];
        if (in_array(strtoupper($this->country), $listCountryShort)) {
            return true;
        }

        $listCountry = ['INDONESIA', 'MALAYSIA', 'SINGAPORE', 'THAILAND', 'VIETNAM'];
        if (in_array(strtoupper($this->country), $listCountry)) {
            return true;
        }

        return false;
    }

}