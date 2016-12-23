<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models\answer_trigger;

class TriggerResult
{
    private $type;
    private $message;
    private $data;

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function isType($type)
    {
        return $this->type == $type;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}