<?php

namespace app\components;
use Yii;


class WebhookQuery
{    
    protected $chatId = null;
    protected $command = null;
    protected $keyword = null;
    protected $params = [];
    protected $message = 'Invalid parameter. Please try again.';

    // static command
    const START = '/start'; // testing command
    const QUERY = '/query'; // request api for new number


    // static keyword
    const NEWNUMBER = 'newnumber'; // get new number

    // parameters
    protected $username = null;
    protected $pin = null;
    protected $country = null;

    public function __construct($chatId, $text)
    {
        $this->chatId = $chatId;
        
        /** text format should be
         * 
         * /command keyword param1 param2 param3
         * 
         */
        $array = explode(' ', $text);
        $this->command = $array[0];
        $this->keyword = $array[1];
        $this->params = array_slice($array, 2);


        $this->validateParams();
    }

    private function validateParams()
    {
        switch ($this->command) {
            case self::START:
                $this->message = 'Welcome to the number generator bot. Please use /query newnumber to get a new number.';
                break;
            case self::QUERY:
                if ($this->keyword == self::NEWNUMBER) {
                    $this->username = $this->params[0] ?? null;
                    $this->pin = $this->params[1] ?? null;
                    $this->country = $this->params[2] ?? null;

                    if ($this->username && $this->pin && $this->country) {
                        $this->message = 'Requesting new number for ' . $this->username . ' with pin ' . $this->pin . ' from ' . $this->country;
                    }
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

}