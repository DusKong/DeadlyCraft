<?php

namespace DeadlyCraft\entity\monster;

use minecraft\Channel;

use pocketmine\entity\Attribute;

use minecraft\entity\monster\EntityMob;
use minecraft\entity\ai\EntityAIAttackOnCollide;
use minecraft\entity\ai\EntityAIMoveTowardsRestriction;
use minecraft\entity\ai\EntityAIWander;
use minecraft\entity\ai\EntityAIWatchClosest;
use minecraft\entity\ai\EntityAILookIdle;
use minecraft\entity\ai\EntityAINearestAttackableTarget;

class Zombie extends EntityMob implements Monster{

    public const NETWORK_ID = "minecraft:zombie";

    public $width = 0.6;
    public $height = 1.8;

    public function __construct(Channel $channel) {
        parent::__construct($channel);
        $this->tasks->addTask(2, new EntityAIAttackOnCollide($this, "minecraft\\entity\\EntityPlayer", 1.0, true));
        $this->tasks->addTask(5, new EntityAIMoveTowardsRestriction($this, 1.0));
        $this->tasks->addTask(7, new EntityAIWander($this, 1.0));
        $this->tasks->addTask(8, new EntityAIWatchClosest($this, "minecraft\\entity\\EntityPlayer", 8.0));
        $this->tasks->addTask(8, new EntityAILookIdle($this));
        $this->targetTasks->addTask(2, new EntityAINearestAttackableTarget($this, "minecraft\\entity\\EntityPlayer", true));
        $this->setSize(0.6, 1.95);
    }

    protected function applyEntityAttributes() : void{
        parent::applyEntityAttributes();
        $this->attributeMap->get(Attribute::MOVEMENT_SPEED)->setValue(0.23000000417232513);
        $this->attributeMap->get(Attribute::FOLLOW_RANGE)->setValue(35);
    }
}