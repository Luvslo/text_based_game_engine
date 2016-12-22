<?php
/**
 * @maintainer Aleksey Goncharenko <aleksey.goncharenko@corp.badoo.com>
 */

namespace app\models\helper\fight;

use app\models\ActiveEquipment;
use app\models\User;

class DamageModifier
{
    public static function modifyUserDamage(User $User, int $damage)
    {
        $ActiveEquipment = ActiveEquipment::get($User->getId());
        $Weapon = $ActiveEquipment->getWeapon();
        $Weapon->getDamage();
        $damage += $User->getDamage() + $Weapon->getDamage();

        return $damage;
    }
}