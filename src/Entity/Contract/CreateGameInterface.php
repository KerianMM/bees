<?php

namespace App\Entity\Contract;

interface CreateGameInterface
{
    /**
     * A game should be created with
     *  - 1 Queen
     *  - 5 Workers
     *  - 8 Scouts
     */
    public function createGame(): void;
}