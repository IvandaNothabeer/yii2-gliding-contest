<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

class GetSmsController extends Controller
{
    
    public function actionIndex()
    {

        $gateway = Yii::$app->sms;

		$messages = $gateway->receiveSms();

        Return ExitCode::OK;

    }
}


?>