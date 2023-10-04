<?php

namespace app\commands;

use yii\console\Controller;

class ProcessController extends Controller
{
    public function actionQueueResults()
    {
        $iterations = 0;

        while (true) {
            $job = __DIR__ . '/../runtime/queue.job';

            if (file_exists($job)) {
                $content = file_get_contents($job);
                echo $content . "\n";
                unlink($job);
            }

            $iterations++;
            echo "iterations: " . $iterations . "\n";
            sleep(2);
        }
    }
}
