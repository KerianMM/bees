<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameGatewayController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    #[Route('/', name: 'app_home')]
    public function __invoke(): Response
    {
        $game = new Game();
        $game->createGame();

        $this->manager->persist($game);
        $this->manager->flush();

        return $this->redirectToRoute('app_game', ['id' => $game->getId()]);
    }
}
