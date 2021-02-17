<?php

namespace DeadlyCraft\mail;

use pocketmine\player\Player;

abstract class Mail {

    const DEAD_LINE = 7;

    private $title;
    private $date;
    protected $id;

    public function __construct(string $title) {
        $this->title = $title;
        $this->date = date("Y-n-j");
        $this->id = spl_object_hash($this);
    }

    public function getId() :string{
        return $this->id;
    }

    public function getTitle() :string{
        return $this->title;
    }

    public function open(Player $player) {
    }
}