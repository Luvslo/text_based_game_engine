<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enemy_damage_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $class
 * @property integer $probability
 * @property integer $damage
 * @property integer $kick_type_id
 */
class EnemyDamageType extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enemy_damage_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'class', 'probability', 'damage', 'kick_type_id'], 'required'],
            [['probability', 'damage', 'kick_type_id'], 'integer'],
            [['name', 'class'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'class' => 'Class',
            'probability' => 'Probability',
            'damage' => 'Damage',
            'kick_type_id' => 'Kick Type ID',
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        return $this->class = $class;
    }

    public function getProbability()
    {
        return $this->probability;
    }

    public function setProbability($probability)
    {
        return $this->probability = $probability;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setDamage($damage)
    {
        return $this->damage = $damage;
    }

    public function getKickTypeId()
    {
        return $this->kick_type_id;
    }

    public function setKickTypeId($kick_type_id)
    {
        return $this->kick_type_id = $kick_type_id;
    }

}
