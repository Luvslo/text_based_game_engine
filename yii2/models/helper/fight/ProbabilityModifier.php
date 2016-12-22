<?php
/**
 * @maintainer Aleksey Goncharenko <aleksey.goncharenko@corp.badoo.com>
 */

namespace app\models\helper\fight;

use app\models\ActiveEquipment;
use app\models\User;

class ProbabilityModifier
{
    public static function modifyUserProbability(User $User, int $probability)
    {
        $probability += round($User->getAgility() * 0.1);
        return $probability;
    }
}