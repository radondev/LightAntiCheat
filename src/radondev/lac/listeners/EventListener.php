<?php

namespace radondev\lac\listeners;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityEffectAddEvent;
use pocketmine\event\entity\EntityEffectRemoveEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\Player;
use radondev\lac\Loader;
use radondev\lac\tasks\ExchangeTask;
use radondev\lac\threading\block\BlockBreakEventPacket;
use radondev\lac\threading\block\BlockPlaceEventPacket;
use radondev\lac\threading\entity\EntityDamagedEventPacket;
use radondev\lac\threading\entity\PlayerAttackEventPacket;
use radondev\lac\threading\ExchangePacket;
use radondev\lac\threading\player\PlayerChatEventPacket;
use radondev\lac\threading\player\PlayerEffectAddEventPacket;
use radondev\lac\threading\player\PlayerEffectRemoveEventPacket;
use radondev\lac\threading\player\PlayerInteractEventPacket;
use radondev\lac\threading\player\PlayerJoinEventPacket;
use radondev\lac\threading\player\PlayerMoveEventPacket;
use radondev\lac\threading\player\PlayerQuitEventPacket;

class EventListener implements Listener
{
    /**
     * @var array $preJoinStorage
     */
    private $preJoinStorage; // TODO very primitive
    /**
     * @var ExchangeTask
     */
    private $exchangeTask;

    /**
     * EventListener constructor.
     */
    public function __construct()
    {
        $this->exchangeTask = Loader::getInstance()->getExchangeTask();
    }

    /**
     * @param DataPacketReceiveEvent $event
     */
    public function onPacketReceive(DataPacketReceiveEvent $event): void
    {
        $packet = $event->getPacket();

        if ($packet instanceof LoginPacket) {
            $this->preJoinStorage[$packet->clientUUID] = $packet->clientData;
        }
    }

    /**
     * @param PlayerJoinEvent $event
     */
    public function onJoin(PlayerJoinEvent $event): void
    {
        $rawUuid = $event->getPlayer()->getRawUniqueId();

        $packet = new PlayerJoinEventPacket(
            $rawUuid,
            $event->getPlayer()->getAddress(),
            $this->preJoinStorage[$rawUuid]["DeviceOS"]
        );

        $this->exchangeTask->enqueue($packet);
    }

    /**
     * @param PlayerQuitEvent $event
     */
    public function onQuit(PlayerQuitEvent $event): void
    {
        $packet = new PlayerQuitEventPacket($event->getPlayer()->getRawUniqueId());

        $this->exchangeTask->enqueue($packet);
    }

    /**
     * @param PlayerMoveEvent $event
     */
    public function onMove(PlayerMoveEvent $event): void
    {
        $player = $event->getPlayer();

        $packet = new PlayerMoveEventPacket(
            $player->getRawUniqueId(),
            $event->getFrom(),
            $event->getTo(),
            $player->getYaw(),
            $player->getPitch(),
            $player->getLevel()->getFolderName(),
            $player->getLevel()->getBlock($player->getPosition()->subtract(0, 1, 0))->getFrictionFactor() // TODO Move to utils
        );

        $this->exchangeTask->enqueue($packet);
    }

    /**
     * @param PlayerInteractEvent $event
     */
    public function onInteract(PlayerInteractEvent $event): void
    {
        $packet = new PlayerInteractEventPacket(
            $event->getPlayer()->getRawUniqueId(),
            $event->getItem()->getId(),
            $event->getAction(),
            $event->getBlock()->getId(),
            $event->getBlock(),
            $event->getFace()
        );

        $this->exchangeTask->enqueue($packet);
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function onChat(PlayerChatEvent $event): void
    {
        $packet = new PlayerChatEventPacket(
            $event->getPlayer()->getRawUniqueId(),
            $event->getMessage()
        );

        $this->exchangeTask->enqueue($packet);
    }

    /**
     * @param EntityDamageEvent $event
     */
    public function onEntityDamage(EntityDamageEvent $event): void
    {
        $packet = null;
        $entity = $event->getEntity();

        if ($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();

            if ($damager instanceof Player) {
                $packet = new PlayerAttackEventPacket(
                    $damager->getRawUniqueId(),
                    $damager,
                    $entity,
                    $event->getCause(),
                    $event->getKnockBack(),
                    $damager->getYaw(),
                    $damager->getPitch()
                );
            }
        } else { // Seems like a useless check, but allows a visually better structure and the ignorance of the other events
            $packet = new EntityDamagedEventPacket(
                $entity->getId(),
                $entity,
                $event->getCause()
            );
        }

        if ($packet instanceof ExchangePacket) {
            $this->exchangeTask->enqueue($packet);
        }
    }

    /**
     * @param EntityEffectAddEvent $event
     */
    public function onEffectAdd(EntityEffectAddEvent $event): void
    {
        $entity = $event->getEntity();

        if ($entity instanceof Player) {
            $packet = new PlayerEffectAddEventPacket(
                $entity->getRawUniqueId(),
                $event->getEffect()->getId(),
                $event->getEffect()->getEffectLevel()
            );

            $this->exchangeTask->enqueue($packet);
        }
    }

    /**
     * @param EntityEffectRemoveEvent $event
     */
    public function onEffectRemove(EntityEffectRemoveEvent $event): void
    {
        $entity = $event->getEntity();

        if ($entity instanceof Player) {
            $packet = new PlayerEffectRemoveEventPacket(
                $entity->getRawUniqueId(),
                $event->getEffect()->getId(),
            );

            $this->exchangeTask->enqueue($packet);
        }
    }

    /**
     * @param BlockBreakEvent $event
     */
    public function onBlockBreak(BlockBreakEvent $event): void
    {
        $packet = new BlockBreakEventPacket(
            $event->getPlayer()->getRawUniqueId(),
            $event->getBlock(),
            $event->getBlock()->getId()
        );

        $this->exchangeTask->enqueue($packet);
    }

    /**
     * @param BlockPlaceEvent $event
     */
    public function onBlockPlace(BlockPlaceEvent $event): void
    {
        $packet = new BlockPlaceEventPacket(
            $event->getPlayer()->getRawUniqueId(),
            $event->getBlock(),
            $event->getBlock()->getId()
        );

        $this->exchangeTask->enqueue($packet);
    }
}