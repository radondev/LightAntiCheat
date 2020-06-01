<?php

declare(strict_types=1);

namespace radondev\lac\threading;

abstract class ExchangePacket
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var float
     */
    private $timeStamp;

    /**
     * ExchangePacket constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->timeStamp = microtime(true);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getTimeStamp(): float
    {
        return $this->timeStamp;
    }
}