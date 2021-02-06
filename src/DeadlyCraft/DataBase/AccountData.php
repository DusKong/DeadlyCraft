<?php

namespace DeadlyCraft\DataBase;

use pocketmine\Server;

use DeadlyCraft\Main;
use DeadlyCraft\player\job\Soldier;

class AccountData extends PlayerData {

    public $tableName = "account";

    public function __construct(string $name) {
        parent::__construct($name);
        $this->status = [
            "id" => Main::$DB->num_rows("SELECT name FROM account"),
            "first_login" => time(),
            "current_job" => Soldier::getId(),
            "coin" => 0,
            "medal" => 0,
            "rank" => 0,
            "official" => false,
            "permissions" => [],
            "friend" => [
                "friends" => [],
                "applying" => [],
                "applied" => [],
            ],
            "deviceId" => "",
            "ip" => "",
        ];
    }

    public function checkData() :bool{
        $c = parent::checkData();
        if(!$c) {
            Server::getInstance()->getLogger()->info("§bCreating New PlayerData (".$this->name.") ID:".$this->status["id"]);
        }
        return $c;
    }
}