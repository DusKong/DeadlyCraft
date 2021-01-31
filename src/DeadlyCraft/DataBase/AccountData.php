<?php

namespace DeadlyCraft\DataBase;

use pocketmine\Server;
use pocketmine\player\Player;

use DeadlyCraft\Main;
use DeadlyCraft\player\job\Soldier;

class AccountData extends PlayerData {

    public $tableName = "account";

    public function __construct(Player $player) {
        parent::__construct($player);
        $this->status = [
            "id" => Main::$DB->num_rows("SELECT name FROM account"),
            "first_login" => time(),
            "current_job" => Soldier::getName(),
            "coin" => 0,
            "medal" => 0,
            "rank" => 0,
            "permissions" => [],
            "deviceId" => "",
            "ip" => "",
        ];
    }

    public function checkData() :bool{
        $c = parent::checkData();
        if(!$c) {
            Server::getInstance()->getLogger()->info("§bCreating New PlayerData (".$this->player->getName().") ID:".$this->status["id"]);
        }
        return $c;
    }
}