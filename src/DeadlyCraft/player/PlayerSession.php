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

use DeadlyCraft\player\job\Job;
use DeadlyCraft\player\job\Soldier;
use DeadlyCraft\inventory\PlayerInventory;
use DeadlyCraft\inventory\PlayerArmorInventory;
use DeadlyCraft\DataBase\AccountData;
use DeadlyCraft\DataBase\StatusData;
use DeadlyCraft\trigger\EventTrigger;
use DeadlyCraft\utils\CustumeSkinAdapter;

class PlayerSession extends Player{

    const MODE_LOBBY = 0;
    const MODE_ALIVE = 1;
    const MODE_DEATH = 2;

    private $accountData;
    private $statusData;

    private $mode = self::MODE_LOBBY;
    private $eventTrigger;

    private $job;
    private $custume;

    private $permissions = [];

    public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, ?CompoundTag $namedtag) {
        parent::__construct($server, $session, $playerInfo, $authenticated, $namedtag);

        $this->accountData = new AccountData($this);
        $this->statusData = new StatusData($this);
    }

    public function getAccountData() :AccountData{
        return $this->accountData;
    }

    public function getStatusData() :StatusData{
        return $this->statusData;
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

    public function getJob() :Job{
        return $this->job;
    }

    public function setJob(Job $job) :void{
        $oldJob = $this->job;
        if($oldJob !== null) {
            $data = $this->statusData->getData($oldJob::getName());
            $data["inventory"]->setContents($this->inventory->getContents());
            $data["armor"]->setContents($this->armorInventory->getContents());
        }

        $this->job = $job;
        $jobName = $job::getName();
        $this->accountData->setData("current_job", $jobName);
        $data2 = $this->statusData->getData($jobName);
        $this->inventory->setContents($data2["inventory"]->getContents());
        $this->armorInventory->setContents($data2["armor"]->getContents());
    }

    public function setCustume(CustumeSkin $custume) :void{
        $this->custume = $custume;
    }

    public function sendSkin(?array $targets = null) : void{
        $this->server->broadcastPackets($targets ?? $this->hasSpawned, [
            PlayerSkinPacket::create($this->getUniqueId(), (new CustumeSkinAdapter())->toSkinData($this->custume))
        ]);
    }

    public function getPermissions() :array{
        return $this->accountData->getData("permissions");
    }

    public function inPermission(string $permission) :bool{
        return isset($this->accountData->getData("permissions")[$permission]);
    }

    public function addPermission(string $permission) :void{
        $per = $this->getPermissions();
        $per[$permission] = true;
        $this->accountData->setData("permission", $per);
    }

    public function removePermission(string $permission) :void{
        $per = $this->getPermissions();
        if($this->hasPermission($permission)) {
            unset($per[$permission]);
            $this->accountData->setData("permission", $per);
        }
    }

    protected function initEntity(CompoundTag $nbt) : void{
        parent::initEntity($nbt);
    }

    public function checkData() :void{
        $this->accountData->checkData();
        $this->statusData->checkData();
        $this->setJob(Job::getClassByName($this->accountData->getData("current_job")));

        $statusData = $this->statusData->getData($this->getJob()::getName());
        $this->inventory->setContents($statusData["inventory"]->getContents());
        $this->armorInventory->setContents($statusData["armor"]->getContents());
    }

    public function saveToAll() :void{
        $this->setJob($this->getJob());
        $this->accountData->saveToData();
        $this->statusData->saveToData();
    }

    public function sendContainerClose($windowId) {
        $pk = new ContainerClosePacket();
        $pk->windowId = $windowId;
        $this->getNetworkSession()->getHandler()->handleContainerClose($pk);
    }
}