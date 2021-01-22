<?php

namespace DeadlyCraft\player;

use pocketmine\Server;
use pocketmine\entity\Skin;
use pocketmine\player\PlayerInfo;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\network\mcpe\protocol\PlayerSkinPacket;
use pocketmine\nbt\tag\CompoundTag;

use minecraft\Player;

use DeadlyCraft\trigger\EventTrigger;
use DeadlyCraft\utils\CustumeSkinAdapter;

class PlayerSession extends Player{

    const MODE_LOBBY = 0;
    const MODE_ALIVE = 1;
    const MODE_DEATH = 2;

    private $mode = self::MODE_LOBBY;
    private $eventTrigger;

    private $custume;

    public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, ?CompoundTag $namedtag) {
        parent::__construct($server, $session, $playerInfo, $authenticated, $namedtag);
    }

    public function getMode() :int{
        return $this->mode;
    }

    public function setMode(int $mode) :void{
        $this->mode = $mode;
    }

    public function setEventTrigger(EventTrigger $trigger) :void{
        $this->eventTrigger = $trigger;
    }

    public function getEventTrigger() :?EventTrigger{
        return $this->eventTrigger;
    }

    public function setCustume(CustumeSkin $custume) :void{
        $this->custume = $custume;
    }

    public function sendSkin(?array $targets = null) : void{
        $this->server->broadcastPackets($targets ?? $this->hasSpawned, [
            PlayerSkinPacket::create($this->getUniqueId(), (new CustumeSkinAdapter())->toSkinData($this->custume))
        ]);
    }

    protected function initEntity(CompoundTag $nbt) : void{
        parent::initEntity($nbt);
    }

    public function sendContainerClose($windowId) {
        $pk = new ContainerClosePacket();
        $pk->windowId = $windowId;
        $this->getNetworkSession()->getHandler()->handleContainerClose($pk);
    }
}