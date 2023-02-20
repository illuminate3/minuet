<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\DealType;
use App\Entity\Page;
use App\Entity\Property;
use App\Entity\User;
use App\Service\Cache\GetCache;

final class DashboardService
{

    use GetCache;

    public function countCategories(): int
    {
        return $this->getCount('categories_count', Category::class);
    }

    public function countPages(): int
    {
        return $this->getCount('pages_count', Page::class);
    }

    public function countUsers(): int
    {
        return $this->getCount('users_count', User::class);
    }

}
