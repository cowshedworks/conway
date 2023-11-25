<?php

declare(strict_types=1);

namespace App\Domain\Conway;

class NeighbourResolver
{
    /**
     *  |x0,y0|x1,y0|x2,y0|
     *  |x0,y1|x1,y1|x2,y1|
     *  |x0,y2|x1,y2|x2,y2|
     *  |x0,y3|x1,y3|x2,y3|
     */
    public static function getForCellAndBoard(Cell $cell, Board $board): array
    {
        return [
            self::getTopNeighbour($cell, $board),
            self::getTopRightNeighbour($cell, $board),
            self::getRightNeighbour($cell, $board),
            self::getBottomRightNeighbour($cell, $board),
            self::getBottomNeighbour($cell, $board),
            self::getBottomLeftNeighbour($cell, $board),
            self::getLeftNeighbour($cell, $board),
            self::getTopLeftNeighbour($cell, $board),
        ];
    }

    private static function getTopNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX()][$cell->getY() === 0 ? $board->getLimit() : $cell->getY() - 1];
    }

    private static function getLeftNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX() === 0 ? $board->getLimit() : $cell->getX() - 1][$cell->getY()];
    }

    private static function getRightNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX() === $board->getLimit() ? 0 : $cell->getX() + 1][$cell->getY()];
    }

    private static function getBottomNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX()][$cell->getY() === $board->getLimit() ? 0 : $cell->getY() + 1];
    }

    private static function getTopRightNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX() === $board->getLimit() ? 0 : $cell->getX() + 1][($cell->getY() === 0) ? $board->getLimit() : $cell->getY() - 1];
    }

    private static function getTopLeftNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX() === 0 ? $board->getLimit() : $cell->getX() - 1][($cell->getY() === 0) ? $board->getLimit() : $cell->getY() - 1];
    }

    private static function getBottomRightNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX() === $board->getLimit() ? 0 : $cell->getX() + 1][$cell->getY() === $board->getLimit() ? 0 : $cell->getY() + 1];
    }

    private static function getBottomLeftNeighbour(Cell $cell, Board $board): Cell
    {
        return $board[$cell->getX() === 0 ? $board->getLimit() : $cell->getX() - 1][$cell->getY() === $board->getLimit() ? 0 : $cell->getY() + 1];
    }
}