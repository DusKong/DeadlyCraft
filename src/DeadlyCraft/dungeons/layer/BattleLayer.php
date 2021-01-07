<?php

namespace DeadlyCraft\dungeons\layer;

class BattleLayer extends Layer{

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