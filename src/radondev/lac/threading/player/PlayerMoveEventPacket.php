<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use pocketmine\math\Vector3;
use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerMoveEventPacket extends PlayerExchangePacket
{
    /**
     * @var Vector3
     */
    private $from;
    /**
     * @var Vector3
     */
    private $to;
    /**
     * @var float
     */
    private $yaw;
    /**
     * @var float
     */
    private $pitch;
    /**
     * @var Vector3
     */
    private $directionVector;
    /**
     * @var int[]
     */
    private $collidingBlocks;
    /**
     * @var string
     */
    private $level;
    /**
     * @var float
     */
    private $currentFriction;

    /**
     * PlayerMoveEventPacket constructor.
     * @param string $rawUuid
     * @param Vector3 $from
     * @param Vector3 $to
     * @param float $yaw
     * @param float $pitch
     * @param Vector3 $directionVector
     * @param array $collidingBlocks
     * @param string $level
     * @param float $currentFriction
     */
    public function __construct(string $rawUuid, Vector3 $from, Vector3 $to, float $yaw, float $pitch, Vector3 $directionVector, array $collidingBlocks, string $level, float $currentFriction)
    {
        $this->from = clone $from;
        $this->to = clone $to;
        $this->yaw = $yaw;
        $this->pitch = $pitch;
        $this->directionVector = clone $directionVector;
        $this->collidingBlocks = $collidingBlocks;
        $this->level = $level;
        $this->currentFriction = $currentFriction;

        parent::__construct(Info::PLAYER_MOVE_EVENT_PACKET, $rawUuid);
    }

    /**
     * @return Vector3
     */
    public function getFrom(): Vector3
    {
        return $this->from;
    }

    /**
     * @param Vector3 $from
     */
    public function setFrom(Vector3 $from): void
    {
        $this->from = $from;
    }

    /**
     * @return Vector3
     */
    public function getTo(): Vector3
    {
        return $this->to;
    }

    /**
     * @param Vector3 $to
     */
    public function setTo(Vector3 $to): void
    {
        $this->to = $to;
    }

    /**
     * @return float
     */
    public function getYaw(): float
    {
        return $this->yaw;
    }

    /**
     * @param float $yaw
     */
    public function setYaw(float $yaw): void
    {
        $this->yaw = $yaw;
    }

    /**
     * @return float
     */
    public function getPitch(): float
    {
        return $this->pitch;
    }

    /**
     * @param float $pitch
     */
    public function setPitch(float $pitch): void
    {
        $this->pitch = $pitch;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel(string $level): void
    {
        $this->level = $level;
    }

    /**
     * @return float
     */
    public function getCurrentFriction(): float
    {
        return $this->currentFriction;
    }

    /**
     * @param float $currentFriction
     */
    public function setCurrentFriction(float $currentFriction): void
    {
        $this->currentFriction = $currentFriction;
    }
}