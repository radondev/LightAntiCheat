<?php

declare(strict_types=1);

namespace radondev\lac\threading\block;

use pocketmine\math\Vector3;
use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class BlockPlaceEventPacket extends PlayerExchangePacket
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
     * BlockPlaceEventPacket constructor.
     * @param string $rawUuid
     * @param Vector3 $position
     * @param int $blockId
     */
    public function __construct(string $rawUuid, Vector3 $position, int $blockId)
    {
        $this->position = clone $position;
        $this->blockId = $blockId;

        parent::__construct(Info::BLOCK_PLACE_EVENT_PACKET, $rawUuid);
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