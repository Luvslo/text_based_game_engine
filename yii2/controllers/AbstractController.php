<?php
/**
 * @maintainer Aleksey Goncharenko <aleksey.goncharenko@corp.badoo.com>
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