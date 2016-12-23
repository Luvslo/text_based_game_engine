<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models\exception;

class AbstractException extends \yii\base\Exception
{
    public function __construct (array $messages = [], $code = 0, \Exception $previous = null)
    {
        $message = json_encode($messages);
        parent::__construct($message, $code, $previous);
    }

    public function getMessages()
    {
        return json_decode($this->getMessage());
    }
}
