<?php

namespace DeadlyCraft\player;

use pocketmine\entity\Skin;

use DeadlyCraft\custume\cape\Cape;
use DeadlyCraft\custume\hat\Hat;

class CustumeSkin {

    private $skinId;

    private $skinData;

    private $cape;


    public function __construct(string $skinId, string $skinData, Cape $cape, Hat $hat) {
        $this->skinId = $skinId;
        $this->skinData = $skinData;
        $this->cape = $cape;
        $this->hat = $hat;
    }

    public function getSkinId() :string{
        return $this->skin->getSkinId();
    }

    public function getSkinData() :string{
        return $this->skinData;
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