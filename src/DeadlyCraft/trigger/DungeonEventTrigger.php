<?php

namespace DeadlyCraft\trigger;

use DeadlyCraft\channel\DungeonChannel;

class DungeonEventTrigger extends EventTrigger{

    private $channel;

    public function __construct(DungeonChannel $channel) {
        $this->channel = $channel;
    }

    public function getChannel() :DungeonChannel{
        return $this->channel;
    }
}