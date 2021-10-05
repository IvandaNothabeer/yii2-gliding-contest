<?php

namespace app\jobs;

/**
* Class GetmailJob.
*/
class GetSmsJob extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
	/**
	* @inheritdoc
	*/
	public function execute($queue)
	{
		\Yii::$app->runAction('get-sms');
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