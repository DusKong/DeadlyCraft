<?php

namespace DeadlyCraft\doungeons\floor;

abstract class Floor{

    protected $channel = null;

    protected $clear = false;

    public function joinFloor(Channel $channel) :void{
        $this->channel = $channel;
    }

    abstract public function checkClear() :bool;

    public function clear() :void{
        $this->clear = true;
    }

    public function isClear() :bool{
        return $this->clear;
    }
}