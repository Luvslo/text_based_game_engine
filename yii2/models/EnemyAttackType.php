<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */
namespace app\models;

use Yii;

/**
 * This is the model class for table "enemy_attack_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $character_id
 * @property string $class
 * @property integer $probability
 * @property integer $damage
 * @property string $message
 */
class EnemyAttackType extends ActiveRecord
{
    public static function tableName()
    {
        return 'enemy_attack_type';
    }

    public function rules()
    {
        return [
            [['name', 'character_id', 'class', 'probability', 'damage'], 'required'],
            [['character_id', 'probability', 'damage'], 'integer'],
            [['name', 'class'], 'string', 'max' => 50],
            [['message'], 'string', 'max' => 250],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'character_id' => 'Character ID',
            'class' => 'Class',
            'probability' => 'Probability',
            'damage' => 'Damage',
            'message' => 'Message',
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

    public function getCharacterId()
    {
        return $this->character_id;
    }

    public function setCharacterId($character_id)
    {
        return $this->character_id = $character_id;
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

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        return $this->message = $message;
    }

}
