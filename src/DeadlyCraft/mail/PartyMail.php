<?php

namespace DeadlyCraft\mail;

use pocketmine\Server;
use pocketmine\player\Player;

use DeadlyCraft\form\menu\PartyJoinForm;

class PartyMail extends Mail{

    private $ownerName;

    public function __construct(string $ownerName) {
        parent::__construct($ownerName."からパーティー申請が来ています。");
        $this->ownerName = $ownerName;
    }

    public function open(Player $player) {
        $owner = Server::getInstance()->getPlayerByPrefix($this->ownerName);
        if($owner instanceof Player) {
            if($owner->getParty()->isOwner($owner)) {
                $player->sendForm(new PartyJoinForm($owner));
                $player->deleteMail($this->id);
                return;
            }
        }
        $player->sendMessage("失敗");
    }
}