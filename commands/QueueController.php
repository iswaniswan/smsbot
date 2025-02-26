<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\queue\cli\Queue;

class QueueController extends Controller
{
    public function actionListen()
    {
        // Process the jobs in the Redis queue using the queue component
        echo "Starting the queue worker...\n";
        Yii::$app->queue->run(); // This will process jobs from the Redis queue
    }

    public function actionTest()
    {
        $userId = Yii::$app->user->id;  // Get user ID
        $requestId = uniqid('req_', true); // Generate a unique request ID

        // Add the job to the queue
        Yii::$app->queue->push(new \common\jobs\ExternalApiJob([
            'requestId' => $requestId,
            'userId' => $userId,
            'retryCount' => 0,
        ]));

        return ['status' => 'processing', 'request_id' => $requestId];
    }
}
