<?php

namespace DeadlyCraft\form\menu;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\player\IPlayer;
use minecraft\customui\Form;

use DeadlyCraft\Main;
use DeadlyCraft\mail\FriendMail;

class FriendForm extends Form{

    private $list = [];

    public function __construct(Player $player) {
        $this->createSimpleForm("フレンド");
        $list = [];
        foreach ($player->getFriends() as $name => $friend) {
            $c = "§a";
            if($friend === null) $c = "§8";
            $this->addButton($c.$name);
            $list[] = $name;     
        }
        $this->list = $list;
        $this->addButton("フレンドを追加");
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) return;

        if(isset($this->list[$data])) {
            return;
        }

        $player->sendForm(new FriendApplyForm());
    }
}

class FriendApplyForm extends Form{

    public function __construct() {
        $this->createSimpleForm("フレンド");
        $this->addButton("プレイヤーIDから検索");
        $this->addButton("名前から検索");
        $this->addButton("プレイヤーをタップ");
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) {
            $player->sendForm(new FriendForm($player));
            return;
        }

        switch($data) {
            case 0:
                break;
            case 1:
                $player->sendForm(new FriendApplyFromNameForm());
                break;
            case 2:
                break;
        }
    }
}

class FriendApplyFromNameForm extends Form{

    public function __construct(string $defaultText = "") {
        $this->createCustomForm("名前を入力してください。");
        $this->addInput("プレイヤーの名前", "Steve", $defaultText);
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) {
            $player->sendForm(new FriendForm($player));
            return;
        }
        
        $found = Main::getInstance()->getIPlayerByName($data[0]);
        if($found !== null) {
            $player->sendForm(new FriendApplyHitForm($found));
        }else{
            //$player->sendForm(new FriendNotFoundForm($data[0]));
        }
    }
}

class FriendApplyHitForm extends Form{

    private $found;

    public function __construct(IPlayer $found) {
        $this->createModalWindow("プレイヤーが見つかりました。", $found->getName()."をフレンド申請しますか？", "申請する", "キャンセル");
        $this->found = $found;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data) {
            $player->applyFriend($this->found->getName());
        }else{
            $player->sendForm(new FriendApplyForm());
        }
    }
}

class FriendAcceptForm extends Form{

    public function __construct(IPlayer $sender) {
        $this->createModalWindow("フレンド申請", $sender->getName()."からフレンド申請が来ています。", "申請する", "キャンセル");
        $this->sender = $sender;
    }

    public function handleResponse(Player $player, $data) :void{
        if($data) {
            $player->addFriend($this->sender->getName());
        }else{
            $player->removeApplying($this->sender->getName());
        }
    }
}