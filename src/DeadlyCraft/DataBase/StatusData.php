<?php

namespace DeadlyCraft\DataBase;

use pocketmine\Server;
use pocketmine\player\Player;

use DeadlyCraft\player\job\Soldier;
use DeadlyCraft\inventory\SerializeInventory;

class StatusData extends PlayerData {

    public $tableName = "status";

    public function __construct(Player $player) {
        parent::__construct($player);
        foreach ($this->getInitialJob() as $job) {
            $data = $job::getDefaultData();
            $data["inventory"] = new SerializeInventory($player);
            $data["armor"] = new SerializeInventory($player);
            $this->status[$job::getName()] = $data;
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