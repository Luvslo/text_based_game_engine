<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_attack_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $class
 * @property integer $probability
 * @property integer $damage
 * @property integer $character_id
 */
class UserAttackType extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_attack_type';
    }

    public function rules()
    {
        return [
            [['name', 'class', 'probability', 'damage', 'character_id'], 'required'],
            [['probability', 'damage', 'character_id'], 'integer'],
            [['name', 'class'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'class' => 'Class',
            'probability' => 'Probability',
            'damage' => 'Damage',
            'character_id' => 'Character ID',
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

    public function getCharacterId()
    {
        return $this->character_id;
    }

    public function setCharacterId($character_id)
    {
        return $this->character_id = $character_id;
    }
}
