<?php

declare(strict_types=1);

namespace App\Service\Cache;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

trait ClearCache
{

    /**
     * @param  string  $key
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function clearCache(string $key): void
    {
        $cache = new FilesystemAdapter();
        $cache->delete($key);
    }

}
