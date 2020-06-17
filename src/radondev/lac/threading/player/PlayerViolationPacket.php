<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerViolationPacket extends PlayerExchangePacket
{
    /**
     * @var int
     */
    private $punishment;
    /**
     * @var int
     */
    private $action;
    /**
     * @var int
     */
    private $flags;
    /**
     * @var float
     */
    private $violation;
    /**
     * @var float
     */
    private $relativeViolation;

    /**
     * PlayerViolationPacket constructor.
     * @param string $rawUuid
     * @param int $punishment
     * @param int $action
     * @param int $flags
     * @param float $violation
     * @param float $relativeViolation
     */
    public function __construct(string $rawUuid, int $punishment, int $action, int $flags, float $violation, float $relativeViolation)
    {
        $this->punishment = $punishment;
        $this->action = $action;
        $this->flags = $flags;
        $this->violation = $violation;
        $this->relativeViolation = $relativeViolation;

        parent::__construct(Info::PLAYER_VIOLATION_PACKET, $rawUuid);
    }

    /**
     * @return int
     */
    public function getPunishment(): int
    {
        return $this->punishment;
    }

    /**
     * @param int $punishment
     */
    public function setPunishment(int $punishment): void
    {
        $this->punishment = $punishment;
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
    public function getFlags(): int
    {
        return $this->flags;
    }

    /**
     * @param int $flags
     */
    public function setFlags(int $flags): void
    {
        $this->flags = $flags;
    }

    /**
     * @return float
     */
    public function getViolation(): float
    {
        return $this->violation;
    }

    /**
     * @param float $violation
     */
    public function setViolation(float $violation): void
    {
        $this->violation = $violation;
    }

    /**
     * @return float
     */
    public function getRelativeViolation(): float
    {
        return $this->relativeViolation;
    }

    /**
     * @param float $relativeViolation
     */
    public function setRelativeViolation(float $relativeViolation): void
    {
        $this->relativeViolation = $relativeViolation;
    }
}