<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\controllers;

use app\models\Question;
use yii\helpers\Url;
use Yii;

class GameController extends AbstractController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            'only' => ['intro'],
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'intro'  => ['get'],
            ],
        ];

        return $behaviors;
    }

    public function actionIntro()
    {
        $User = $this->getUser();
        $question_id = $User->getQuestionId();
        
        if (!$question_id) {
            $Question = Question::findOne(['start' => 1]);
            $question_id = $Question->getId();
        }
        $User->setQuestionId($question_id);
        $User->save();

        return [
            'intro' => $this->renderPartial('intro'),
            'url' => Url::to(['question/view', 'id' => $question_id]),
        ];
    }

    public function actionWelcome()
    {
        return [
            'Welcome to demo server!',
            'Read the API manual before Game: https://github.com/whiolf/text_based_game_engine'
        ];
    }
}