<?php

namespace DeadlyCraft\channel;

use pocketmine\world\World;
use minecraft\entity\Entity;
use DeadlyCraft\entity\monster\Monster;

class DoungeonChannel extends Channel{

    private $dungeon = null;
    private $layer = null;
    protected $floor = 1;

    private $monsters = [];

    public function __construct(string $name, World $world, Dungeon $dungeon) {
        parent::__construct($name, $world);
        $this->dungeon = $dungeon;
    }

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

        $layer = $this->getLayer();
        if(!$layer->isClear()) {
            if($layer->checkClear()) {
                $layer->clear();
            }
        }else{
            foreach ($this->getDungeon()->getStage()->getBranch() as $i => $branch) {
                if($branch->isVectorInside($this->getOwnerPlayer()->getPosition())) {
                    $this->setNextLayer($i);
                }
            }
        }
    }

    public function getDungeon() :Dungeon{
        return $this->dungeon;
    }

    public function getLayer() :Layer{
        return $this->layer;
    }

    private function setLayer(Layer $layer) :void{
        $layer->joinLayer($channel);
        $this->layer = $layer;
    }

    private function setNextLayer(int $i) :void{
        $this->setLayer($this->getLayer()->getNextLayer()[$i]);
        $this->floor++;
    }
}