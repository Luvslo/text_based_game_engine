<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question_answer".
 *
 * @property integer $question_id
 * @property integer $answer_id
 * @property integer $next_question_id
 */
class QuestionAnswer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'answer_id'], 'required'],
            [['question_id', 'answer_id', 'next_question_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'question_id' => 'Question ID',
            'answer_id' => 'Answer ID',
            'next_question_id' => 'Next Question ID',
        ];
    }

    /**
     * Get Answer Related to Question
     * @return Answer
     */
    public function getAnswer()
    {
        return Answer::get($this->getAnswerId());
    }

    public function getQuestionId()
    {
        return $this->question_id;
    }

    public function setQuestionId($question_id)
    {
        return $this->question_id = $question_id;
    }

    public function getAnswerId()
    {
        return $this->answer_id;
    }

    public function setAnswerId($answer_id)
    {
        return $this->answer_id = $answer_id;
    }

    public function getNextQuestionId()
    {
        return $this->next_question_id;
    }

    public function setNextQuestionId($next_question_id)
    {
        return $this->next_question_id = $next_question_id;
    }
}
