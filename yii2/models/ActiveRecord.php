<?php

namespace app\models;

use app\models\exception\SaveException;
use Yii;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @param array $model_data
     * @return static
     * @throws SaveException
     */
    public static function create(array $model_data)
    {
        /** @var ActiveRecord $Entity */
        $Entity = new static();
        $Entity->saveState($model_data);
        $Entity->refresh();
        return $Entity;
    }

    /**
     * Encapsulating some typical useful steps around \yii\db\ActiveRecord::save()
     *
     * @param array $model_data
     * @return ActiveRecord
     * @throws SaveException
     */
    public function saveState(array $model_data)
    {
        if ($this->load($model_data)) {
            $this->save();
        }
        $errors = $this->getErrors();
        if ($errors) {
            throw new SaveException($errors, http\Codes::HTTP_BAD_REQUEST);
        }

        return true;
    }

    public static function get($id)
    {
        $Entity = static::findOne($id);
        return $Entity;
    }
}