<?php

declare(strict_types=1);

namespace App\Domain\Conway;

class Cell
{
    const DEAD = 0;
    const ALIVE = 1;

    public function __construct(private int $x, private int $y, private int $state, private int $length)
    {}

    public function __toString()
    {
        return (string) $this->getState();
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function isAlive(): bool
    {
        return $this->getState() === self::ALIVE;
    }

    public function isDead(): bool
    {
        return $this->getState() === self::DEAD;
    }

    public function computeForBoard(array $board): self
    {
        return new Self(
            $this->x,
            $this->y,
            $this->computeCellState($this->getNeighbours($board)),
            $this->length
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

        if ($this->isDead() && $aliveCount === 3) {
            return self::ALIVE;
        }

        if ($this->isAlive() && ($aliveCount === 1 || $aliveCount === 0)) {
            return self::DEAD;
        }

        if ($this->isAlive() && $aliveCount >= 4) {
            return self::DEAD;
        }

        if ($aliveCount < 4 && $aliveCount > 1) {
            return self::ALIVE;
        }

        return $this->getState();
    }

    /**
     *  |x0,y0|x1,y0|x2,y0|
     *  |x0,y1|x1,y1|x2,y1|
     *  |x0,y2|x1,y2|x2,y2|
     *  |x0,y3|x1,y3|x2,y3|
     */
    private function getNeighbours(array $board): array
    {    
        return [
            $this->getTopNeighbour($board),
            $this->getLeftNeighbour($board),
            $this->getRightNeighbour($board),
            $this->getBottomNeighbour($board),
            $this->getTopRightNeighbour($board),
            $this->getTopLeftNeighbour($board),
            $this->getBottomRightNeighbour($board),
            $this->getBottomLeftNeighbour($board),
        ];
    }

    private function getTopNeighbour(array $board): Cell
    {
        return $board[$this->x][$this->y === 0 ? $this->length : $this->y - 1];
    }

    private function getLeftNeighbour(array $board): Cell
    {
        return $board[$this->x === 0 ? $this->length : $this->x - 1][$this->y];
    }

    private function getRightNeighbour(array $board): Cell
    {
        return $board[$this->x === $this->length ? 0 : $this->x + 1][$this->y];
    }

    private function getBottomNeighbour(array $board): Cell
    {
        return $board[$this->x][$this->y === $this->length ? 0 : $this->y + 1];
    }

    private function getTopRightNeighbour(array $board): Cell
    {
        return $board[$this->x === $this->length ? 0 : $this->x + 1][($this->y === 0) ? $this->length : $this->y - 1];
    }

    private function getTopLeftNeighbour(array $board): Cell
    {
        return $board[$this->x === 0 ? $this->length : $this->x - 1][($this->y === 0) ? $this->length : $this->y - 1];
    }

    private function getBottomRightNeighbour(array $board): Cell
    {
        return $board[$this->x === $this->length ? 0 : $this->x + 1][$this->y === $this->length ? 0 : $this->y + 1];
    }

    private function getBottomLeftNeighbour(array $board): Cell
    {
        return $board[$this->x === 0 ? $this->length : $this->x - 1][$this->y === $this->length ? 0 : $this->y + 1];
    }
}