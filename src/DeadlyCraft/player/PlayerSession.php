<?php

namespace DeadlyCraft\player;

use pocketmine\Server;
use pocketmine\player\PlayerInfo;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\nbt\tag\CompoundTag;

use minecraft\Player;

class PlayerSession extends Player{

    public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, ?CompoundTag $namedtag) {
        parent::__construct($server, $session, $playerInfo, $authenticated, $namedtag);
    }
}