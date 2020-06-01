<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use pocketmine\math\Vector3;
use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerInteractEventPacket extends PlayerExchangePacket
{
    /**
     * @var int $itemId
     */
    private $itemId;
    /**
     * @var int $action
     */
    private $action;
    /**
     * @var int $blockId
     */
    private $blockId;
    /**
     * @var Vector3 $blockPosition
     */
    private $blockPosition;
    /**
     * @var int $blockFace
     */
    private $blockFace;

    /**
     * PlayerInteractEventPacket constructor.
     * @param string $rawUuid
     * @param int $itemId
     * @param int $action
     * @param int $blockId
     * @param Vector3 $blockPosition
     * @param int $blockFace
     */
    public function __construct(string $rawUuid, int $itemId, int $action, int $blockId, Vector3 $blockPosition, int $blockFace)
    {
        $this->itemId = $itemId;
        $this->action = $action;
        $this->blockId = $blockId;
        $this->blockPosition = $blockPosition;
        $this->blockFace = $blockFace;

        parent::__construct(Info::PLAYER_INTERACT_EVENT_PACKET, $rawUuid);
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     */
    public function setItemId(int $itemId): void
    {
        $this->itemId = $itemId;
    }

    /**
     * @return int
     */
    public function getAction(): int
    {
        return $this->action;
    }

    /**
     * @param int $action
     */
    public function setAction(int $action): void
    {
        $this->action = $action;
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

    /**
     * @return Vector3
     */
    public function getBlockPosition(): Vector3
    {
        return $this->blockPosition;
    }

    /**
     * @param Vector3 $blockPosition
     */
    public function setBlockPosition(Vector3 $blockPosition): void
    {
        $this->blockPosition = $blockPosition;
    }

    /**
     * @return int
     */
    public function getBlockFace(): int
    {
        return $this->blockFace;
    }

    /**
     * @param int $blockFace
     */
    public function setBlockFace(int $blockFace): void
    {
        $this->blockFace = $blockFace;
    }
}