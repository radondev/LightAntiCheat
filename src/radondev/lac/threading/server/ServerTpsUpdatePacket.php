<?php

declare(strict_types=1);

namespace radondev\lac\threading\server;

use radondev\lac\threading\ExchangePacket;
use radondev\lac\threading\Info;

class ServerTpsUpdatePacket extends ExchangePacket
{
    /**
     * @var float
     */
    private $last;
    /**
     * @var float
     */
    private $average;

    /**
     * ServerTpsUpdatePacket constructor.
     * @param float $last
     * @param float $average
     */
    public function __construct(float $last, float $average)
    {
        $this->last = $last;
        $this->average = $average;

        parent::__construct(Info::SERVER_TPS_UPDATE_PACKET);
    }

    /**
     * @return float
     */
    public function getLast(): float
    {
        return $this->last;
    }

    /**
     * @param float $last
     */
    public function setLast(float $last): void
    {
        $this->last = $last;
    }

    /**
     * @return float
     */
    public function getAverage(): float
    {
        return $this->average;
    }

    /**
     * @param float $average
     */
    public function setAverage(float $average): void
    {
        $this->average = $average;
    }
}