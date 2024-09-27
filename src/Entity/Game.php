<?php

namespace App\Entity;

use App\Entity\Contract\CreateGameInterface;
use App\Entity\Contract\GameStateInterface;
use App\Entity\Contract\PlayGameInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Game implements CreateGameInterface, GameStateInterface, PlayGameInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Bee>
     */
    #[ORM\OneToMany(targetEntity: Bee::class, mappedBy: 'game', cascade: ['persist'])]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $bees;

    public function __construct()
    {
        $this->bees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Bee>
     */
    public function getBees(): Collection
    {
        return $this->bees;
    }

    public function addBee(Bee $bee): static
    {
        if (!$this->bees->contains($bee)) {
            $this->bees->add($bee);
            $bee->setGame($this);
        }

        return $this;
    }

    public function removeBee(Bee $bee): static
    {
        if ($this->bees->removeElement($bee)) {
            // set the owning side to null (unless already changed)
            if ($bee->getGame() === $this) {
                $bee->setGame(null);
            }
        }

        return $this;
    }

    public function createGame(): void
    {
        $this->addBee((new Queen())->prepareForGame());

        $this->addBee((new Scout())->prepareForGame());
        $this->addBee((new Scout())->prepareForGame());
        $this->addBee((new Scout())->prepareForGame());
        $this->addBee((new Scout())->prepareForGame());
        $this->addBee((new Scout())->prepareForGame());
        $this->addBee((new Scout())->prepareForGame());
        $this->addBee((new Scout())->prepareForGame());
        $this->addBee((new Scout())->prepareForGame());

        $this->addBee((new Worker())->prepareForGame());
        $this->addBee((new Worker())->prepareForGame());
        $this->addBee((new Worker())->prepareForGame());
        $this->addBee((new Worker())->prepareForGame());
        $this->addBee((new Worker())->prepareForGame());
    }

    public function isEnded(): bool
    {
        foreach ($this->bees as $scout) {
            if ($scout->isAlive()) {
                return false;
            }
        }

        return true;
    }

    public function restart(): Game
    {
        if (!$this->isEnded()) {
            throw new \DomainException('You cannot restart a game until its ended.');
        }

        $game = new Game();
        $game->createGame();

        return $game;
    }

    public function hit(): void
    {
        $beesAlive = $this->bees
            ->filter(static fn (Bee $bee) => $bee->isAlive());

        $key = array_rand($beesAlive->toArray());
        $bee = $this->bees->get($key);

        if (!$bee instanceof Bee) {
            throw new \LogicException(sprintf('Random Bee with key "%s" in "%s" not found', $key, implode(',', $beesAlive->getKeys())));
        }

        $bee->hit();
        if (!$bee->isAlive() && $bee instanceof Queen) {
            foreach ($this->bees as $bee) {
                $bee->kill();
            }
        }
    }
}
