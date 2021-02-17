<?php

namespace DeadlyCraft\mail;

use pocketmine\player\Player;
use DeadlyCraft\Main;
use DeadlyCraft\form\menu\FriendAcceptForm;

class FriendMail extends Mail{

    private $senderName;

    public function __construct(string $senderName) {
        parent::__construct($senderName."からフレンド申請が来ています。");
        $this->senderName = $senderName;
    }

    public function open(Player $player) {
        $sender = Main::getInstance()->getIPlayerByName($this->senderName);
        $player->sendForm(new FriendAcceptForm($sender));
        $player->deleteMail($this->id);
    }
}