<?php

namespace DeadlyCraft;

use pocketmine\event\Listener;
use pocketmine\event\player\{
    PlayerJoinEvent,
    PlayerQuitEvent,
    PlayerInteractEvent,
    PlayerDropItemEvent,
    PlayerExhaustEvent,
    PlayerChatEvent,
    PlayerToggleFlightEvent,
    PlayerToggleSneakEvent,
    PlayerCommandPreprocessEvent,
};
use pocketmine\event\entity\{
    EntityDamageEvent,
};
use pocketmine\event\block\{
    BlockBreakEvent,
    BlockPlaceEvent,
};
use pocketmine\event\server\{
    DataPacketSendEvent,
    DataPacketReceiveEvent
};

use DeadlyCraft\player\PlayerSession;
use DeadlyCraft\player\CustumeSkin;
use DeadlyCraft\entity\monster\MetalicZombie;
use DeadlyCraft\trigger\LobbyEventTrigger;

class EventListener implements Listener {

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();

        $channel = Main::$lobbyChannel;
        $player->setChannel($channel);

        $player->teleport(Main::getInstance()->getLobbyPosition());

        $player->setEventTrigger(new LobbyEventTrigger());

        //$entity = new MetalicZombie($channel);
        //$entity->setPosition(192, 5, 96);
        //$channel->addEntity($entity);

        $skin = $player->getPlayerInfo()->getSkin();
        $custume = new CustumeSkin($skin->getSkinId(), $skin->getSkinData(), $skin->getGeometryData(), new \DeadlyCraft\custume\hat\FlowerPot());
        $player->setCustume($custume);
        $player->sendSkin();
    }

    public function onQuit(PlayerQuitEvent $event) {
        $event->setQuitMessage(null);
        $player = $event->getPlayer();
        return;
        if($player->spawned) {
            $player->saveToAll();
        }
    }

    public function onInteract(PlayerInteractEvent $event) {
    }

    public function onDropItem(PlayerDropItemEvent $event) { $event->cancel(); }

    public function onExhaust(PlayerExhaustEvent $event) { $event->cancel(); }

    public function onSneak(PlayerToggleSneakEvent $event) {
        $event->getPlayer()->getEventTrigger()->onSneakTrigger($event);
    }

    public function onChat(PlayerChatEvent $event) {
        return;
        $event->cancel();
        $player = $event->getPlayer();
        $tag = Roll::getChatTag($player);
        $level = Exp::getLevelTag($player);
        Server::getInstance()->broadcastMessage("§l".$tag." §r".$player->getName()." >> ".$event->getMessage());
        Server::getInstance()->getAsyncPool()->submitTask(new MessageHistory($player, $event->getMessage()));
    }

    public function onDamage(EntityDamageEvent $event) {
        if(!$event->getEntity() instanceof Player) return;
        $event->getEntity()->getEventTrigger()->onDamageTrigger($event);
    }

    public function onBreak(BlockBreakEvent $event) { /*$event->cancel();*/ }

    public function onPlace(BlockPlaceEvent $event) { /*$event->cancel();*/ }

    public function onSendPacket(DataPacketSendEvent $event) {
        $player = $event->getTargets()[0]->getPlayer();
        $packet = $event->getPackets()[0];
        if($player != null && $player->getEventTrigger() != null) $player->getEventTrigger()->onSendPacketTrigger($event);
    }

    public function onReceivePacket(DataPacketReceiveEvent $event) {
        $player = $event->getOrigin()->getPlayer();
        //var_dump(get_class($event->getPacket()));
        if($player != null && $player->getEventTrigger() != null) $player->getEventTrigger()->onReceivePacketTrigger($event);
    }
}