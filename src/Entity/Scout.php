<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Scout extends Bee
{
    public function getHitMax(): int
    {
        return 30;
    }

    public function getHitDamages(): int
    {
        return 15;
    }

    public function __toString(): string
    {
        return 'Scout';
    }
}
