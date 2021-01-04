<?php

namespace DeadlyCraft\doungeons;

use DeadlyCraft\dungeons\stage\Stage;
use DeadlyCraft\dungeons\stage\TestStage;

abstract class Dungeons {

    public function getStage() :Stage{
        return new TestStage();
    }

    abstract public function getMaxFloor() :int;
}