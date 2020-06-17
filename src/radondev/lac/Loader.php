<?php

declare(strict_types=1);

namespace radondev\lac;

use pocketmine\plugin\PluginBase;
use radondev\lac\commands\LACCommand;
use radondev\lac\listeners\EventListener;
use radondev\lac\tasks\ExchangeTask;
use radondev\lac\tasks\PunishmentTask;
use radondev\lac\threading\server\ServerShareConfigPacket;

class Loader extends PluginBase
{
    /**
     * @var Loader
     */
    private static $instance;
    /**
     * @var LightAntiCheat
     */
    private $lightAntiCheat;
    /**
     * @var ExchangeTask
     */
    private $exchangeTask;
    /**
     * @var PunishmentTask
     */
    private $punishmentTask;

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->lightAntiCheat = new LightAntiCheat(
            $this->getServer()->getLoader(), $this->getServer()->getLogger()
        );
        $this->exchangeTask = new ExchangeTask();
        $this->punishmentTask = new PunishmentTask();

        $this->getScheduler()->scheduleRepeatingTask($this->exchangeTask, 1);
        $this->getScheduler()->scheduleRepeatingTask($this->punishmentTask, 1); // TODO use delay from config

        $this->getServer()->getCommandMap()->registerAll("lightanticheat", [
            new LACCommand($this->getDescription()->getAuthors(), $this->getDescription()->getVersion())
        ]);
        $this->getServer()->getPluginManager()->registerEvents(
            new EventListener(), $this
        );
        $this->sendInitializingPackets();
    }

    private function sendInitializingPackets(): void
    {
        $this->exchangeTask->enqueue(
            new ServerShareConfigPacket(
                $this->getConfig()->getAll()
            )
        );
    }

    /**
     * @return Loader
     */
    public static function &getInstance(): Loader
    {
        return self::$instance;
    }

    /**
     * @return LightAntiCheat
     */
    public function &getLightAntiCheat(): LightAntiCheat
    {
        return $this->lightAntiCheat;
    }

    /**
     * @return ExchangeTask
     */
    public function &getExchangeTask(): ExchangeTask
    {
        return $this->exchangeTask;
    }

    /**
     * @return PunishmentTask
     */
    public function &getPunishmentTask(): PunishmentTask
    {
        return $this->punishmentTask;
    }
}