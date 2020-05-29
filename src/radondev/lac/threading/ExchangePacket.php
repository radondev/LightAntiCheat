<?php

declare(strict_types=1);

namespace radondev\lac\threading;

class ExchangePacket
{
    /**
     * @var int
     */
    private $id;

    /**
     * ExchangePacket constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}