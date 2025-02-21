<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use App\components\Webhook;

class WebhookController extends \yii\web\Controller
{
    protected $credentials = null;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->credentials = require Yii::getAlias('@app/config') . '/credentials.php';
        if (!isset($this->credentials['telegram'])) {
            throw new \Exception("Telegram credentials not found");
        }
    }

    public function actionIndex()
    {
        // Disable Yii2 response formatting
        \Yii::$app->response->format = Response::FORMAT_RAW;

        // Retrieve the update sent by Telegram
        $update = json_decode(file_get_contents('php://input'), true);

        if ($update) {
            // Process the incoming update
            if (isset($update['message'])) {
                $chatId = $update['message']['chat']['id'];
                $text = $update['message']['text'];

                // Send a response back to the user
                $this->sendMessage($chatId, "You said: $text");
            }
        }

        // Send an HTTP 200 OK response (necessary for Telegram to accept the webhook)
        \Yii::$app->response->statusCode = 200;
        return 'OK'; // Send a simple response
    }

    private function sendMessage($chatId, $message)
    {
        $token = $this->credentials['telegram']['token'];
        $apiUrl = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=" . urlencode($message);
        file_get_contents($apiUrl);
    }

    public function actionReset()
    {
        $token = $this->credentials['telegram']['token'];
        $apiUrl = "https://api.telegram.org/bot$token/setWebhook?url=";
        file_get_contents($apiUrl);

        $token = $this->credentials['telegram']['token'];
        $apiUrl = "https://api.telegram.org/bot$token/setWebhook?url=https://smsbot.iswan.my.id/web/webhook";
        file_get_contents($apiUrl);

        die('success');
    }

}
