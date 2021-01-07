<?php

namespace DeadlyCraft\doungeons\layer;

abstract class Layer{

    protected $channel = null;

    protected $clear = false;

    public function joinLayer(Channel $channel) :void{
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