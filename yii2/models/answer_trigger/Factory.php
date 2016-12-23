<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */

namespace app\models\answer_trigger;

class Factory
{
    private static $trigger_classes = [
        ITrigger::TRIGGER_TYPE_ADD_OBJECT_TO_INVENTORY => TriggerAddObjectToInventory::class,
        ITrigger::TRIGGER_TYPE_FIGHT => TriggerFight::class,
        ITrigger::TRIGGER_TYPE_TREATMENT => TriggerTreatment::class,
    ];

    /**
     * @param $trigger_type
     * @param $trigger_id
     * @return ITrigger
     */
    public static function create($trigger_type, $trigger_id)
    {
        $class_name = self::$trigger_classes[$trigger_type];
        $Trigger = $class_name::get($trigger_id);
        return $Trigger;
    }
}