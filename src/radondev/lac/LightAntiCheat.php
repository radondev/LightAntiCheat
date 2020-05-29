<?php

declare(strict_types=1);

namespace radondev\lac;

use ClassLoader;
use pocketmine\Thread;
use radondev\lac\threading\ExchangePacket;
use Threaded;
use ThreadedLogger;

class LightAntiCheat extends Thread
{
    public const THREAD_SLEEP = 1.01;

    /**
     * @var ThreadedLogger
     */
    private $logger;
    /**
     * @var Threaded
     */
    private $inQueue;
    /**
     * @var Threaded
     */
    private $outQueue;
    /**
     * @var bool
     */
    private $state;

    /**
     * LightAntiCheat constructor.
     * @param ClassLoader $classLoader
     * @param ThreadedLogger $logger
     */
    public function __construct(ClassLoader $classLoader, ThreadedLogger $logger)
    {
        $this->logger = $logger;
        $this->inQueue = new Threaded();
        $this->outQueue = new Threaded();
        $this->state = true;

        $this->setClassLoader($classLoader);
        $this->start();
    }

    public function run(): void
    {
        $this->registerClassLoader();

        while ($this->state) {
            $start = microtime(true);

            // processing

            $end = microtime(true);
            if (($deltaT = $end - $start) < self::THREAD_SLEEP) {
                @time_sleep_until($end + self::THREAD_SLEEP - $deltaT);
            }
        }
    }

    public function quit()
    {
        $this->state = false;
        $this->logger->info("Stopping LightAntiCheat thread");

        parent::quit();
    }

    /**
     * @param ExchangePacket $packet
     */
    public function inEnqueue(ExchangePacket $packet): void
    {
        $this->inQueue[] = $packet;
    }

    /**
     * @return null|ExchangePacket
     */
    public function inDequeue(): ?ExchangePacket
    {
        return $this->inQueue->shift();
    }

    /**
     * @return int
     */
    public function inSize(): int
    {
        return $this->inQueue->count();
    }

    /**
     * @return Threaded
     */
    public function getInQueue(): Threaded
    {
        return $this->inQueue;
    }

    /**
     * @param ExchangePacket $packet
     */
    public function outEnqueue(ExchangePacket $packet): void
    {
        $this->outQueue[] = $packet;
    }

    /**
     * @return null|ExchangePacket
     */
    public function outDequeue(): ?ExchangePacket
    {
        return $this->outQueue->shift();
    }

    /**
     * @return int
     */
    public function outSize(): int
    {
        return $this->outQueue->count();
    }

    /**
     * @return Threaded
     */
    public function getOutQueue(): Threaded
    {
        return $this->outQueue;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->state;
    }

    /**
     * @param bool $state
     */
    public function setState(bool $state): void
    {
        $this->state = $state;
    }
}