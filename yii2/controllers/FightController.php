<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\controllers;
use app\models\helper\fight\Attack;
use app\models\UserAttackType;
use yii as Yii;
use yii\helpers\Url;
use app\models\Fight;
use app\models\helper\fight\DamageModifier;
use app\models\helper\fight\ProbabilityModifier;
use app\models\http;

class FightController extends AbstractController
{
    public function actionView()
    {
        $fight_id = Yii::$app->getRequest()->getQueryParam('id');
        $answer_id = Yii::$app->getRequest()->getQueryParam('answer_id');

        $Fight = Fight::get($fight_id);

        $Character = $Fight->getCharacter();
        
        $user_attack_type_list = UserAttackType::findAll(
            [
                'character_id' => $Character->getId(),
            ]
        );

        $User = $this->getUser();

        $attack_type_list = [];

        foreach ($user_attack_type_list as $UserAttackType)
        {
            $attack_type_list[] = [
                'id' => $UserAttackType->getId(),
                'name' => $UserAttackType->getName(),
                'damage' => $UserAttackType->getDamage(),
                'real_damage' => DamageModifier::modifyUserDamage($User, $UserAttackType->getDamage()),
                'probability' => $UserAttackType->getProbability(),
                'real_probability' => ProbabilityModifier::modifyUserProbability($User, $UserAttackType->getProbability()),
                'url' => Url::to(['fight/attack', 'fight_id' => $Fight->getId(), 'answer_id' => $answer_id, 'id' => $UserAttackType->getId()]),
            ];
        }
        $Character->setHealth($Fight->getHealth());
        
        return [
            'Character' => $Character,
            'User' => $User,
            'Attack_types' => $attack_type_list,
        ];
    }

    public function actionAttack()
    {
        $fight_id = Yii::$app->getRequest()->getQueryParam('fight_id');
        $answer_id = Yii::$app->getRequest()->getQueryParam('answer_id');
        $attack_id = Yii::$app->getRequest()->getQueryParam('id');

        $UserAttackType = UserAttackType::get($attack_id);

        $User = $this->getUser();

        $Fight = Fight::get($fight_id);
        $Character = $Fight->getCharacter();

        $AttackHelper = new Attack($User, $UserAttackType, $Fight);
        $AttackHelper->processRound();

        $is_finished = $AttackHelper->isFinished();
        $Character->setHealth($Fight->getHealth());
        $result = [
            'Character' => $Character,
            'User' => $User,
            'EnemyAttackType' => $AttackHelper->getSelectedEnemyAttackType(),
            'did_user_hit_the_target' => $AttackHelper->getIsUserHit(),
            'is_fight_finished' => $is_finished,
            'finish_fight_url' => Url::to(['fight/result', 'answer_id' => $answer_id, 'id' => $fight_id]),
        ];

        if (!$is_finished) {
            $result['next_round_url'] = Url::to(['fight/view', 'answer_id' => $answer_id, 'id' => $fight_id]);
        }

        return $result;
    }

    public function actionResult()
    {
        $fight_id = Yii::$app->getRequest()->getQueryParam('id');
        $answer_id = Yii::$app->getRequest()->getQueryParam('answer_id');

        $User = $this->getUser();

        $Fight = Fight::get($fight_id);

        if ($Fight->getAnswerId() != $answer_id) {
            Yii::$app->response->setStatusCode(http\Codes::HTTP_NOT_FOUND);
            return [
                'errors' => 'Fight ID is not corresponding to Answer ID',
            ];
        }

        if ($Fight->isPlayerWinner()) {
            $next_question_id = $User->moveToNextQuestion($answer_id);
            $User->increaseExperience($Fight->getCharacter());
            $User->setExperience($User->getMaxHealth());
            $result = [
                'message' => 'Congratulations! You won!',
                'url' => Url::to(['question/view', 'id' => $next_question_id]),
            ];
        } elseif ($Fight->isEnemyWinner()) {
            $User->setHealth($User->getMaxHealth());
            $User->save();
            $result = [
                'message' => 'You failed! But this world is so gracious! You can try again or try to avoid the battle. We\'ll reestablish you health',
                'url' => Url::to(['question/view', 'id' => $User->getQuestionId()]),
            ];
        } else {
            $result = [
                'message' => 'You fled from the battlefield! Or it\'s just a tactic? Anyhow you can try to come back or try to avoid the battle!',
                'url' => Url::to(['question/view', 'id' => $User->getQuestionId()]),
            ];
        }

        return $result;
    }
}