<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\components\Webhook;
use app\components\WebhookQuery;
use app\components\SMSGuruStatic;
use common\jobs\ExternalApiJob;
use console\controllers\QueueController;
use app\components\ApiJob;

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    
    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            \Yii::$app->controller->enableCsrfValidation = false;
        }
        
        return parent::beforeAction($action);
    }
    

    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_RAW;
        ob_end_clean();  // Clean any output buffer to prevent extra content

        // Retrieve the update sent by Telegram
        $update = json_decode(file_get_contents('php://input'), true);
        
        \Yii::info('Received update: ' . json_encode($update), __METHOD__);
        
        \Yii::$app->response->headers->add('Content-Type', 'text/plain');


        if ($update) {
            // Process the incoming update
            if (isset($update['message'])) {
                $chatId = $update['message']['chat']['id'];
                $text = $update['message']['text'];

                // query text
                $query = new WebhookQuery($chatId, $text);
                $result = $query->getResult();

                echo($result); die();

                // Send a response back to the user
                $this->sendMessage($chatId, $result);
            }
        }

        // Send an HTTP 200 OK response (necessary for Telegram to accept the webhook)
        \Yii::$app->response->statusCode = 200;
        return '';
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
        $result = file_get_contents($apiUrl);
        echo($result . '<br/>');

        $token = $this->credentials['telegram']['token'];
        $apiUrl = "https://api.telegram.org/bot$token/setWebhook?url=https://smsbot.iswan.my.id/web/webhook";
        $result = file_get_contents($apiUrl);
        echo($result . '<br/>');
    }
    
    public function actionUnset()
    {
        $token = $this->credentials['telegram']['token'];
        $apiUrl = "https://api.telegram.org/bot$token/setWebhook?url=";
        $result = file_get_contents($apiUrl);
        echo($result . '<br/>');
    }
    
    public function actionSet()
    {
        $token = $this->credentials['telegram']['token'];
        $apiUrl = "https://api.telegram.org/bot$token/setWebhook?url=https://smsbot.iswan.my.id/web/webhook/index";
        $result = file_get_contents($apiUrl);
        echo($result . '<br/>');
    }

    public function actionVerify()
    {
        $token = $this->credentials['telegram']['token'];
        $apiUrl = "https://api.telegram.org/bot$token/getWebhookInfo";
        $response = file_get_contents($apiUrl);
        echo $response;
    }

    public function actionTest()
    {
        $userId = Yii::$app->user->id;
        $requestId = uniqid('req_', true);  // Generate a unique request ID

        // Push the job to the Redis queue
        Yii::$app->queue->push(new ApiJob([
            'requestId' => $requestId,
            'userId' => $userId,
        ]));
        echo 'success';
        // Yii::$app->runAction('queue/test-request-data');
    }


}
