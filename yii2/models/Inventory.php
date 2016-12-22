<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory".
 *
 * @property integer $id
 * @property integer $object_id
 * @property integer $user_id
 */
class Inventory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'user_id'], 'required'],
            [['object_id', 'user_id'], 'unique', 'message'=>'This object already belongs to User'],
            [['object_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_id' => 'Object ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return Object
     */
    public function getObject()
    {
        return Object::get($this->getObjectId());
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

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        return $this->user_id = $user_id;
    }
}
