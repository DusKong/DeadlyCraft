<?php

namespace DeadlyCraft\form\menu;

use pocketmine\Server;
use pocketmine\player\Player;
use minecraft\customui\Form;

class MailForm extends Form{

    private $list = [];

    public function __construct(Player $player) {
        $this->createSimpleForm("メール");
        $list = [];
        foreach ($player->getAccountData()->getData("mails") as $hash => $mail) {
            $this->addButton($mail->getTitle());
            $list[] = $mail;
        }
        $this->list = $list;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) return;

        $mail = $this->list[$data];
        $mail->open($player);
    }
}