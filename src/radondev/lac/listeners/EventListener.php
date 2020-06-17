<?php

declare(strict_types=1);

namespace radondev\lac\listeners;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityEffectAddEvent;
use pocketmine\event\entity\EntityEffectRemoveEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\level\Level;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\Player;
use radondev\lac\Loader;
use radondev\lac\tasks\ExchangeTask;
use radondev\lac\threading\block\BlockBreakEventPacket;
use radondev\lac\threading\block\BlockPlaceEventPacket;
use radondev\lac\threading\entity\EntityDamagedEventPacket;
use radondev\lac\threading\entity\PlayerAttackEventPacket;
use radondev\lac\threading\ExchangePacket;
use radondev\lac\threading\player\InventoryTransactionEventPacket;
use radondev\lac\threading\player\PlayerChatEventPacket;
use radondev\lac\threading\player\PlayerEffectAddEventPacket;
use radondev\lac\threading\player\PlayerEffectRemoveEventPacket;
use radondev\lac\threading\player\PlayerJoinEventPacket;
use radondev\lac\threading\player\PlayerMoveEventPacket;
use radondev\lac\threading\player\PlayerQuitEventPacket;
use radondev\lac\utils\Blocks;

class EventListener implements Listener
{
    /**
     * @var array $preJoinStorage
     */
    private $preJoinStorage;
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
     * @priority lowest
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
     * @priority lowest
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
     * @priority lowest
     */
    public function onQuit(PlayerQuitEvent $event): void
    {
        $packet = new PlayerQuitEventPacket($event->getPlayer()->getRawUniqueId());

        $this->exchangeTask->enqueue($packet);
    }

    /**
     * @param PlayerMoveEvent $event
     * @priority lowest
     */
    public function onMove(PlayerMoveEvent $event): void
    {
        $player = $event->getPlayer();
        $blocks = [];

        if ($player->getLevel() instanceof Level) {
            foreach ($player->getLevel()->getCollisionBlocks($player->getBoundingBox()) as $block) {
                $blocks[] = $block->getId();
            }

            $packet = new PlayerMoveEventPacket(
                $player->getRawUniqueId(),
                $event->getFrom(),
                $event->getTo(),
                $player->getYaw(),
                $player->getPitch(),
                $player->getDirectionVector(),
                $blocks,
                $player->getLevel()->getFolderName(),
                Blocks::getBlockBelow($player->getLevel(), $player)->getFrictionFactor()
            );

            $this->exchangeTask->enqueue($packet);
        }
    }

    /**
     * @param PlayerChatEvent $event
     * @priority lowest
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
     * @priority lowest
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
     * @priority lowest
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
     * @priority lowest
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
     * @priority lowest
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
     * @priority lowest
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

    /**
     * @param InventoryTransactionEvent $event
     * @priority lowest
     */
    public function onInventoryTransaction(InventoryTransactionEvent $event): void
    {
        $packet = new InventoryTransactionEventPacket(
            $event->getTransaction()->getSource()->getRawUniqueId(),
            $event->getTransaction()->getActions(),
        );

        $this->exchangeTask->enqueue($packet);
    }
}