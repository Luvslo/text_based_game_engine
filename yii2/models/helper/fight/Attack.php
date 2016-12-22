<?php
/**
 * @maintainer Aleksey Goncharenko <aleksey.goncharenko@corp.badoo.com>
 */
namespace app\models\helper\fight;

use app\models\exception\AttackTypeNotFoundException;
use app\models\Fight;
use app\models\IFight;
use app\models\UserAttackType;
use app\models\EnemyAttackType;
use app\models\Character;
use app\models\User;

class Attack
{
    private $User;
    private $UserAttackType;
    private $Fight;

    /**
     * @var EnemyAttackType
     */
    private $SelectedEnemyAttackType;

    private $is_user_hit = false;

    public function __construct (User $User, UserAttackType $UserAttackType, Fight $Fight)
    {
        $this->User = $User;
        $this->UserAttackType = $UserAttackType;
        $this->Fight = $Fight;
    }

    public function processRound()
    {
        if ($this->isAlive($this->User)) {
            $this->userAttack();
            if ($this->isAlive($this->Fight)) {
                $this->characterAttack();
            }
        }
    }

    public function isFinished()
    {
        return !$this->isAlive($this->User) || !$this->isAlive($this->Fight);
    }

    public function getSelectedEnemyAttackType()
    {
        return $this->SelectedEnemyAttackType;
    }

    public function getIsUserHit()
    {
        return $this->is_user_hit;
    }

    private function userAttack()
    {
        $real_probability = ProbabilityModifier::modifyUserProbability($this->User, $this->UserAttackType->getProbability());
        $rand = mt_rand(1,100);
        if ($rand <= $real_probability) {
            $real_damage = DamageModifier::modifyUserDamage($this->User, $this->UserAttackType->getDamage());
            $this->decreaseHealth($this->Fight, $real_damage);
            $this->is_user_hit = true;
        }
    }

    private function characterAttack()
    {
        $user_attack_type_list = EnemyAttackType::findAll(['character_id' => $this->Fight->getCharacterId()]);
        $rand = mt_rand(1, 100);
        $real_probability = 0;

        foreach ($user_attack_type_list as $EnemyAttackType) {
            $real_probability += $EnemyAttackType->getProbability();
            if ($rand <= $real_probability) {
                $this->setSelectedEnemyAttackType($EnemyAttackType);
                break;
            }
        }

        $SelectedEnemyAttackType = $this->getSelectedEnemyAttackType();

        if (!$SelectedEnemyAttackType) {
            throw new AttackTypeNotFoundException(['Attack type not found']);
        }

        $real_damage = $this->getSelectedEnemyAttackType()->getDamage();
        $this->decreaseHealth($this->User, $real_damage);
    }

    private function decreaseHealth(IFight $Character, int $health_count)
    {
        $new_health_count = $Character->getHealth() - $health_count;
        if ($new_health_count < 0) {
            $new_health_count = 0;
        }
        $Character->setHealth($new_health_count);
        $Character->save();
    }

    private function isAlive(IFight $Character)
    {
        return (bool)($Character->getHealth() > 0);
    }

    private function setSelectedEnemyAttackType(EnemyAttackType $EnemyAttackType)
    {
        $this->SelectedEnemyAttackType = $EnemyAttackType;
    }
}