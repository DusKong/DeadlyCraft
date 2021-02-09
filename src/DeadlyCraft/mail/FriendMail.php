<?php

namespace DeadlyCraft\mail;

class FriendMail extends Mail{

    private $friendName;

    public function __construct(string $friendName) {
        parent::__construct($friendName."からフレンド申請が来ています。");
        $this->friendName = $friendName;
    }

    public function openMail(Player $player) {
        $player->sendForm(new )
    }
}