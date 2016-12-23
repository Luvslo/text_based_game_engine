<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */
namespace app\models;

use Yii;

/**
 * This is the model class for table "character".
 *
 * @property integer $id
 * @property string $name
 * @property integer $health
 * @property integer $damage
 * @property integer $agility
 */
class Character extends ActiveRecord
{
    public static function tableName()
    {
        return 'character';
    }

    public function rules()
    {
        return [
            [['name', 'health', 'damage', 'agility'], 'required'],
            [['health', 'damage', 'agility'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'health' => 'Health',
            'damage' => 'Damage',
            'agility' => 'Agility',
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

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth(int $health)
    {
        return $this->health = $health;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setDamage($damage)
    {
        return $this->damage = $damage;
    }

    public function getAgility()
    {
        return $this->agility;
    }

    public function setAgility($agility)
    {
        return $this->agility = $agility;
    }

    /**
     * @return EnemyAttackType[]
     */
    public function getAttackTypes()
    {
        return EnemyAttackType::findAll(
            [
                'character_id' =>  $this->getId(),
            ]
        );
    }

    public function getPlusExperienceForWin()
    {
        return $this->plus_experience_for_win;
    }

    public function setPlusExperienceForWin($plus_experience_for_win)
    {
        return $this->plus_experience_for_win = $plus_experience_for_win;
    }
}
