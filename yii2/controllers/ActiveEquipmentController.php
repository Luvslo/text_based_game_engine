<?php
/**
 * @maintainer Aleksey Goncharenko <aleksey.goncharenko@corp.badoo.com>
 */


namespace app\controllers;
use app\models\exception\AbstractException;
use yii as Yii;
use app\models\ActiveEquipment;
use app\models\User;
use app\models\http;

class ActiveEquipmentController extends AbstractController
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index'  => ['get'],
                'update'  => ['put'],
            ],
        ];

        return $behaviors;
    }

    public function actionView()
    {
        $user_id = Yii::$app->getRequest()->getQueryParam('id');
        $ActiveEquipment = ActiveEquipment::get($user_id);

        if (!$ActiveEquipment) {
            Yii::$app->response->setStatusCode(http\Codes::HTTP_NOT_FOUND);
            return [
                'errors' => [
                   'Active Equipment not found',
                ],
            ];
        }
        
        $active_equipment_objects = $ActiveEquipment->getObjects();
        return $active_equipment_objects;
    }

    /**
     * HTTP METHOD - PUT
     * @throws \app\models\exception\SaveException
     */
    public function actionUpdate()
    {
        $user_id = Yii::$app->getRequest()->getQueryParam('id');
        $model_data = Yii::$app->request->post();

        $ActiveEquipment = ActiveEquipment::get($user_id);

        if (!empty($model_data['ActiveEquipment'])) {
            $errors = [];
            foreach ($model_data['ActiveEquipment'] as $type => $object_id) {
                if (!User::get($user_id)->getInventoryObject($object_id)) {
                    $errors[] = 'Object ' . $type . ' not found in User Inventory';
                }
            }
            if ($errors) {
                Yii::$app->response->setStatusCode(http\Codes::HTTP_BAD_REQUEST);
                return ['errors' => $errors];
            }
        }

        try {
            $ActiveEquipment->saveState($model_data);
            $result = [
                'ActiveEquipment' => $ActiveEquipment,
            ];
        } catch (AbstractException $Exception) {
            Yii::$app->response->setStatusCode($Exception->getCode());
            $result = [
                'errors' => $Exception->getMessages(),
            ];
        }
        return $result;
    }
}