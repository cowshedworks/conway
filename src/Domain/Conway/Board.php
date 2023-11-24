<?php

declare(strict_types=1);

namespace App\Domain\Conway;

class Board
{
    public const LIMIT = 40;
    private array $board;

    public function __construct(?array $cachedBoard)
    {
        if (!$cachedBoard) {
            $this->build();
        } else {
            $this->hydrate($cachedBoard);
        }
    }

    public function compute(): self
    {
        for ($x = 0; $x < self::LIMIT; $x++) {
            for($y = 0; $y < self::LIMIT; $y++) {
                $this->board[$x][$y] = $this->board[$x][$y]->computeForBoard($this->board);
            }
        }

        return $this;
    }

    private function hydrate(array $cachedBoard): void
    {
        for ($x = 0; $x < self::LIMIT; $x++) {
            for($y = 0; $y < self::LIMIT; $y++) {
                $this->board[$x][$y] = new Cell($x, $y, (int) $cachedBoard[$x][$y], self::LIMIT-1);
            }
        }
    }

    private function build(): void
    {
        for ($x = 0; $x < self::LIMIT; $x++) {
            for($y = 0; $y < self::LIMIT; $y++) {
                $state = (int) (rand(0,100) > 99);
                $this->board[$x][$y] = new Cell($x, $y, $state, self::LIMIT-1);
            }
        }
    }

    public function render(): array
    {
        $this->compute();

        $rendered = [];
        
        for ($x = 0; $x < self::LIMIT; $x++) {
            for($y = 0; $y < self::LIMIT; $y++) {
                $rendered[$x][$y] = (string) $this->board[$x][$y];
            }
        }

        return $rendered;
    }
}
