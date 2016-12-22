<?php
namespace app\models;

interface IFight {
    public function setHealth(int $health);
    public function getHealth();
    public function save();
}