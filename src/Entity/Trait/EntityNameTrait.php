<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait EntityNameTrait
{
    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $slug;


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return EntityNameTrait
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

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
     * @return EntityNameTrait
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
