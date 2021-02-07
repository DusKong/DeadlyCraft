<?php

namespace DeadlyCraft\player;

use pocketmine\player\Player;

class Party {

    public const MAX_PLAYERS = 4;

    private $owner;
    private $member = [];

    public function __construct(Player $owner) {
        $this->owner = $owner;
        $this->member[$owner->getName()] = $owner;
    }

    public function isOwner(Player $player) :bool{
        return $this->owner->getName() === $player->getName();
    }

    public function getOwner() :Player{
        return $this->owner;
    }

    public function addMember(Player $player) :void{
        $this->member[$player->getName()] = $player;
        $player->setParty($this);
    }

    public function removeMember(Player $player) :void{
        unset($this->member[$player->getName()]);
        $player->setParty(new Party($player));
        if($this->isOwner($player)) {
            if(count($this->getMember()) > 0) {
                $newOwner = array_shift($this->getMember());
                $this->owner = $newOwner;
            }
        }
    }

    public function getMember() :array{
        return $this->member;
    }

    public function broadcastMessage(string $message) :void{
        foreach ($this->getMember() as $member) {
            $member->sendMessage($message);
        }
    }
}