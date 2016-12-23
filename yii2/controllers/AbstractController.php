<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\controllers;

use Yii;
use app\models\User;

class AbstractController extends \yii\web\Controller
{
    /**
     * @return null|User
     */
    protected function getUser()
    {
        return Yii::$app->user->getIdentity();
    }
}