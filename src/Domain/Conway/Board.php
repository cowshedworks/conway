<?php

declare(strict_types=1);

namespace App\Domain\Conway;

use ArrayAccess;
use JsonSerializable;

class Board implements ArrayAccess, JsonSerializable
{
    private array $board;
    private int $size;

    public function __construct(int $size, ?Board $cachedBoard)
    {
        $this->size = $size;

        if (!$cachedBoard) {
            $this->build();
        } else {
            $this->hydrate($cachedBoard);
        }
    }

    public function offsetSet($offset, $value): void {
        if (is_null($offset)) {
            $this->board[] = $value;
        } else {
            $this->board[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool {
        return isset($this->board[$offset]);
    }

    public function offsetUnset($offset): void {
        unset($this->board[$offset]);
    }

    public function offsetGet($offset): mixed {
        return isset($this->board[$offset]) ? $this->board[$offset] : null;
    }

    public function asArray(): array
    {
        return $this->board;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getLimit(): int
    {
        return $this->getSize() - 1;
    }

    public function compute(): self
    {
        $newBoard = [];
        for ($x = 0; $x < $this->getSize(); $x++) {
            for($y = 0; $y < $this->getSize(); $y++) {
                $newBoard[$x][$y] = $this->board[$x][$y]->computeForBoard($this);
            }
        }

        $this->board = $newBoard;

        return $this;
    }

    private function hydrate(Board $cachedBoard): void
    {
        for ($x = 0; $x < $this->getSize(); $x++) {
            for($y = 0; $y < $this->getSize(); $y++) {
                $this->board[$x][$y] = new Cell($x, $y, $cachedBoard[$x][$y]->getState(), $this->getSize()-1);
            }
        }
    }

    private function build(): void
    {
        for ($x = 0; $x < $this->getSize(); $x++) {
            $state = 0;
            for($y = 0; $y < $this->getSize(); $y++) {
                $state = (int) (rand(0,1000) > 995);
                $this->board[$x][$y] = new Cell($x, $y, $state, $this->getSize()-1);
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return $this->board;
    }
}
