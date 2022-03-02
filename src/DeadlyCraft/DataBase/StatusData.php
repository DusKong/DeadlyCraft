<?php

namespace DeadlyCraft\DataBase;

use pocketmine\Server;

use DeadlyCraft\player\job\Soldier;
use DeadlyCraft\inventory\SerializeInventory;

class StatusData extends PlayerData {

    public $tableName = "statusaaa";

    public function __construct(string $name) {
        parent::__construct($name);
        foreach ($this->getInitialJob() as $job) {
            $data = $job::getDefaultData();
            $data["inventory"] = new SerializeInventory();
            $data["armor"] = new SerializeInventory();
            $this->status[$job::getId()] = $data;
        }
    }

    public function jsonSerialize() :array{
        $status = $this->status;
        foreach ($status as $name => $data) {
            $status[$name]["inventory"] = serialize($data["inventory"]);
            $status[$name]["armor"] = serialize($data["armor"]);
        }
        return $status;
    }

    public function jsonDeserialize(array $status) :array{
        foreach ($status as $name => $data) {
            $status[$name]["inventory"] = unserialize($data["inventory"]);
            $status[$name]["armor"] = unserialize($data["armor"]);
        }
        return $status;
    }

    public function getInitialJob() {
        return [
            new Soldier(),
        ];
    }
}