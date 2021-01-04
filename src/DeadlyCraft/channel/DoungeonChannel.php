<?php

namespace DeadlyCraft\channel;

use minecraft\entity\Entity;
use DeadlyCraft\entity\monster\Monster;

class DoungeonChannel extends Channel{

    private $monsters = [];

    public function addEntity(Entity $entity) :void{
        parent::addEntity($entity);

        if($entity instanceof Monster) {
            $this->monsters[$entity->getEntityId()] = $entity;
        }
    }

    public function removeEntity(Entity $entity) :void{
        parent::removeEntity($entity);

        if($entity instanceof Monster) {
            unset($this->monsters[$entity->getEntityId()]);
        }
    }

    public function getMonsters() :array{
        return $this->monsters;
    }

    public function update() {
        parent::update();

        $floor = $this->floor;
        if(!$floor->isClear()) {
            if($floor->checkClear()) {
                $this->floor->clear();
            }
        }else{
            
        }
    }
}