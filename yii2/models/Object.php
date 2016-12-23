<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "object".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $damage
 */
class Object extends ActiveRecord
{
    public static function tableName()
    {
        return 'object';
    }

    public function rules()
    {
        return [
            [['damage'], 'integer'],
            [['type', 'name'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'damage' => 'Damage',
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        return $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setDamage($damage)
    {
        return $this->damage = $damage;
    }

}
