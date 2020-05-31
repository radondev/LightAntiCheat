<?php

declare(strict_types=1);

namespace radondev\lac\threading;

class Info
{
    public const PLAYER_JOIN_EVENT_PACKET = 1;
    public const PLAYER_QUIT_EVENT_PACKET = 2;
    public const PLAYER_MOVE_EVENT_PACKET = 3;
    public const PLAYER_INTERACT_EVENT_PACKET = 4;
    public const PLAYER_CHAT_EVENT_PACKET = 5;
    public const PLAYER_ATTACK_EVENT_PACKET = 6;
    public const PLAYER_EFFECT_ADD_PACKET = 7;
    public const PLAYER_EFFECT_REMOVE_PACKET = 8;

    public const BLOCK_BREAK_EVENT_PACKET = 9;
    public const BLOCK_PLACE_EVENT_PACKET = 10;

    public const ENTITY_DAMAGED_EVENT_PACKET = 11;
}