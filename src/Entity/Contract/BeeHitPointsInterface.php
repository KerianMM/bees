<?php

namespace App\Entity\Contract;

interface BeeHitPointsInterface
{
    public function isAlive(): bool;

    public function isHit(): bool;

    public function getHitPoints(): int;

    public function getHitMax(): int;

    public function getHitDamages(): int;

    /**
     * Should remove hit points based on bee type
     *  - Queen loses 15 points
     *  - Scout loses 15 points
     *  - Worker loses 20 points
     *
     * Min enabled value is 0
     */
    public function hit(): void;

    public function kill(): void;

    public function prepareForGame(): static;
}