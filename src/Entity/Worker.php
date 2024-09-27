<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Worker extends Bee
{
    public function getHitMax(): int
    {
        return 50;
    }

    public function getHitDamages(): int
    {
        return 20;
    }

    public function __toString(): string
    {
        return 'Worker';
    }
}
