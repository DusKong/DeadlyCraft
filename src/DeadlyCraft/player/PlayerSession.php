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
    private $party;
    private $eventTrigger;

    private $job;

    private $permissions = [];

    public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, ?CompoundTag $namedtag) {
        parent::__construct($server, $session, $playerInfo, $authenticated, $namedtag);

        $this->accountData = new AccountData($this->getName());
        $this->statusData = new StatusData($this->getName());
        $this->party = new Party($this);
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

    public function getParty() :Party{
        return $this->party;
    }

    public function setParty(Party $party) :void{
        $this->party = $party;
    }

    public function isOfficial() :bool{
        return $this->accountData->getData("official");
    }

    public function setOfficial(bool $official) :void{
        $this->accountData->setData("official", $official);
        $this->setDefaultData();
    }

    public function getRank() :int{
        return $this->accountData->getData("rank");
    }

    public function setRank(int $rank) :void{
        $this->accountData->setData("rank", $rank);
        $this->setDefaultData();
    }

    public function getFriends() :array{
        $data = $this->accountData->getData("friend");
        $friends = [];
        foreach ($data["friends"] as $i => $name) {
            $friends[$name] = $this->getServer()->getPlayerByPrefix($name);
        }
        return $friends;
    }

    public function addFriend(string $name) :void{

    }

    public function removeFriend(string $name) :void{

    }

    public function applyFriend(string $name) :void{

    }

    public function removeApplied(string $name) :void{

    }

    public function removeApplying(string $name) :void{
        
    }

    public function setDefaultData() :void{
        $this->setNameTag(Rank::getColor($this).$this->getName());
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
            $data = $this->statusData->getData($oldJob::getId());
            $data["inventory"]->setContents($this->inventory->getContents());
            $data["armor"]->setContents($this->armorInventory->getContents());
        }

        $this->job = $job;
        $jobName = $job::getId();
        $this->accountData->setData("current_job", $jobName);
        $data2 = $this->statusData->getData($jobName);
        $this->inventory->setContents($data2["inventory"]->getContents());
        $this->armorInventory->setContents($data2["armor"]->getContents());
    }

    /*public function sendSkin(?array $targets = null) : void{
        $this->server->broadcastPackets($targets ?? $this->hasSpawned, [
            PlayerSkinPacket::create($this->getUniqueId(), (new CustumeSkinAdapter())->toSkinData($this->custume))
        ]);
    }*/

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

        $statusData = $this->statusData->getData($this->getJob()::getId());
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