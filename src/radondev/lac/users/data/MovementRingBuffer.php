<?php

declare(strict_types=1);

namespace radondev\lac\users\data;

use radondev\lac\threading\player\PlayerMoveEventPacket;

class MovementRingBuffer extends RingBuffer
{
    /**
     * MovementRingBuffer constructor.
     * @param int $size
     */
    public function __construct(int $size)
    {
        parent::__construct($size);
    }

    /**
     * @param PlayerMoveEventPacket $packet
     */
    public function add($packet): void
    {
        if ($packet instanceof PlayerMoveEventPacket) {
            parent::add($packet);
        }
    }

    /**
     * @return float
     */
    public function getAverageDistance(): float
    {
        $distances = [];

        foreach ($this->objects as $movementPacket) {
            if ($movementPacket instanceof PlayerMoveEventPacket) {
                $distances[] = $movementPacket->getFrom()->distance($movementPacket->getTo());
            }
        }

        return array_sum($distances) / count($distances);
    }

    /**
     * @return float
     */
    public function getAverageMovementDelay(): float
    {
        $delay = [];

        foreach ($this->objects as $movementPacket) {
            if ($movementPacket instanceof PlayerMoveEventPacket) {
                $delay[] = $movementPacket->getTimeStamp();
            }
        }

        return array_sum($delay) / count($delay);
    }

    /**
     * @return float
     */
    public function getLastMovementDelay(): float
    {
        return $this->get(0) - $this->get(-1);
    }
}