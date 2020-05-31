<?php

declare(strict_types=1);

namespace radondev\lac\threading;

use pocketmine\math\Vector3;

abstract class BlockExchangePacket extends ExchangePacket
{
    /**
     * @var Vector3
     */
    private $position;
    /**
     * @var int
     */
    private $blockId;

    /**
     * BlockExchangePacket constructor.
     * @param int $id
     * @param Vector3 $position
     * @param int $blockId
     */
    public function __construct(int $id, Vector3 $position, int $blockId)
    {
        $this->position = clone $position;
        $this->blockId = $blockId;

        parent::__construct($id);
    }

    /**
     * @return Vector3
     */
    public function getPosition(): Vector3
    {
        return $this->position;
    }

    /**
     * @param Vector3 $position
     */
    public function setPosition(Vector3 $position): void
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getBlockId(): int
    {
        return $this->blockId;
    }

    /**
     * @param int $blockId
     */
    public function setBlockId(int $blockId): void
    {
        $this->blockId = $blockId;
    }
}