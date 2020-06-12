<?php

declare(strict_types=1);

namespace radondev\lac\users;

use radondev\lac\users\data\MovementRingBuffer;

class User
{
    /**
     * @var MovementRingBuffer
     */
    private $movementRingBuffer;

    /**
     * @var string $rawUuid
     */
    private $rawUuid;

    /**
     * User constructor.
     * @param string $rawUuid
     */
    public function __construct(string $rawUuid)
    {
        $this->rawUuid = $rawUuid;
        $this->movementRingBuffer = new MovementRingBuffer($movementRingBufferSize = 20);
    }

    /**
     * @return string
     */
    public function getRawUuid(): string
    {
        return $this->rawUuid;
    }

    /**
     * @return MovementRingBuffer
     */
    public function getMovementRingBuffer(): MovementRingBuffer
    {
        return $this->movementRingBuffer;
    }
}