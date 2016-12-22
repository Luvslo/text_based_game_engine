<?php

namespace app\models\answer_trigger;

use app\models\ActiveRecord;
use app\models\User;
use app\models\Answer;

class AbstractTrigger extends ActiveRecord implements ITrigger
{
    /**
     * @var TriggerResult
     */
    protected $TriggerResult;

    protected function setResult(TriggerResult $result)
    {
        $this->TriggerResult = $result;
    }

    public function getResult()
    {
        return $this->TriggerResult;
    }

    public function process (User $User, Answer $Answer) {}
}