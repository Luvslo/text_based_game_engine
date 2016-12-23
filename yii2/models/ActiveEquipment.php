<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models;

use app\models\exception\ValidationException;
use Yii;

/**
 * This is the model class for table "active_equipment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $weapon_object_id
 * @property integer $armor_object_id
 * @property integer $rune_object_id
 * @property integer $boots_object_id
 * @property integer $gloves_object_id
 * @property integer $helmet_object_id
 */
class ActiveEquipment extends ActiveRecord
{
    const TYPE_WEAPON = 'weapon';
    const TYPE_ARMOR = 'armor';
    const TYPE_RUNE = 'rune';
    const TYPE_BOOTS =  'boots';
    const TYPE_GLOVES = 'gloves';
    const TYPE_HELMET = 'helmet';

    public static function tableName()
    {
        return 'active_equipment';
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'weapon_object_id', 'armor_object_id', 'rune_object_id', 'boots_object_id', 'gloves_object_id', 'helmet_object_id'], 'integer'],
            [['user_id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'weapon_object_id' => 'Weapon Object ID',
            'armor_object_id' => 'Armor Object ID',
            'rune_object_id' => 'Rune Object ID',
            'boots_object_id' => 'Boots Object ID',
            'gloves_object_id' => 'Gloves Object ID',
            'helmet_object_id' => 'Helmet Object ID',
        ];
    }

    public function getObjects()
    {
        $result = [
            ActiveEquipment::TYPE_WEAPON => Object::get($this->getWeaponObjectId()),
            ActiveEquipment::TYPE_ARMOR  => Object::get($this->getArmorObjectId()),
            ActiveEquipment::TYPE_RUNE   => Object::get($this->getRuneObjectId()),
            ActiveEquipment::TYPE_BOOTS  => Object::get($this->getBootsObjectId()),
            ActiveEquipment::TYPE_GLOVES => Object::get($this->getGlovesObjectId()),
            ActiveEquipment::TYPE_HELMET => Object::get($this->getHelmetObjectId()),
        ];

        return $result;
    }

    /**
     * @return Object
     */
    public function getWeapon()
    {
        return Object::get($this->getWeaponObjectId());
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        return $this->user_id = $user_id;
    }

    public function getWeaponObjectId()
    {
        return $this->weapon_object_id;
    }

    public function setWeaponObjectId($weapon_object_id)
    {
        return $this->weapon_object_id = $weapon_object_id;
    }

    public function getArmorObjectId()
    {
        return $this->armor_object_id;
    }

    public function setArmorObjectId($armor_object_id)
    {
        return $this->armor_object_id = $armor_object_id;
    }

    public function getRuneObjectId()
    {
        return $this->rune_object_id;
    }

    public function setRuneObjectId($rune_object_id)
    {
        return $this->rune_object_id = $rune_object_id;
    }

    public function getBootsObjectId()
    {
        return $this->boots_object_id;
    }

    public function setBootsObjectId($boots_object_id)
    {
        return $this->boots_object_id = $boots_object_id;
    }

    public function getGlovesObjectId()
    {
        return $this->gloves_object_id;
    }

    public function setGlovesObjectId($gloves_object_id)
    {
        return $this->gloves_object_id = $gloves_object_id;
    }

    public function getHelmetObjectId()
    {
        return $this->helmet_object_id;
    }

    public function setHelmetObjectId($helmet_object_id)
    {
        return $this->helmet_object_id = $helmet_object_id;
    }
}
