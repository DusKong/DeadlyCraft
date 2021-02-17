<?php

namespace DeadlyCraft\form\menu;

use pocketmine\Server;
use pocketmine\player\Player;
use minecraft\customui\Form;

use DeadlyCraft\player\Party;
use DeadlyCraft\mail\PartyMail;

class PartyForm extends Form{

    public function __construct(Player $player) {
        $party = $player->getParty();
        $members = $party->getMember();
        $this->createSimpleForm("パーティー (".count($members).")");
        for ($i=0; $i < Party::MAX_PLAYERS; $i++) { 
            $m = array_shift($members);
            if($m !== null) {
                $color = "§8";
                if($party->isOwner($m)) $color = "§c";
                $this->addButton($color.$m->getName()."\n§e".$m->getJob()->getName()." §aLv.1");
            }else{
                $this->addButton("招待する");
            }
        }
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) return;
        $party = $player->getParty();
        $member = current(array_slice($party->getMember(), $data, 1, true));
        if($member instanceof Player) {
            $player->sendForm(new PartyEditForm($member));
        }else{
            $player->sendForm(new PartyInviteForm());
        }
    }
}

class PartyEditForm extends Form{

    private $currentMember;

    public function __construct(Player $member) {
        $this->createSimpleForm("".$member->getName());
        $this->addButton("フレンド申請する");
        $this->addButton("パーティーリーダーに任命する");
        $this->addButton("パーティーから退会させる");
        $this->currentMember = $member;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) {
            $player->sendForm(new PartyForm($player));
            return;
        }
        switch ($data) {
            case 0:
                break;
            case 1:
                break;
            case 2:
                break;
        }
    }
}

class PartyInviteForm extends Form{

    public function __construct() {
        $this->createSimpleForm("招待する方法を選んでください");
        $this->addButton("プレイヤーIDから検索");
        $this->addButton("名前から検索");
        $this->addButton("フレンドから");
        //$this->addButton("プレイヤーをタップ");
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) {
            $player->sendForm(new PartyForm($player));
            return;
        }
        switch($data) {
            case 0:
                break;
            case 1:
                $player->sendForm(new PartyInviteFromNameForm());
                break;
            case 2:
                $player->sendForm(new PartyInviteFromFriendForm($player));
                break;
        }
    }
}

class PartyInviteFromNameForm extends Form{

    public function __construct(string $defaultText = "") {
        $this->createCustomForm("名前を入力してください。");
        $this->addInput("プレイヤーの名前", "Steve", $defaultText);
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) {
            $player->sendForm(new PartyForm($player));
            return;
        }
        
        $found = Server::getInstance()->getPlayerByPrefix($data[0]);
        if($found instanceof Player && !$player->getParty()->isAlreadyMember($found)) {
            $player->sendForm(new PartyInviteHitForm($found));
        }else{
            $player->sendForm(new PartyNotFoundForm($data[0]));
        }
    }
}

class PartyInviteFromFriendForm extends Form{

    private $list;

    public function __construct(Player $player) {
        $this->createSimpleForm("招待するフレンドを選択してください");
        $list = [];
        foreach ($player->getFriends() as $friend) {
            $this->addButton($friend->getName());
            $list[] = $friend;
        }
        $this->list = $list;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) return;

        $found = $this->list[$data];
        if($found->isOnline()) {
            $this->found->sendMail(new PartyMail($player->getName()));
            $player->sendMessage($this->found->getName()."にパーティー申請を送信しました。");
        }else{
            
        }
    }
}

class PartyInviteHitForm extends Form{

    private $found;

    public function __construct(Player $found) {
        $this->createModalWindow("プレイヤーが見つかりました。", $found->getName()."をパーティーに招待しますか？", "招待する", "キャンセル");
        $this->found = $found;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data) {
            if($this->found->isOnline()) {
                $this->found->sendMail(new PartyMail($player->getName()));
                $player->sendMessage($this->found->getName()."にパーティー申請を送信しました。");
            }
        }else{
            $player->sendForm(new PartyInviteFromNameForm());
        }
    }
}

class PartyNotFoundForm extends Form{

    private $keyword;

    public function __construct(string $keyword) {
        $this->createModalWindow("", "プレイヤーが見つかりませんでした。\n(".$keyword.")でもう一度検索しますか？", "検索", "戻る");
        $this->keyword = $keyword;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data) {
            $player->sendForm(new PartyInviteFromNameForm($this->keyword));
        }else{
            $player->sendForm(new PartyForm($player));
        }
    }
}

class PartyJoinForm extends Form{

    private $owner;

    public function __construct(Player $owner) {
        $this->createModalWindow("", $owner->getName()."からパーティー申請が来ています。\n参加しますか？", "参加", "キャンセル");
        $this->owner = $owner;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data) {
            $party = $this->owner->getParty();
            if(count($party->getMember()) < Party::MAX_PLAYERS) {
                $party->addMember($player);
                $party->broadcastMessage($player->getName()."がパーティーに参加しました。");
            }
        }
    }
}