<?php

namespace DeadlyCraft\form\menu;

use pocketmine\Server;
use pocketmine\player\Player;
use minecraft\customui\Form;

class LobbyMenuForm extends Form{

    public function __construct(Player $player) {
        $this->createSimpleForm("メニュー");
        $this->addButton("パーティー (".count($player->getParty()->getMember()).")", "path", "textures/ui/multiplayer_glyph_color");
        $this->addButton("フレンド (".$this->getOnlineFriends($player->getFriends()).")", "path", "textures/ui/FriendsIcon");
        $this->addButton("メール (".count($player->getMails()).")", "path", "textures/ui/comment");
        $this->addButton("設定", "path", "textures/ui/dev_glyph_color");
    }

    public function handleResponse(Player $player, $data) :void{
        if($data === null) return;
        switch($data) {
            case 0:
                $player->sendForm(new PartyForm($player));
                break;
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
        }
    }

    public function getOnlineFriends(array $friends) :int{
        $online = 0;
        foreach ($friends as $friend) {
            if($friend !== null) {
                $online++;
            }
        }
        return $online;
    }

}