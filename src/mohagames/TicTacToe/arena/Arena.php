<?php

namespace mohagames\TicTacToe\arena;

use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIds;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class Arena{

    /**
     * @var AxisAlignedBB
     */
    private $alignedBB;

    /**
     * @var Level
     */
    private $level;

    /**
     * @var int
     */
    private $arenaId;

    public function __construct(int $arenaId, AxisAlignedBB $alignedBB, Level $level)
    {

        $this->level = $level;
        $this->alignedBB = $alignedBB;
        $this->arenaId = $arenaId;

    }

    public function getLevel() : Level
    {
        return $this->level;
    }

    public function getId() : int
    {
        return $this->arenaId;
    }

    public function getBoundingBox() : AxisAlignedBB
    {
        return $this->alignedBB;
    }

    public function initBlocks()
    {
        $bb = $this->getBoundingBox();
        $minX = $bb->minX;
        $minZ = $bb->minZ;

        $maxX = $bb->maxX;
        $maxZ = $bb->maxZ;

        $y = $bb->minY;

        for($x = $minX; $x <= $maxX; $x++)
        {
            for($z = $minZ; $z <= $maxZ; $z++)
            {
                $this->getLevel()->setBlock(new Vector3($x, $y, $z), BlockFactory::get(BlockIds::WOOL));
            }

        }


    }






}