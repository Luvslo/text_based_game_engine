<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\controllers;

use yii as Yii;
use app\models\User;
use app\models\ActiveEquipment;
use app\models\exception\AbstractException;
use app\models\http;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            'only' => ['view'],
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'login'  => ['post'],
                'create'  => ['post'],
            ],
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $Transaction = Yii::$app->db->beginTransaction();
        try {
            $User = User::create(Yii::$app->request->post());
            ActiveEquipment::create(
                [
                    'ActiveEquipment' =>
                        [
                            'user_id' => $User->getId()
                        ]
                ]
            );
            $Transaction->commit();
            $result = ['User' => $User];

        } catch (AbstractException $Exception) {
            $Transaction->rollBack();
            Yii::$app->response->setStatusCode($Exception->getCode());
            $result = [
                'errors' => $Exception->getMessages(),
            ];
        }

        return $result;
    }

    public function actionView()
    {
        $user_id = Yii::$app->getRequest()->getQueryParam('id');
        if (Yii::$app->user->getId() != $user_id)
        {
            Yii::$app->response->setStatusCode(http\Codes::HTTP_FORBIDDEN);
            return [
                'errors' => ['Forbidden'],
            ];
        }
        return [
            'User' => User::get($user_id),
        ];
    }
}