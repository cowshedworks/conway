<?php

declare(strict_types=1);

namespace App\Application\Actions\Conway;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteCache extends Action
{
    protected function action(): Response
    {
        $this->logger->info("Board cache deleted.");

        $cacheFile = '../var/cache/board.cache';
        unlink($cacheFile);

        return $this->respondWithHtml('Clear Cache');
    }
}
