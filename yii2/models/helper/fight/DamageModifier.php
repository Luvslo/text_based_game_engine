<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models\helper\fight;

use app\models\ActiveEquipment;
use app\models\User;

class DamageModifier
{
    public static function modifyUserDamage(User $User, int $damage)
    {
        $damage += $User->getDamage();

        $ActiveEquipment = ActiveEquipment::get($User->getId());
        $Weapon = $ActiveEquipment->getWeapon();
        if ($Weapon) {
            $damage += $Weapon->getDamage();
        }
        return $damage;
    }
}