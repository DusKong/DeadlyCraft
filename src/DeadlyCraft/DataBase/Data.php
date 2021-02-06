<?php

namespace DeadlyCraft\DataBase;

abstract class Data {

    protected $status = [];

    public function getData(string $key) {
        return $this->status[$key];
    }

    public function setData(string $key, $data) :void{
        $this->status[$key] = $data;
    }

    public function addData(string $key, $amount) :void{
        $this->status[$key] += $amount;
    }

    public function removeData(string $key, $amount) :void{
        $this->status[$key] -= $amount;
        if($this->status[$key] < 0) {
            $this->status[$key] = 0;
        }
    }
}