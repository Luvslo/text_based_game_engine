<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */
namespace app\models;

use Yii;

/**
 * This is the model class for table "fight".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $character_id
 * @property string $health
 * @property string $loose_attacks
 */
class Fight extends ActiveRecord implements IFight
{
    public static function tableName()
    {
        return 'fight';
    }

    public function rules()
    {
        return [
            [['user_id', 'character_id', 'health'], 'required'],
            [['user_id', 'character_id', 'health', 'answer_id'], 'integer'],
            [['loose_attacks'], 'string', 'max' => 45],
            [['user_id', 'answer_id'], 'unique', 'targetAttribute' => ['user_id', 'answer_id'], 'message' => 'Fighting was already started'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'character_id' => 'Character ID',
            'health' => 'Health',
            'loose_attacks' => 'Loose Attacks',
            'answer_id' => 'Answer ID',
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

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        return $this->user_id = $user_id;
    }

    public function getCharacterId()
    {
        return $this->character_id;
    }

    public function setCharacterId($character_id)
    {
        return $this->character_id = $character_id;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth(int $health)
    {
        return $this->health = $health;
    }

    public function getLooseAttacks()
    {
        return $this->loose_attacks;
    }

    public function setLooseAttacks($loose_attacks)
    {
        return $this->loose_attacks = $loose_attacks;
    }

    public function getAnswerId()
    {
        return $this->answer_id;
    }

    public function setAnswerId($answer_id)
    {
        return $this->answer_id = $answer_id;
    }

    /**
     * @return Character
     */
    public function getCharacter()
    {
        return Character::get($this->getCharacterId());
    }


    public function isPlayerWinner()
    {
        return ($this->getHealth() <= 0);
    }

    public function isEnemyWinner()
    {
        $User = User::get($this->getUserId());
        return ($User->getHealth() <= 0);
    }
}
