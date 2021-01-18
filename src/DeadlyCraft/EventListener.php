<?php

namespace DeadlyCraft;

use pocketmine\event\Listener;
use pocketmine\event\player\{
    PlayerJoinEvent,
};
use pocketmine\event\entity\{
    EntityDamageEvent,
};

use DeadlyCraft\player\PlayerSession;
use DeadlyCraft\entity\monster\MetalicZombie;

class EventListener implements Listener {

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();

        $channel = Main::$lobbyChannel;
        $player->setChannel($channel);

        $player->teleport(Main::getInstance()->getLobbyPosition());

        //$entity = new MetalicZombie($channel);
        //$entity->setPosition(192, 5, 96);
        //$channel->addEntity($entity);
    }

    public function onDamage(EntityDamageEvent $event) {
        $player = $event->getEntity();
        switch($player->getMode()) {
            case PlayerSession::MODE_LOBBY:
                $event->cancel();
                break;
        }
    }
}