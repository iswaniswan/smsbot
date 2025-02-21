<?php

namespace app\components;
use Yii;


class Webhook 
{
    protected $bot_username = null;
    protected $token = null;
    protected $url = "https://api.telegram.org/bot";
    protected $api_url = null;
    
    public function __construct()
    {
        $credentials = require Yii::getAlias('@app/config') . '/credentials.php';

        if (!isset($credentials['telegram'])) {
            throw new \Exception("Telegram credentials not found");
        }

        $this->bot_username = $credentials['telegram']['bot_username'];
        $this->token = $credentials['telegram']['token'];
        $this->api_url = $this->url . $this->token. "/";
    }

    // Fungsi untuk mengirim pesan
    public function sendMessage($chatId, $message) {
        $url = $this->api_url . "sendMessage?chat_id=$chatId&text=" . urlencode($message);
        file_get_contents($url);
    }

    public function updateResponse()
    {
        // Mendapatkan data update dari Telegram
        $update = json_decode(file_get_contents('php://input'), true);
    
        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];
    
            // Kirim balasan
            if ($text == "/start") {
                $this->sendMessage($chatId, "Selamat datang di bot saya!");
            } else {
                $this->sendMessage($chatId, "Pesan: $text");
            }
        }
    }

    public function test()
    {
        echo "init success<br/>
            bot_username: $this->bot_username<br/>
            token: $this->token<br/>
            api_url: $this->api_url<br/>
        ";
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getBotUsername()
    {
        return $this->bot_username;
    }

    public function getApiUrl()
    {
        return $this->api_url;
    }

}