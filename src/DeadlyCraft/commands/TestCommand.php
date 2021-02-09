<?php

namespace DeadlyCraft\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;
use pocketmine\math\Vector3;

use pocketmine\utils\BinaryStream;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\nbt\LittleEndianNbtSerializer;
use pocketmine\nbt\JsonNbtParser;

use minecraft\world\structure\LoadStructure;

class TestCommand extends VanillaCommand {

    public function __construct(string $name){
        parent::__construct(
            $name,
            "/test",
            "/test"
        );
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){

        /*$path = Server::getInstance()->getPluginPath()."resources\\structure\\".$args[0];

        $load = new LoadStructure($path);
        var_dump($load->nbt);*/
       // $load->setOrigin((int) $sender->getPosition()->getX(), (int) $sender->getPosition()->getY(), (int) $sender->getPosition()->getZ());
        //$load->build($sender->getWorld());

        $skinData = $sender->getSkin()->getSkinData();
        $image = imagecreatetruecolor(64, 64);

        $black = imagecolorallocate($image, 0, 0, 0);
        imagecolortransparent($image, $black);

        for($y = 0; $y < 64; ++$y){
            for($x = 1; $x < 64; ++$x){
                $key = (64 * $y + $x) * 4;
                $r = ord($skinData[$key++]);
                $g = ord($skinData[$key++]);
                $b = ord($skinData[$key++]);
                //$a = ord($skinData[$key + 3]);
                $color = imagecolorallocate($image, $r, $g, $b);
                imageline($image, $x, $y, $x, $y, $color);
            }
        }

        if(!file_exists('test')) mkdir('test');
        imagepng($image, 'test/'.strtolower($sender->getName()).'.png');
        imagedestroy($image);
    }
}