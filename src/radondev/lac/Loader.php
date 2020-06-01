<?php

declare(strict_types=1);

namespace radondev\lac;

use pocketmine\plugin\PluginBase;
use radondev\lac\commands\LACCommand;
use radondev\lac\listeners\EventListener;
use radondev\lac\tasks\ExchangeTask;

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

        $this->getScheduler()->scheduleRepeatingTask($this->exchangeTask, 1);
        $this->getServer()->getCommandMap()->registerAll("lightanticheat", [
            new LACCommand($this->getDescription()->getAuthors(), $this->getDescription()->getVersion())
        ]);
        $this->getServer()->getPluginManager()->registerEvents(
            new EventListener(), $this
        );
    }

    /**
     * @return Loader
     */
    public static function getInstance(): Loader
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
}