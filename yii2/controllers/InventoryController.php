<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\controllers;

use yii as Yii;
use app\models\User;

class InventoryController extends AbstractController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            'only' => ['index'],
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index'  => ['get'],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $User = $this->getUser();
        $inventory_objects =  $User->getInventoryObjects();

        $result = ['Inventory' => []];
        foreach ($inventory_objects as $InventoryObject) {
            $result['Inventory'][] = $InventoryObject->getObject();
        }

        return $result;
    }
}