<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models\answer_trigger;

use Yii;
use app\models\User;
use app\models\Answer;
use app\models\Fight;
use app\models\Character;
use app\models\exception\SaveException;
use app\models\http;

/**
 * Trigger which init fight.
 *
 * @property integer $id
 * @property integer $character_id
 * @property string $start_combat_message
 */
class TriggerFight extends AbstractTrigger implements ITrigger
{
    public static function tableName()
    {
        return 'trigger_fight';
    }

    public function rules()
    {
        return [
            [['character_id'], 'required'],
            [['character_id'], 'integer'],
            [['start_combat_message'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'character_id' => 'Character ID',
            'start_combat_message' => 'Start Combat Message',
        ];
    }

    public function process(User $User, Answer $Answer)
    {
        $Fight = Fight::findOne([
            'user_id' => $User->getId(),
            'answer_id' => $Answer->getId(),
        ]);

        if (!$Fight) {
            $Fight = new Fight();
            $Fight->setUserId($User->getId());
            $Fight->setCharacterId($this->getCharacterId());
            $Fight->setHealth($this->getCharacter()->getHealth());
            $Fight->setAnswerId($Answer->getId());
            $Fight->save();
        }

        $errors = $Fight->getErrors();
        if ($errors) {
            throw new SaveException($errors, http\Codes::HTTP_BAD_REQUEST);
        }

        $TriggerResult = new TriggerResult();
        $TriggerResult->setType(ITrigger::TRIGGER_TYPE_FIGHT);
        $TriggerResult->setMessage('New fight was initiated');
        $TriggerResult->setData(['Fight' => $Fight]);

        $this->setResult($TriggerResult);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getCharacterId()
    {
        return $this->character_id;
    }

    public function setCharacterId($character_id)
    {
        return $this->character_id = $character_id;
    }

    public function getStartCombatMessage()
    {
        return $this->start_combat_message;
    }

    public function setStartCombatMessage($start_combat_message)
    {
        return $this->start_combat_message = $start_combat_message;
    }

    /**
     * @return Character
     */
    public function getCharacter()
    {
        return Character::get($this->getCharacterId());
    }
}
