<?php

declare(strict_types=1);

namespace radondev\lac\threading;

class Info
{
    public const PLAYER_JOIN_EVENT_PACKET = 1;
    public const PLAYER_QUIT_EVENT_PACKET = 2;
    public const PLAYER_MOVE_EVENT_PACKET = 3;
    public const PLAYER_CHAT_EVENT_PACKET = 5;
    public const PLAYER_ATTACK_EVENT_PACKET = 6;
    public const PLAYER_EFFECT_ADD_PACKET = 7;
    public const PLAYER_EFFECT_REMOVE_PACKET = 8;
    public const PLAYER_VIOLATION_PACKET = 9;

    public const BLOCK_BREAK_EVENT_PACKET = 10;
    public const BLOCK_PLACE_EVENT_PACKET = 11;

    public const ENTITY_DAMAGED_EVENT_PACKET = 12;

    public const INVENTORY_TRANSACTION_EVENT_PACKET = 13;

    public const SERVER_TPS_UPDATE_PACKET = 14;
    public const SERVER_SHARE_CONFIG_PACKET = 15;
}