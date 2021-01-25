<?php

namespace app\jobs;

/**
 * Class ReadIgcJob.
 */
class ReadIgcJob extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
    	\Yii::$app->runAction('read-igc');
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}
