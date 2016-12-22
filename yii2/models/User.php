<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IFight, IdentityInterface
{
    public $password_repeat;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username','name','password'],'filter','filter'=>'\yii\helpers\HtmlPurifier::process'],
            [['name', 'username', 'password'], 'required'],
            [['question_id', 'health', 'damage', 'agility', 'level', 'experience'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 64, 'min' => 5],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>'Passwords don\'t match'],
            [['username'], 'unique'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'question_id' => 'Question ID',
            'health' => 'Health',
            'damage' => 'Damage',
            'agility' => 'Agility',
            'level' => 'Level',
            'experience' => 'Experience',
        ];
    }

    public function fields()
    {
        return ['id', 'name', 'username', 'health', 'max_health', 'damage', 'agility', 'level', 'experience'];
    }
    public function extraFields()
    {
        return ['password', 'experience'];
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if ($this->isNewRecord) {
                $this->hashPassword();
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }else{
            return false;
        }
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * @return Inventory[]
     */
    public function getInventoryObjects()
    {
        return Inventory::findAll(['user_id' => $this->getId()]);
    }

    /**
     * @param $object_id
     * @return null|Inventory
     */
    public function getInventoryObject(int $object_id)
    {
        $Inventory = Inventory::findOne(['user_id' => $this->getId(), 'object_id' => $object_id]);
        if ($Inventory) {
            return Object::get($object_id);
        }

        return null;
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function moveToNextQuestion(int $answer_id)
    {
        $QuestionAnswer = QuestionAnswer::findOne(
            [
                'question_id' => $this->getQuestionId(),
                'answer_id' => $answer_id,
            ]
        );

        $next_question_id = $QuestionAnswer->getNextQuestionId();
        $this->setQuestionId($next_question_id);
        $this->save();

        return $next_question_id;
    }

    /**
     * Generates password hash from password and sets it to the model
     */
    public function hashPassword()
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
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

    public function getQuestionId()
    {
        return $this->question_id;
    }

    public function setQuestionId($question_id)
    {
        return $this->question_id = $question_id;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth(int $health)
    {
        return $this->health = $health;
    }

    public function getMaxHealth()
    {
        return $this->max_health;
    }

    public function setMaxHealth($max_health)
    {
        return $this->max_health = $max_health;
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

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        return $this->level = $level;
    }

    public function getExperience()
    {
        return $this->experience;
    }

    public function setExperience($experience)
    {
        return $this->experience = $experience;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public function increaseExperience(Character $Character)
    {
        $experience = $this->getExperience() + $Character->getPlusExperienceForWin();
        $level = floor($experience/2);
        $this->setExperience($experience);
        if ($level > $this->getLevel()) {
            $this->setLevel($level);
        }
        $this->save();
    }
}
