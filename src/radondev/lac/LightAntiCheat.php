<?php

declare(strict_types=1);

namespace radondev\lac;

use ClassLoader;
use pocketmine\Thread;
use radondev\lac\threading\block\BlockBreakEventPacket;
use radondev\lac\threading\block\BlockPlaceEventPacket;
use radondev\lac\threading\entity\EntityDamagedEventPacket;
use radondev\lac\threading\entity\PlayerAttackEventPacket;
use radondev\lac\threading\ExchangePacket;
use radondev\lac\threading\Info;
use radondev\lac\threading\player\InventoryTransactionEventPacket;
use radondev\lac\threading\player\PlayerChatEventPacket;
use radondev\lac\threading\player\PlayerEffectAddEventPacket;
use radondev\lac\threading\player\PlayerEffectRemoveEventPacket;
use radondev\lac\threading\player\PlayerJoinEventPacket;
use radondev\lac\threading\player\PlayerMoveEventPacket;
use radondev\lac\threading\player\PlayerQuitEventPacket;
use radondev\lac\users\User;
use radondev\lac\users\UserManager;
use Threaded;
use ThreadedLogger;

class LightAntiCheat extends Thread
{
    public const THREAD_TICK_SPEED = 0.01;

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
     * @var UserManager
     */
    private $userManager;

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
        $this->userManager = new UserManager();

        $this->setClassLoader($classLoader);
        $this->start();
    }

    public function run(): void
    {
        $this->registerClassLoader();

        while ($this->state) {
            $start = microtime(true);

            // processing
            $this->tick();

            $end = microtime(true);
            if (($deltaT = $end - $start) < self::THREAD_TICK_SPEED) {
                @time_sleep_until($end + self::THREAD_TICK_SPEED - $deltaT);
            }
        }
    }

    private function tick(): void
    {
        $packets = $this->readPackets();

        $out = $this->processPackets($packets);

        $this->pushPackets($out);
    }

    /**
     * @return ExchangePacket[]
     */
    private function readPackets(): array
    {
        $packets = [];

        while (($packet = $this->inDequeue()) !== null) {
            $packets[] = $packet;
        }

        return $packets;
    }

    /**
     * @param ExchangePacket[] $packets
     * @return ExchangePacket[]
     */
    private function processPackets(array $packets): array
    {
        $out = [];

        foreach ($packets as $packet) {
            switch ($packet->getId()) {
                // TODO Finish packet classification in v0.3 (introducing checks)

                case Info::PLAYER_JOIN_EVENT_PACKET:
                    if ($packet instanceof PlayerJoinEventPacket) {
                        $user = new User($packet->getRawUUID());

                        $this->userManager->registerUser($user);
                    }
                    break;
                case Info::PLAYER_QUIT_EVENT_PACKET:
                    if ($packet instanceof PlayerQuitEventPacket) {
                        $this->userManager->unregisterUser($packet->getRawUUID());
                    }
                    break;
                case Info::PLAYER_MOVE_EVENT_PACKET:
                    if ($packet instanceof PlayerMoveEventPacket) {

                    }
                    break;
                case Info::PLAYER_CHAT_EVENT_PACKET:
                    if ($packet instanceof PlayerChatEventPacket) {

                    }
                    break;
                case Info::PLAYER_ATTACK_EVENT_PACKET:
                    if ($packet instanceof PlayerAttackEventPacket) {

                    }
                    break;
                case Info::PLAYER_EFFECT_ADD_PACKET:
                    if ($packet instanceof PlayerEffectAddEventPacket) {

                    }
                    break;
                case Info::PLAYER_EFFECT_REMOVE_PACKET:
                    if ($packet instanceof PlayerEffectRemoveEventPacket) {

                    }
                    break;
                case Info::BLOCK_BREAK_EVENT_PACKET:
                    if ($packet instanceof BlockBreakEventPacket) {

                    }
                    break;
                case Info::BLOCK_PLACE_EVENT_PACKET:
                    if ($packet instanceof BlockPlaceEventPacket) {

                    }
                    break;
                case Info::ENTITY_DAMAGED_EVENT_PACKET:
                    if ($packet instanceof EntityDamagedEventPacket) {

                    }
                    break;
                case Info::INVENTORY_TRANSACTION_EVENT_PACKET:
                    if ($packet instanceof InventoryTransactionEventPacket) {

                    }
                    break;
            }
        }

        return $out;
    }

    /**
     * @param ExchangePacket[] $packets
     */
    private function pushPackets(array $packets): void
    {
        foreach ($packets as $packet) {
            $this->outEnqueue($packet);
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
     * @return ExchangePacket|null
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