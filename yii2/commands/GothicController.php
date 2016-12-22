<?php
namespace app\commands;

use yii\console\Controller;
use yii as Yii;

class GothicController extends Controller
{
    public function actionIndex()
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }

        $user = $session->get('user');

    }
}