<?php

declare(strict_types=1);

namespace App\Domain\Conway;

class Cell
{
    const DEAD = 0;
    const ALIVE = 1;

    public function __construct(private int $x, private int $y, private int $state)
    {}

    public function __toString()
    {
        return (string) $this->getState();
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function isAlive(): bool
    {
        return $this->getState() === self::ALIVE;
    }

    public function isDead(): bool
    {
        return $this->getState() === self::DEAD;
    }

    public function computeForBoard(Board $board): self
    {
        return new Self(
            $this->x,
            $this->y,
            $this->computeCellState(
                NeighbourResolver::getForCellAndBoard($this, $board)
            )
        );
    }

    private function computeCellState(array $neighbours): int
    {
        // Birth rule: An empty, or “dead,” cell with precisely three “live” neighbors (full cells) becomes live.
        // Death rule: A live cell with zero or one neighbors dies of isolation; a live cell with four or more neighbors dies of overcrowding.
        // Survival rule: A live cell with two or three neighbors remains alive.

        $totalAlive = array_filter($neighbours,
            function($neighbour) {
                return $neighbour->isAlive();
            }
        );

        $aliveCount = count($totalAlive);

        if ($this->isAlive() && ($aliveCount == 2 || $aliveCount == 3)) {
            return self::ALIVE;
        }

        if ($this->isDead() && $aliveCount === 3) {
            return self::ALIVE;
        }

        return self::DEAD;
    }
}