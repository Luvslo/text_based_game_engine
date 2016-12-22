<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\controllers;

use yii as Yii;
use app\models\Question;
use yii\helpers\Url;
use app\models\http;

class QuestionController extends AbstractController
{
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
    
    public function actionView()
    {
        $question_id = Yii::$app->getRequest()->getQueryParam('id');
        $User = $this->getUser();

        if ($User->getQuestionId() != $question_id) {
            Yii::$app->response->setStatusCode(http\Codes::HTTP_FORBIDDEN);
            $result = [
                'errors' => [
                    'Your player is trying to jump to wrong question',
                ]
            ];

            return $result;
        }

        $Question = Question::get($question_id);

        $answers = [];
        $answer_list = $Question->getAnswers();

        foreach ($answer_list as $Answer) {
            $answers[] = [
                'id' => $Answer->getId(),
                'message' => $Answer->getMessage(),
                'url' => [
                    'select' => Url::to(['answer/select', 'id' => $Answer->getId(), 'question_id' => $question_id]),
                ]
            ];
        }

        $result = [
            'question' => [
                'id' => $Question->getId(),
                'message' => $Question->getMessage(),
                'author' => $Question->getAuthor(),
                'answers' => $answers,
            ]
        ];

        return $result;
    }
}