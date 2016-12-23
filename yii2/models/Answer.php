<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\answer_trigger;
use app\models\answer_trigger\TriggerFight;

class Answer extends ActiveRecord
{
    private $Fight;

    public static function tableName()
    {
        return 'answer';
    }

    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string'],
            [['trigger_id'], 'integer'],
            [['trigger_type'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
        ];
    }

    public function fields()
    {
        return ['id', 'message'];
    }
    public function extraFields()
    {
        return ['trigger_id', 'trigger_type'];
    }

    /**
     * @param \app\models\User $User
     * @return answer_trigger\TriggerResult
     */
    public function processTrigger(User $User)
    {
        $trigger_type = $this->getTriggerType();
        $trigger_id = $this->getTriggerId();
        
        if ($trigger_type && $trigger_id) {
            $Trigger = answer_trigger\Factory::create($trigger_type, $trigger_id);
            $Trigger->process($User, $this);
            $TriggerResult = $Trigger->getResult();
        } else {
            $TriggerResult = new answer_trigger\TriggerResult();
        }
        
        return $TriggerResult;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        return $this->message = $message;
    }

    public function getTriggerType()
    {
        return $this->trigger_type;
    }

    public function setTriggerType($trigger_type)
    {
        return $this->trigger_type = $trigger_type;
    }

    public function getTriggerId()
    {
        return $this->trigger_id;
    }

    public function setTriggerId($trigger_id)
    {
        return $this->trigger_id = $trigger_id;
    }

    /**
     * @return Fight
     */
    public function getFight($user_id)
    {
        if (!$this->Fight) {
            $this->Fight = Fight::findOne(['answer_id' => $this->getId(), 'user_id' => $user_id]);
        }
        return $this->Fight;
    }
}
