<?php

namespace DeadlyCraft\player;

use pocketmine\Server;
use pocketmine\player\PlayerInfo;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\nbt\tag\CompoundTag;

use minecraft\Player;

class PlayerSession extends Player{

    const MODE_LOBBY = 0;
    const MODE_ALIVE = 1;
    const MODE_DEATH = 2;

    private $mode = self::MODE_LOBBY;

    public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, ?CompoundTag $namedtag) {
        parent::__construct($server, $session, $playerInfo, $authenticated, $namedtag);
    }

    public function getMode() :int{
        return $this->mode;
    }

    public function setMode(int $mode) :void{
        $this->mode = $mode;
    }

    public function sendContainerClose($windowId) {
        $pk = new ContainerClosePacket();
        $pk->windowId = $windowId;
        $this->getNetworkSession()->getHandler()->handleContainerClose($pk);
    }
}