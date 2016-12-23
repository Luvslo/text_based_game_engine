<?php
/**
 * @maintainer Aleksey Goncharenko <alexey.sentishev@gmail.com>
 */
namespace app\models;

interface IFight {
    public function setHealth(int $health);
    public function getHealth();
    public function save();
}