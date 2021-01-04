<?php

namespace DeadlyCraft\channel;

use pocketmine\Server;
use pocketmine\player\Player;
use minecraft\Channel as APIChanel;

class Channel extends APIChanel{

    public function joinChannel(Player $player) :void{
        parent::joinChannel($player);

        foreach (Server::getInstance()->getOnlinePlayers() as $players) {
            $players->hidePlayer($player);
            $player->hidePlayer($player);
        }

        foreach ($this->getPlayers() as $players) {
            $players->showPlayer($player);
            $player->showPlayer($players);
        }
    }
}