<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionTestRedis()
    {
        try {
            $redis = Yii::$app->redis;
            $redis->set('test_key', 'Hello from Yii2');
            $value = $redis->get('test_key');
            echo "Test passed. Redis value: $value\n";
        } catch (\Exception $e) {
            echo "Error connecting to Redis: " . $e->getMessage() . "\n";
        }
    }


}
