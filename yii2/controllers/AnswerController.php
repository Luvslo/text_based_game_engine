<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\controllers;
use app\models\answer_trigger\ITrigger;
use yii as Yii;
use app\models\Answer;
use yii\helpers\Url;
use app\models\QuestionAnswer;
use app\models\exception\AbstractException;
use app\models\http;

class AnswerController extends AbstractController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
            'only' => ['select'],
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'select'  => ['get'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Processing user answer
     * @return array
     */
    public function actionSelect()
    {

        $answer_id = Yii::$app->getRequest()->getQueryParam('id');
        $question_id = Yii::$app->getRequest()->getQueryParam('question_id');

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

        $Answer = Answer::get($answer_id);

        $QuestionAnswer = QuestionAnswer::findOne(
            [
                'question_id' => $question_id,
                'answer_id' => $answer_id
            ]
        );

        if (!$QuestionAnswer) {
            $result = [
                'error' => [
                    'Answer id does not belong to the Question',
                ]
            ];
            Yii::$app->response->setStatusCode(http\Codes::HTTP_NOT_FOUND);
            return $result;
        }

        $Transaction = Yii::$app->db->beginTransaction();
        try {
            $TriggerResult = $Answer->processTrigger($User);

            $Fight = $Answer->getFight($User->getId());
            if (!$Fight) {
                $User->moveToNextQuestion($answer_id);
            }
            
            $Transaction->commit();
            
            $next_url = $TriggerResult->isType(ITrigger::TRIGGER_TYPE_FIGHT)
                ? Url::to(['fight/view', 'id' => $Fight->getId(), 'answer_id' => $answer_id])
                : Url::to(['question/view', 'id' => $User->getQuestionId()]);

            $result = [
                    'Answer' => $Answer,
                    'Trigger' => $TriggerResult->toArray(),
                    'next_url' => $next_url,
            ];
        } catch (AbstractException $Exception) {
            $Transaction->rollBack();
            Yii::$app->response->setStatusCode(http\Codes::HTTP_BAD_REQUEST);
            $result = [
                'errors' => $Exception->getMessages(),
            ];
        }

        return $result;
    }
}