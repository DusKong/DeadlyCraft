<?php

namespace DeadlyCraft\entity;

use minecraft\entity\EntityFactory as Factory;

class EntityFactory{

    public function __construct() {
        $factory = Factory::getInstance();

        $factory->registerCustomEntity("pocketmine:crystal");
        $factory->registerCustomEntity("pocketmine:metalic_zombie");
    }
}