<?php

namespace DeadlyCraft\form\menu;

use pocketmine\Server;
use pocketmine\player\Player;
use minecraft\customui\Form;

use DeadlyCraft\player\Party;

class PartyForm extends Form{

    public function __construct(Player $player) {
        $party = $player->getParty();
        $this->createSimpleForm("パーティー");
        $members = $party->getMember();
        for ($i=0; $i < Party::MAX_PLAYERS; $i++) { 
            $m = array_shift($members);
            if($m !== null) {
                $this->addButton($m->getName()."\n§8".$m->getJob()->getName()." §aLv.1");
            }else{
                $this->addButton("招待する");
            }
        }
    }

    public function handleResponse(Player $player, $data) :void{
    }
}