<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Queen extends Bee
{
    public function getHitMax(): int
    {
        return 100;
    }

    public function getHitDamages(): int
    {
        return 15;
    }

    public function __toString(): string
    {
        return 'Queen';
    }
}
