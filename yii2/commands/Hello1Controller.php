<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Hello1Controller extends Controller
{
    private  $question = [
        ['id' => 1, 'text' => 'Вы проснулись в своей комнате. Напротив вас стоит мама. Спрашивает: ты проснулся?'],
        ['id' => 2, 'text' => 'Молодец! Жду тебя на кухне!'],
        ['id' => 3, 'text' => 'Вы сладко потянулись и огляделись. Что бы вам хотелось сделать?'],
        ['id' => 4, 'text' => 'Коту не понравилось ваше вмешательство! Приготовтесь к бою!'],
    ];

    private $answer = [
        ['id' => 1, 'text' => 'Да!', 'question_id' => 1, 'next_question_id' => 2],
        ['id' => 2, 'text' => 'Нет!', 'question_id' => 1, 'next_question_id' => 2],
        ['id' => 3, 'text' => 'Уже иду!', 'question_id' => 2, 'next_question_id' => 3],

        ['id' => 4, 'text' => 'Подойти к столу', 'question_id' => 3, 'next_question_id' => 0],
        ['id' => 5, 'text' => 'Ущипнуть кота', 'question_id' => 3, 'next_question_id' => 4],

        ['id' => 5, 'text' => 'Ударить по голове (20% шанс попасть, высокий урон)', 'question_id' => 4, 'next_question_id' => 0],
        ['id' => 6, 'text' => 'Ударить в пузо (60% шанс попасть, средний урон)', 'question_id' => 4, 'next_question_id' => 0],
        ['id' => 7, 'text' => 'Ударить по лапе (30% шанс попасть, низкий урон, понижает атаку дракона)', 'question_id' => 4, 'next_question_id' => 0],
        ['id' => 8, 'text' => 'Ударить по хвосту (40% шанс попасть, низкий урон, можно отрубить хвост и вызвать кровотечение)', 'question_id' => 4, 'next_question_id' => 0],
        ['id' => 9, 'text' => 'Провести обманный манёвр (увернуться от следующего удара, +20% к шансу попадания на следующий удар)', 'question_id' => 4, 'next_question_id' => 0],

    ];

    public function actionIndex($message = 'hello world')
    {
        $current_question_id = 0;
        $current_answer_id = 0;
        $start_question = $this->getInitialQuestion($current_question_id);
        while (true) {
            $question = $current_answer_id ? $this->getNextQuestion($current_answer_id) : $start_question;

            if (!$question) {
                $this->stdout('Game over!');
                return 0;
            }

            $answers = $this->getAnswers($question['id']);

            $this->stdout($question['text']);

            foreach ($answers as $answer) {
                $this->stdout($answer['id'] . ':' . $answer['text']);
            }
            $current_answer_id = $this->prompt('Your choise: ');
            $this->stdout('');
        }




    }

    public function getInitialQuestion($current_question_id = null)
    {
        foreach ($this->question as $question) {
            if ($question['id'] == ($current_question_id ?: null)) {
                return $question;
            }
        }
        return null;
    }

    public function getNextQuestion($current_answer_id)
    {
        $answer = $this->getAnswer($current_answer_id);
        foreach ($this->question as $question) {
            if ($question['id'] == $answer['next_question_id']) {
                return $question;
            }
        }
        return null;
    }

    public function getAnswer($answer_id)
    {
        foreach ($this->answer as $answer) {
            if ($answer['id'] == $answer_id) {
                return $answer;
            }
        }
        return null;
    }

    public function getAnswers($question_id)
    {
        $answers = [];
        foreach ($this->answer as $answer) {
            if ($answer['question_id'] == $question_id) {
                $answers[] = $answer;
            }
        }
        return $answers;
    }

    public function stdout($text) {
        $text .= PHP_EOL;
        return parent::stdout($text);
    }
}
