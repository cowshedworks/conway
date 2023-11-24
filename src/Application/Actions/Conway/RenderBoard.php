<?php

declare(strict_types=1);

namespace App\Application\Actions\Conway;

use App\Application\Actions\Action;
use App\Domain\Conway\Board;
use Psr\Http\Message\ResponseInterface as Response;

class RenderBoard extends Action
{
    protected function action(): Response
    {
        $this->logger->info("Board renderer called.");

        $cacheFile = '../var/cache/board.cache';

        if (!file_exists($cacheFile)) {
            file_put_contents($cacheFile, serialize(null));
        }

        $cachedBoard = unserialize(file_get_contents($cacheFile));

        $computedBoard = (new Board($cachedBoard))->compute();

        $board = $computedBoard->render();

        file_put_contents($cacheFile, serialize($board));

        return $this->respondWithHtml($this->getHtml($board));
    }

    private function getHtml($board): string
    {
        $limit = Board::LIMIT;

        $html = "<table border='0'>";
        for ($x = 0; $x < $limit; $x++) {
            $html .= "<tr>";
            for($y = 0; $y < $limit; $y++) {
                $html .= "<td style='border:1; padding:5px; background-color:". (($board[$x][$y] == 0) ? "#ffffff" : "#000000").";'><//td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";

        return $html;
    }
}
