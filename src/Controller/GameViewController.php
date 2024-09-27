<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameViewController extends AbstractController
{
    #[Route('/game/{id}', name: 'app_game')]
    public function __invoke(Game $game): Response
    {
        return $this->render('game/index.html.twig', [
            'game' => $game,
        ]);
    }
}
