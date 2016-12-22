<?php
/**
 * @maintainer Aleksey Goncharenko <aleksey.goncharenko@corp.badoo.com>
 */

namespace app\controllers;
use yii as Yii;
use app\models\User;
use app\models\Login;
use app\models\exception\AbstractException;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login'  => ['post'],
                ],
            ]
        ];
    }

    public function actionLogin()
    {
        $Login = new Login();
        if ($Login->load(Yii::$app->request->post()) && $Login->login()) {
            return [
                'User' => Yii::$app->user->getIdentity(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            $Login->validate();
            return [
                $Login->getErrors()
            ];

        }
    }
}