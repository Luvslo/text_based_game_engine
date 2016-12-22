<?php

namespace app\models;

use Yii;

class Question extends ActiveRecord
{
    /**
     * @var Answer[] Array of Answers related to the Question
     */
    private $answers = [];

       
    /**
     * Get character who asks the question
     * @return Character
     */
    public function getAuthor()
    {
        return Character::get($this->getCharacterId());
    }

    /**
     * Get Array of Answers related to the Question
     * @return Answer[]
     */
    public function getAnswers()
    {
        if (!$this->answers) {
            $QuestionAnswerRelations = QuestionAnswer::findAll($this->getId());

            foreach ($QuestionAnswerRelations as $OneQuestionAnswerRelation) {
                $Answer = $OneQuestionAnswerRelation->getAnswer();
                if ($Answer) {
                    $this->answers[] = $Answer;
                }
            }
        }
        return $this->answers;
    }

    public function getCharacterId()
    {
        return $this->character_id;
    }

    public function setCharacterId($character_id)
    {
        return $this->character_id = $character_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        return $this->message = $message;
    }

    public static function tableName()
    {
        return 'question';
    }

    public function rules()
    {
        return [
            [['character_id', 'message'], 'required'],
            [['character_id'], 'integer'],
            [['message'], 'string'],
        ];
    }
}
