<?php

namespace AxisServer\trigger;

use pocketmine\event\player\{
    PlayerQuitEvent,
    PlayerInteractEvent,
    PlayerRespawnEvent,
    PlayerDropItemEvent,
    PlayerExhaustEvent,
    PlayerToggleFlightEvent,
    PlayerToggleSneakEvent,
};
use pocketmine\event\entity\{
    EntityDamageEvent,
    EntityShootBowEvent,
};
use pocketmine\event\block\{
    BlockBreakEvent,
    BlockPlaceEvent,
};
use pocketmine\event\server\{
    DataPacketSendEvent,
    DataPacketReceiveEvent,
};

abstract class EventTrigger {

    public function onQuitTrigger(PlayerQuitEvent $event) :void{}

    public function onInteractTrigger(PlayerInteractEvent $event) :void{}

    public function onDeathTrigger(PlayerDeathEvent $event) :void{}

    public function onRespawnTrigger(PlayerRespawnEvent $event) :void{}

    public function onDropItemTrigger(PlayerDropItemEvent $event) :void{
        $event->cancel();
    }

    public function onExhauseTrigger(PlayerExhaustEvent $event) :void{
        $event->cancel();
    }

    public function onFlightTrigger(PlayerToggleFlightEvent $event) :void{}

    public function onSneakTrigger(PlayerToggleSneakEvent $event) :void{}

    public function onDamageTrigger(EntityDamageEvent $event) :void{}

    public function onBreakTrigger(BlockBreakEvent $event) :void{
        $event->cancel();
    }

    public function onPlaceTrigger(BlockPlaceEvent $event) :void{
        $event->cancel();
    }

    public function onSendPacketTrigger(DataPacketSendEvent $event) :void{}

    public function onReceivePacketTrigger(DataPacketReceiveEvent $event) :void{}
}