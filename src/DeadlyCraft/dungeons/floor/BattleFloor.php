<?php

namespace DeadlyCraft\dungeons\floor;

class BattleFloor extends Floor{

    private $entitiesData = [];

    public function __construct(array $entitiesData) {
        $this->entitiesData = $entitiesData;
    }

    public function createEntities() :void{

    }

    public function checkClear() :bool{
        return count($this->channel->getMonsters()) == 0;
    }
}