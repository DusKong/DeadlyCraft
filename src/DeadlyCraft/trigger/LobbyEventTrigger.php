<?php

namespace AxisServer\trigger;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\InventoryManager;
use pocketmine\network\mcpe\protocol\ProtocolInfo as Info;

use AxisServer\Main;

class LobbyEventTrigger extends EventTrigger{

    public function onDamageTrigger(EntityDamageEvent $event) :void{
        if($event->getCause() == EntityDamageEvent::CAUSE_VOID) {
            $event->getEntity()->teleport(Main::getInstance()->getLobbyPosition());
        }
        $event->cancel();
    }

    public function onSendPacketTrigger(DataPacketSendEvent $event) :void{
        $packet = $event->getPackets()[0];
        $networkSession = $event->getTargets()[0];
        switch($packet::NETWORK_ID) {
            case Info::CONTAINER_OPEN_PACKET:
                if($packet->windowId == InventoryManager::HARDCODED_INVENTORY_WINDOW_ID) {
                    $event->cancel();
                    $player = $networkSession->getPlayer();
                    $player->sendContainerClose($packet->windowId);
                    $player->sendForm(new PlayerMenuForm());
                }
                break;
        }
    }
}