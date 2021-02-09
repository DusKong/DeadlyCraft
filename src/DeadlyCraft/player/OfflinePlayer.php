<?php

namespace DeadlyCraft\player;

use pocketmine\player\IPlayer;
use DeadlyCraft\mail\Mail;
use DeadlyCraft\DataBase\AccountData;
use DeadlyCraft\DataBase\StatusData;

class OfflinePlayer implements IPlayer{

    private $name;

    private $accountData;
    private $statusData;

    public function __construct(string $name) {
        $this->name = $name;
        $this->accountData = new AccountData($name);
        $this->statusData = new StatusData($name);
        $this->checkData();
    }

    public function getAccountData() :AccountData{
        return $this->accountData;
    }

    public function getStatusData() :StatusData{
        return $this->statusData;
    }

    public function isOfficial() :bool{
        return $this->accountData->getData("official");
    }

    public function setOfficial(bool $official) :void{
        $this->accountData->setData("official", $official);
    }

    public function getRank() :int{
        return $this->accountData->getData("rank");
    }

    public function setRank(int $rank) :void{
        $this->accountData->setData("rank", $rank);
    }

    public function sendMail(Mail $mail) :void{
        $mails = $this->accountData->getData("mails");
        $mails[spl_object_hash($mail)] = $mail;
        $this->accountData->setData("mails", $mails);
    }

    public function checkData() :void{
        $this->accountData->checkData();
        $this->statusData->checkData();
    }

    public function saveToAll() :void{
        $this->accountData->saveToData();
        $this->statusData->saveToData();
    }
}