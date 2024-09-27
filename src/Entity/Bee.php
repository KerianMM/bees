<?php

namespace App\Entity;

use App\Entity\Contract\BeeHitPointsInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
    'queen' => Queen::class,
    'scout' => Scout::class,
    'worker' => Worker::class,
])]
abstract class Bee implements BeeHitPointsInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column]
    protected ?int $hitPoints = null;

    #[ORM\ManyToOne(inversedBy: 'bees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }

    public function setHitPoints(int $hitPoints): static
    {
        $this->hitPoints = $hitPoints;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function prepareForGame(): static
    {
        $this->hitPoints = $this->getHitMax();

        return $this;
    }

    public function isAlive(): bool
    {
        return $this->hitPoints > 0;
    }

    public function isHit(): bool
    {
        return $this->hitPoints !== $this->getHitMax();
    }

    public function hit(): void
    {
        if ($this->getHitDamages() > $this->hitPoints) {
            $this->kill();
            return;
        }

        $this->hitPoints -= $this->getHitDamages();
    }

    public function kill(): void
    {
        $this->hitPoints = 0;
    }
}
