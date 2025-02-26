<?php 

namespace app\components;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use app\components\SMSActivate;
use app\components\SMSGuruStatic;

class ApiJob extends BaseObject implements JobInterface
{
    public $requestId;
    public $userId;
    public $retryCount = 0;
    public $maxRetries = 5;

    protected $smsGuru;
    protected $apiKey;
    protected $credentials = null;

    public function __construct()
    {
        $this->credentials = require Yii::getAlias('@app/config') . '/credentials.php';                
        $this->apiKey = $this->credentials['sms_activate']['api_key'];
        if (!isset($this->apiKey)) {
            throw new \Exception("API KEY credentials not found");
        }
    }


    public function execute($queue)
    {
        $client = new Client(['timeout' => 120]); // Set a 2-minute timeout
        $url = SMSGuruStatic::getBalance($this->apiKey);
        $cancelUrl = '';

        try {
            // Step 1: Make the API request
            $response = $client->post($url, [
                'json' => ['request_id' => $this->requestId, 'user_id' => $this->userId]
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            // Step 2: Check if the response is valid
            if ($this->isValidResponse($responseData)) {
                // Step 3: If valid, save the result to the database
                Yii::$app->db->createCommand()->insert('external_responses', [
                    'request_id' => $this->requestId,
                    'user_id' => $this->userId,
                    'data' => json_encode($responseData),
                    'created_at' => time(),
                ])->execute();
                return;
            }
        } catch (RequestException $e) {
            Yii::error("API Request failed: " . $e->getMessage(), __METHOD__);
        }

        // // Step 4: Cancel the previous request if retrying
        // if ($this->retryCount > 0) {
        //     $client->post($cancelUrl, [
        //         'json' => ['request_id' => $this->requestId]
        //     ]);
        // }

        // // Step 5: Retry the job if max retries haven't been reached
        // if ($this->retryCount < $this->maxRetries) {
        //     Yii::$app->queue->delay(120)->push(new ApiJob([
        //         'requestId' => $this->requestId,
        //         'userId' => $this->userId,
        //         'retryCount' => $this->retryCount + 1,
        //     ]));
        // } else {
        //     Yii::error("Max retries reached for request_id: " . $this->requestId, __METHOD__);
        // }
    }

    private function isValidResponse($responseData)
    {
        return isset($responseData['status']) && $responseData['status'] === 'success';
    }
}
