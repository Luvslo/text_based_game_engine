<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models\answer_trigger;

use app\models\User;
use app\models\Answer;
interface ITrigger {
    const TRIGGER_TYPE_ADD_OBJECT_TO_INVENTORY = 'AddObjectToInventory';
    const TRIGGER_TYPE_FIGHT = 'Fight';
    const TRIGGER_TYPE_TREATMENT = 'Treatment';

    public function process (User $User, Answer $Answer);
    public function getResult();
}