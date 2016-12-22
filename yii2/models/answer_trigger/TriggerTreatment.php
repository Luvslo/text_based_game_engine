<?php

namespace app\models\answer_trigger;

use app\models\exception\SaveException;
use Yii;
use app\models\User;
use app\models\Answer;

class TriggerTreatment extends AbstractTrigger
{
    public function process (User $User, Answer $Answer)
    {
        $health = $User->getHealth() + $this->getHealthAmount();
        $max_health = $User->getMaxHealth();
        if ($health > $max_health) {
            $health = $max_health;
        }
        $User->setHealth($health);
        $User->save();

        if ($User->getErrors()) {
            throw new SaveException($User->getErrors());
        }
        
        $TriggerResult = new TriggerResult();
        $TriggerResult->setType(ITrigger::TRIGGER_TYPE_TREATMENT);
        $TriggerResult->setMessage('Your health was increased');
        $TriggerResult->setData(['$User' => $User]);

        $this->setResult($TriggerResult);

        return true;
    }

    public function getHealthAmount()
    {
        return $this->health_amount;
    }

    public function setHealthAmount($health_amount)
    {
        return $this->health_amount = $health_amount;
    }

}