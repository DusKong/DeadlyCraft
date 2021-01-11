<?php

namespace DeadlyCraft\doungeons;

use pocketmine\player\Player;
use DeadlyCraft\dungeons\stage\Stage;
use DeadlyCraft\dungeons\stage\TestStage;
use DeadlyCraft\channel\DungeonChannel;

abstract class Dungeons {

    protected $difficulty;

    public function getChannelClass() :string{
        return DungeonChannel::class;
    }

    public function isJoinPossible(Player $player) :bool{
        return true;
    }

    protected function setDifficulty(int $difficulty) :void{
        $this->difficulty = $difficulty;
    }

    public function getDifficulty() :int{
        return $this->difficulty;
    }

    public function getStage() :Stage{
        return new TestStage();
    }
}