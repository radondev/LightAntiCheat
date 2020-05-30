<?php

namespace radondev\lac\tasks;

use pocketmine\scheduler\Task;
use radondev\lac\LightAntiCheat;
use radondev\lac\Loader;
use radondev\lac\threading\ExchangePacket;
use SplQueue;

class ExchangeTask extends Task
{
    /**
     * @var LightAntiCheat
     */
    private $lightAntiCheat;
    /**
     * @var SplQueue
     */
    private $inQueue;

    /**
     * ExchangeTask constructor.
     */
    public function __construct()
    {
        $this->lightAntiCheat = Loader::getInstance()->getLightAntiCheat();
        $this->inQueue = new SplQueue();
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick): void
    {
        // push packets
        while (($packet = $this->dequeue()) !== null) {
            $this->lightAntiCheat->inEnqueue($packet);
        }

        // read packets
        while (($packet = Loader::getInstance()->getLightAntiCheat()->outDequeue()) !== null) {
            // TODO Write to outQueue or pass packets on accordingly
        }
    }

    /**
     * @param ExchangePacket $packet
     */
    public function enqueue(ExchangePacket $packet): void
    {
        $this->inQueue->enqueue($packet);
    }

    /**
     * @return ExchangePacket|null
     */
    public function dequeue(): ?ExchangePacket
    {
        if ($this->size() > 0) {
            return $this->inQueue->dequeue();
        }
        return null;
    }

    public function size(): int
    {
        return $this->inQueue->count();
    }
}