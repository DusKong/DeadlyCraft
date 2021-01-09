<?php

namespace DeadlyCraft\doungeons;

use DeadlyCraft\dungeons\stage\Stage;
use DeadlyCraft\dungeons\stage\TestStage;

abstract class Dungeons {

    protected function setDifficulty(int $difficulty) :void{
        $this->difficulty = $difficulty;
    }

    public function getDifficulty() :int{
        return $this->difficulty;
    }

    public function getStage() :Stage{
        return new TestStage();
    }

    abstract public function getMaxFloor() :int;
}