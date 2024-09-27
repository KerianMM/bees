<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Bee;
use App\Entity\Game;
use App\Entity\Queen;
use App\Entity\Scout;
use App\Entity\Worker;
use PHPUnit\Framework\TestCase;

class GameUnitTest extends TestCase
{
    public function testCreateGame(): void
    {
        $game = new Game();
        $game->createGame();

        $this->assertGameInitialized($game);
    }

    public function testRestartGame(): void
    {
        $game = new Game();
        $game->createGame();

        foreach ($game->getBees() as $bee) {
            $bee->kill();
        }

        $newGame = $game->restart();
        $this->assertGameInitialized($newGame);
    }

    public function testHitQueen(): void
    {
        $game = new Game();
        $game->addBee($queen = (new Queen())->prepareForGame());
        $game->addBee($scout = $this->createMock(Bee::class));
        $game->addBee($worker = $this->createMock(Bee::class));

        $scout->expects(self::exactly(8))->method('isAlive')->willReturn(false);
        $worker->expects(self::exactly(8))->method('isAlive')->willReturn(false);
        $scout->expects(self::once())->method('kill');
        $worker->expects(self::once())->method('kill');

        // Will not kill the queen
        $game->hit();

        self::assertTrue($queen->isAlive());
        self::assertTrue($queen->isHit());

        $game->hit();
        $game->hit();
        $game->hit();
        $game->hit();
        $game->hit();

        self::assertTrue($queen->isAlive());
        self::assertFalse($game->isEnded());

        // Queen's hit points = 10 => she will be killed
        $game->hit();

        self::assertFalse($queen->isAlive());
        self::assertTrue($game->isEnded());
    }

    private function assertGameInitialized(Game $game): void
    {
        $countQueen  = 0;
        $countScout  = 0;
        $countWorker = 0;

        foreach ($game->getBees() as $bee) {
            switch ($bee::class) {
                case Queen::class:
                    $countQueen++;
                    break;
                case Scout::class:
                    $countScout++;
                    break;
                case Worker::class:
                    $countWorker++;
                    break;
                default:
                    throw new \LogicException(sprintf('Unexpected bee type "%s"', $bee::class));
            }

            self::assertFalse($bee->isHit());
        }

        self::assertSame(1, $countQueen);
        self::assertSame(8, $countScout);
        self::assertSame(5, $countWorker);

        self::assertFalse($game->isEnded());
    }
}