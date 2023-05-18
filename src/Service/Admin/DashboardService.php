<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Page;
use App\Entity\User;
use App\Service\Cache\GetCache;
use Psr\Cache\InvalidArgumentException;

final class DashboardService
{

    use GetCache;

    /**
     * @throws InvalidArgumentException
     */
    public function countPages(): int
    {
        return $this->getCount('pages_count', Page::class);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function countUsers(): int
    {
        return $this->getCount('users_count', User::class);
    }

}
