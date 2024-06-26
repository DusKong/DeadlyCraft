<?php

namespace DeadlyCraft\player;

use pocketmine\Server;
use pocketmine\player\IPlayer;
use pocketmine\entity\Skin;
use pocketmine\player\PlayerInfo;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\network\mcpe\protocol\PlayerSkinPacket;
use pocketmine\nbt\tag\CompoundTag;

use minecraft\Player;

use DeadlyCraft\Main;
use DeadlyCraft\player\job\Job;
use DeadlyCraft\player\job\Soldier;
use DeadlyCraft\mail\Mail;
use DeadlyCraft\mail\FriendMail;
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

    public function getDataId() :int{
        return $this->accountData->getData("id");
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

    public function sendMail(Mail $mail) :void{
        $mails = $this->accountData->getData("mails");
        $mails[$mail->getId()] = $mail;
        $this->accountData->setData("mails", $mails);
        $this->sendMessage($mail->getTitle());
    }

    public function deleteMail(string $id) :void{
        $mails = $this->accountData->getData("mails");
        if(isset($mails[$id])) unset($mails[$id]);
        $this->accountData->setData("mails", $mails);
    }

    public function getMails() :array{
        return $this->accountData->getData("mails");
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
        $newFriend = Main::getInstance()->getIPlayerByName($name);
        if(!$newFriend instanceof IPlayer) return;
        $fdata = $newFriend->getAccountData()->getData("friend");
        $fdata["applying"] = array_diff($fdata["applying"], [$this->getName()]);
        $fdata["applying"] = array_values($fdata["applying"]);
        $fdata["applied"] = array_diff($fdata["applied"], [$this->getName()]);
        $fdata["applied"] = array_values($fdata["applied"]);
        $fdata["friends"][] = $this->getName();
        $newFriend->getAccountData()->setData("friend", $fdata);
        if($newFriend instanceof Player) {
            $newFriend->sendMessage($this->getName()."とフレンドになりました。");
        }else{
            $newFriend->getAccountData()->saveToData();
        }

        $data = $this->getAccountData()->getData("friend");
        $data["applying"] = array_diff($data["applying"], [$name]);
        $data["applying"] = array_values($data["applying"]);
        $data["applied"] = array_diff($data["applied"], [$name]);
        $data["applied"] = array_values($data["applied"]);
        $data["friends"][] = $name;
        $this->getAccountData()->setData("friend", $data);
        $this->sendMessage($name."とフレンドになりました。");
    }

    public function removeFriend(string $name) :void{
        $rFriend = Main::getInstance()->getIPlayerByName($name);
        if(!$rFriend instanceof IPlayer) return;
        $fdata = $rFriend->getAccountData()->getData("friend");
        $fdata["friends"] = array_diff($fdata["friends"], [$this->getName()]);
        $fdata["friends"] = array_values($fdata["friends"]);
        $rFriend->getAccountData()->setData("friend", $fdata);
        if($rFriend instanceof Player) {
            $rFriend->sendMessage($this->getName()."とフレンド解除");
        }else{
            $rFriend->getAccountData()->saveToData();
        }

        $data = $this->getAccountData()->getData("friend");
        $data["friends"] = array_diff($data["friends"], [$name]);
        $data["friends"] = array_values($data["friends"]);
        $this->getAccountData()->setData("friend", $data);
        $this->sendMessage($name."とフレンド解除");
    }

    public function applyFriend(string $name) :bool{
        $friend = Main::getInstance()->getIPlayerByName($name);
        if($friend instanceof IPlayer) {
            if($friend->getName() == $this->getName()) {
                return false;
            }

            $fdata = $friend->getAccountData()->getData("friend");
            if(in_array($this->getName(), $fdata["applying"])) {
                $this->addFriend($name);
                return true;
            }

            if(in_array($this->getName(), $fdata["applied"]) || in_array($this->getName(), $fdata["friends"])) {
                $player->sendMessage("既に送信済みです。");
                return false;
            }

            $fdata["applied"][] = $this->getName();
            $friend->getAccountData()->setData("friend", $fdata);
            $friend->sendMail(new FriendMail($this->getName()));
            if(!$friend instanceof Player) $friend->getAccountData()->saveToData();

            $data = $this->getAccountData()->getData("friend");
            $data["applying"][] = $friend->getName();
            $this->getAccountData()->setData("friend", $data);
            $this->sendMessage($friend->getName()."にフレンド申請を送信しました。");
            return true;
        }
        return false;
    }

    public function removeApplying(string $name) :void{
        $friend = Main::getInstance()->getIPlayerByName($name);
        if($friend instanceof IPlayer) {
            $fdata = $friend->getAccountData()->getData("friend");
            $fdata["applied"] = array_diff($fdata["applied"], [$this->getName()]);
            $fdata["applied"] = array_values($fdata["applied"]);
            $friend->getAccountData()->setData("friend", $fdata);
            if(!$friend instanceof Player) $friend->getAccountData()->saveToData();

            $data = $this->getAccountData()->getData("friend");
            $data["applying"] = array_diff($data["applying"], [$friend->getName()]);
            $data["applying"] = array_values($fdata["applying"]);
            $this->getAccountData()->setData("friend", $data);
        }
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