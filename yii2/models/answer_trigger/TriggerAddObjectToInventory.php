<?php

namespace app\models\answer_trigger;

use app\models\exception\SaveException;
use app\models\Inventory;
use Yii;
use app\models\User;
use app\models\Answer;
use app\models\Object;

class TriggerAddObjectToInventory extends AbstractTrigger
{
    

    public static function tableName()
    {
        return 'trigger_add_object_to_inventory';
    }

    public function rules()
    {
        return [
            [['object_id'], 'required'],
            [['object_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_id' => 'Object ID',
        ];
    }

    public function process(User $User, Answer $Answer)
    {
        $Inventory = new Inventory();
        $Inventory->setUserId($User->getId());
        $Inventory->setObjectId($this->getObjectId());

        if ($Inventory->save()) {
            $TriggerResult = new TriggerResult();
            $TriggerResult->setType(ITrigger::TRIGGER_TYPE_ADD_OBJECT_TO_INVENTORY);
            $TriggerResult->setMessage('Object was added to Inventory');
            $TriggerResult->setData(['Object' => Object::get($this->getObjectId())]);

            $this->setResult($TriggerResult);
            return true;
        }
        throw new SaveException($Inventory->getErrors());
    }



    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getObjectId()
    {
        return $this->object_id;
    }

    public function setObjectId($object_id)
    {
        return $this->object_id = $object_id;
    }
}
