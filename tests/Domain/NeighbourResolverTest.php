<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Domain\Conway\Board;
use App\Domain\Conway\Cell;
use App\Domain\Conway\NeighbourResolver;
use Tests\TestCase;

class NeighbourResolverTest extends TestCase
{
    public function testTopRightCellNeighbours()
    {
        $board = new Board(10, null);
        $cell = new Cell(x:0, y:0, state:0);
        $neighbours = NeighbourResolver::getForCellAndBoard($cell, $board);

        // Top 
        $this->assertEquals(0, $neighbours[0]->getX());
        $this->assertEquals(9, $neighbours[0]->getY());

        // Top Right
        $this->assertEquals(1, $neighbours[1]->getX());
        $this->assertEquals(9, $neighbours[1]->getY());

        // Right
        $this->assertEquals(1, $neighbours[2]->getX());
        $this->assertEquals(0, $neighbours[2]->getY());

        // Bottom Right
        $this->assertEquals(1, $neighbours[3]->getX());
        $this->assertEquals(1, $neighbours[3]->getY());

        // Bottom
        $this->assertEquals(0, $neighbours[4]->getX());
        $this->assertEquals(1, $neighbours[4]->getY());

        // Bottom Left
        $this->assertEquals(9, $neighbours[5]->getX());
        $this->assertEquals(1, $neighbours[5]->getY());

        // Left
        $this->assertEquals(9, $neighbours[6]->getX());
        $this->assertEquals(0, $neighbours[6]->getY());

        // Top Left
        $this->assertEquals(9, $neighbours[7]->getX());
        $this->assertEquals(9, $neighbours[7]->getY());
    }

    public function testBottomRightCellNeighbours()
    {
        $board = new Board(10, null);
        $cell = new Cell(x:0, y:9, state:0);
        $neighbours = NeighbourResolver::getForCellAndBoard($cell, $board);

        // Top 
        $this->assertEquals(0, $neighbours[0]->getX());
        $this->assertEquals(8, $neighbours[0]->getY());

        // Top Right
        $this->assertEquals(1, $neighbours[1]->getX());
        $this->assertEquals(8, $neighbours[1]->getY());

        // Right
        $this->assertEquals(1, $neighbours[2]->getX());
        $this->assertEquals(9, $neighbours[2]->getY());

        // Bottom Right
        $this->assertEquals(1, $neighbours[3]->getX());
        $this->assertEquals(0, $neighbours[3]->getY());

        // Bottom
        $this->assertEquals(0, $neighbours[4]->getX());
        $this->assertEquals(0, $neighbours[4]->getY());

        // Bottom Left
        $this->assertEquals(9, $neighbours[5]->getX());
        $this->assertEquals(0, $neighbours[5]->getY());

        // Left
        $this->assertEquals(9, $neighbours[6]->getX());
        $this->assertEquals(9, $neighbours[6]->getY());

        // Top Left
        $this->assertEquals(9, $neighbours[7]->getX());
        $this->assertEquals(8, $neighbours[7]->getY());
    }
}