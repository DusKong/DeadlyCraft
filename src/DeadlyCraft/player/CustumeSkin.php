<?php

namespace DeadlyCraft\player;

use pocketmine\entity\Skin;
use pocketmine\network\mcpe\protocol\types\skin\PersonaPieceTintColor;
use pocketmine\network\mcpe\protocol\types\skin\PersonaSkinPiece;

use DeadlyCraft\custume\cape\Cape;
use DeadlyCraft\custume\hat\Hat;

class CustumeSkin {

    private $skinId;

    private $skinData;

    private $geometryData;

    private $cape;


    public function __construct(string $skinId, string $skinData, string $geometryData, /*Cape $cape, */Hat $hat) {
        $this->skinId = $skinId;
        $this->skinData = $skinData;
        $this->geometryData = $geometryData;
        //$this->cape = $cape;
        $this->hat = $hat;
    }

    public function getSkinId() :string{
        return $this->skinId;
    }

    public function getSkinData() :string{
        return $this->skinData;
    }

    public function getGeometryData() :string{
        return $this->geometryData;
    }

    public function getCape() :Cape{
        return $this->cape;
    }

    public function getPieces() :array{
        $pieces = [];
        $tintColors = [];
        foreach ([$this->hat] as $custume) {
            $pieces[] = new PersonaSkinPiece($custume->getPieceId(), $custume->getPieceType(), $custume->getPackId(), true, $custume->getProductId());
            $tintColors[] = new PersonaPieceTintColor($custume->getPieceType(), $custume->getColors());
        }
        return ["skin" => $pieces, "colors" => $tintColors];
    }
}