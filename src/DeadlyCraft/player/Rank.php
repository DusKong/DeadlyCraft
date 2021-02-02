<?php

namespace DeadlyCraft\player;

use pocketmine\player\Player;

class Rank{

    const COMMON = 0;
    const ULTRA = 1;
    const LEGEND = 2;
    const TITAN = 3;
    const ETERNAL = 4;
    const YOUTUBE = 5;
    const STAFF = 6;
    const BUILDER = 7;
    const DEVELOPER = 9;
    const OWNER = 10;

    public static function getColor(Player $player) :string{
        switch($player->getRank()) {
            case self::COMMON:return "";
            case self::ULTRA:return "§b";
            case self::LEGEND:return "§d";
            case self::TITAN:return "§c";
            case self::ETERNAL:return "§e";
            case self::YOUTUBE:return "§d";
            case self::STAFF:return "§3";
            case self::BUILDER:return "§6";
            case self::DEVELOPER:return "§5";
            case self::OWNER:return "§4";
        }
    }

    public static function getTag(Player $player) :string{
        switch($player->getRank()) {
            case self::COMMON:return "";
            case self::ULTRA:return "ULTRA";
            case self::LEGEND:return "LEGEND";
            case self::TITAN:return "TITAN";
            case self::ETERNAL:return "ETERNAL";
            case self::YOUTUBE:return "YOUTUBE";
            case self::STAFF:return "STAFF";
            case self::BUILDER:return "BUILDER";
            case self::DEVELOPER:return "DEVELOPER";
            case self::OWNER:return "OWNER";
        }
    }
}