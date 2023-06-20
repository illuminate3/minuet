<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Subscription;
use Doctrine\ORM\Mapping as ORM;

trait SlugTrait
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $slug;

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param  string  $slug
     *
     * @return SlugTrait|Category|Product|Subscription
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
