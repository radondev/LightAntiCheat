<?php

declare(strict_types=1);

namespace radondev\lac\tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use radondev\lac\LightAntiCheat;
use radondev\lac\Loader;
use radondev\lac\threading\ExchangePacket;
use radondev\lac\threading\Info;
use radondev\lac\threading\player\PlayerViolationPacket;
use radondev\lac\threading\server\ServerTpsUpdatePacket;
use radondev\lac\utils\MessageBuilder;
use SplQueue;

class ExchangeTask extends Task
{
    /**
     * @var Server
     */
    private $server;
    /**
     * @var LightAntiCheat
     */
    private $lightAntiCheat;
    /**
     * @var PunishmentTask
     */
    private $punishmentTask;
    /**
     * @var SplQueue
     */
    private $inQueue;

    /**
     * ExchangeTask constructor.
     */
    public function __construct()
    {
        $this->server = Loader::getInstance()->getServer();
        $this->lightAntiCheat = Loader::getInstance()->getLightAntiCheat();
        $this->punishmentTask = Loader::getInstance()->getPunishmentTask();
        $this->inQueue = new SplQueue();
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick): void
    {
        // delimiter packet between two runs
        $this->enqueue(
            new ServerTpsUpdatePacket($currentTick, Loader::getInstance()->getServer()->getTicksPerSecondAverage())
        );

        // push packets
        while (($packet = $this->dequeue()) !== null) {
            $this->lightAntiCheat->inEnqueue($packet);
        }

        // read packets
        while (($packet = Loader::getInstance()->getLightAntiCheat()->outDequeue()) !== null) {
            switch ($packet->getId()) {
                case Info::PLAYER_VIOLATION_PACKET:
                    if ($packet instanceof PlayerViolationPacket) {
                        if (($player = $this->server->getPlayerByRawUUID($packet->getRawUUID())) instanceof Player) {
                            $name = $player->getName();

                            $this->punishmentTask->add($name, $packet);
                        }
                    }
                    break;
                default:
                    Loader::getInstance()->getLogger()->error(
                        MessageBuilder::error("Scrapping received packet [id: %s]", [$packet->getId()])
                    );
                    Loader::getInstance()->getLogger()->error(
                        MessageBuilder::error("Report this to the author(s)")
                    );
            }
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