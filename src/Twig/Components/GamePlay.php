<?php

namespace App\Twig\Components;

use App\Entity\Bee;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class GamePlay
{
    use DefaultActionTrait;

    #[LiveProp]
    public int $gameId;

    public function __construct(
        private EntityManagerInterface $manager,
    )
    {
    }

    /**
     * @return Bee[]
     */
    public function getBees(): array
    {
        return $this->getGame()->getBees()->getValues();
    }

    public function isGameOver(): bool
    {
        return $this->getGame()->isEnded();
    }

    #[LiveAction]
    public function hit(): void
    {
        $this->getGame()->hit();
        $this->manager->flush();
    }

    private function getGame(): Game
    {
        return $this->manager->find(Game::class, $this->gameId)
            ?? throw new NotFoundHttpException(sprintf('Game "%s" not found', $this->gameId));
    }
}
