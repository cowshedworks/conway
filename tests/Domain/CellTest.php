<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Domain\Conway\Cell;
use Tests\TestCase;

class CellTest extends TestCase
{
    public function testCellsCanHaveState()
    {
        $cell = new Cell(x:0, y:0, state:0);

        $this->assertEquals(0, $cell->getState());

        $cell = new Cell(x:0, y:0, state:1);

        $this->assertEquals(1, $cell->getState());
    }
}