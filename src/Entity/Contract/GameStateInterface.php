<?php

namespace App\Entity\Contract;

use App\Entity\Game;

interface GameStateInterface
{
    public function isEnded(): bool;

    public function restart(): Game;
}